<?php

namespace Xertigo\MyMeasurements\Block;

class Customshirt extends \Magento\Framework\View\Element\Template
{
    public $_storeManager;
    public $_customerSession;
    public $_session;
    public $customshirt;
    public $_context;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $session,
        \Xertigo\MyMeasurements\Model\CustomShirtFactory $customshirtFactory 
    )
    {
        parent::__construct($context);

        $this->customshirtFactory = $customshirtFactory;
        $this->_storeManager = $storeManager;
        $this->_session = $session;
        $this->_context = $context;
    }

    function _prepareLayout()
    {
        if($this->_session->isLoggedIn()){
        
            $value = $this->getRequest()->getParam('id');
            if ($value) {
                $this->customshirt = $this->customshirtFactory->create();
                $this->customshirt->setId($value);
                $this->customshirt = $this->customshirt->load($value);        
            }
        } 
        $this->pageConfig->getTitle()->set(__('Add custom shirt'));

        return parent::_prepareLayout();
    }

    function getSession(){
        return $this->_session;
    }
}