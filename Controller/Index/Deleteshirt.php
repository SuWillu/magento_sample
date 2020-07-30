<?php

namespace Xertigo\MyMeasurements\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Messages;

class Deleteshirt extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;
    protected $_resultRedirectFactory;
    protected $_resultPageFactory;
    protected $_messageManager;
 
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager 
     * @param \Xertigo\MyMeasurements\Model\CustomShirtFactory $customshirtFactory 
     */
    public function __construct(Context $context, 
            \Magento\Customer\Model\Session $customerSession,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
            \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
            \Magento\Framework\Message\ManagerInterface $messageManager,
            \Xertigo\MyMeasurements\Model\CustomShirtFactory $customshirtFactory)
    {
        $this->session = $customerSession; 
        $this->_resultRedirectFactory = $resultRedirectFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_messageManager = $messageManager;
        $this->customshirtFactory = $customshirtFactory;   
         
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
         if (!$this->session->isLoggedIn()) {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');

            return $resultRedirect;
        }
         
        $resultPage = $this->_resultPageFactory->create();

        try{

          $value = $this->getRequest()->getParam('id');
          $customshirt = $this->customshirtFactory->create();

          $customshirt->setId($value);
           if( $customshirt->delete()) {
               $this->_messageManager->addSuccess(__('Your Custom Shirt order has been deleted.'));
           } else {
               throw new \Exception('Your order did not get deleted, please try again!');
           }
     
           return $this->_redirect('mymeasurements/index/index');

        }catch (\Exception $e){

           $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e->getMessage());
           $this->_messageManager->addError(__('We were unable to submit your request. Please try again!'));


           return $this->_redirect('mymeasurements/index/index');  
       }

    }
}