<?php

namespace Xertigo\MyMeasurements\Block;

class MyMeasurements extends \Magento\Framework\View\Element\Template
{
    public $_storeManager;
    public $measurements;
    public $customshirtCollection;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Xertigo\MyMeasurements\Model\ResourceModel\CustomShirt\Collection $customshirtCollection //,
    )
    {
        $this->customshirtCollection = $customshirtCollection;
        $this->_storeManager=$storeManager;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {

        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $om->create('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) {
            $customer_id = $customerSession->getCustomer()->getId();

            $this->customshirtCollection->addFieldToFilter('customer_id', $customer_id);

            $this->assign('measurements', $this->customshirtCollection);
        }
  
        $this->pageConfig->getTitle()->set(__('My Measurements'));

        return parent::_prepareLayout();
    }
}