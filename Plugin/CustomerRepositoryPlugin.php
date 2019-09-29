<?php

namespace Antonio88\OrderNote\Plugin;

use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerRepositoryPlugin
{
    /**
     * @var CustomerExtensionFactory
     */
    protected $customerExtensionFactory;
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    public function __construct(
        CustomerExtensionFactory $customerExtensionFactory,
        CustomerFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerExtensionFactory = $customerExtensionFactory;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param \Closure                    $proceed
     * @param                             $customerId
     *
     * @return CustomerInterface
     */
    public function aroundGetById(
        CustomerRepositoryInterface $subject,
        \Closure $proceed,
        $customerId
    ): CustomerInterface {
        /** @var CustomerInterface $customer */
        $customer = $proceed($customerId);

        // If extension attribute is already set, return early.
        if ($customer->getExtensionAttributes()
            && $customer->getExtensionAttributes()->getOrderNote()
        ) {
            return $customer;
        }

        if (!$customer->getExtensionAttributes()) {
            $customerExtension = $this->customerExtensionFactory->create();
            $customer->setExtensionAttributes($customerExtension);
        }

        $customerModel = $this->customerFactory->create()->load($customer->getId());
        $customer->getExtensionAttributes()
            ->setOrderNote(
                $customerModel->getData('order_note')
            );

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $customer
     *
     * @return CustomerInterface $customer
     */
    public function afterGet(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ): CustomerInterface {
        $this->addOrderNote($customer);
        return $customer;
    }

    /**
     * @param CustomerInterface               $customer
     * @param CustomerExtensionInterface|null $extension
     *
     * @return CustomerExtensionInterface
     */
    public function afterGetExtensionAttributes(
        CustomerInterface $customer,
        CustomerExtensionInterface $extension = null
    ): CustomerExtensionInterface {
        if ($extension === null) {
            $extension = $this->customerExtensionFactory->create();
        }

        return $extension;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return self
     */
    private function addOrderNote(CustomerInterface $customer)
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->customerExtensionFactory->create();
        }
        $customerModel = $this->customerFactory->create()->load($customer->getId());
        $orderNote = $customerModel->getData('order_note');
        $extensionAttributes->setOrderNote($orderNote);
        $customer->setExtensionAttributes($extensionAttributes);

        return $this;
    }
}