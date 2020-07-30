<?php

namespace Xertigo\MyMeasurements\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Messages;

class Saveshirt extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $_resultRedirectFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
    
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $_formKeyValidator;
 
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager 
     * @param \Xertigo\MyMeasurements\Model\CustomShirtFactory $customshirtFactory 
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator  
     */
    public function __construct(Context $context, 
           \Magento\Customer\Model\Session $customerSession,
           \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
           \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
           \Magento\Framework\Message\ManagerInterface $messageManager,
           \Xertigo\MyMeasurements\Model\CustomShirtFactory $customshirtFactory, 
           \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator)
    {
        parent::__construct($context);

        $this->_session = $customerSession;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_messageManager = $messageManager;
        $this->customshirtFactory = $customshirtFactory;   
        $this->_formKeyValidator = $formKeyValidator;

    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {

       if (!$this->_session->isLoggedIn()) {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');

            return $resultRedirect;
        }

        $resultPage = $this->_resultPageFactory->create();

        $data = $this->getRequest()->getPostValue();

        if (!$this->_formKeyValidator->validate($this->getRequest()) || (!$data)) {

            return $this->_redirect('mymeasurements/index/createshirt');
        } 

        $this->_session->setData('customshirt_form', $data);
        
        try{

            $customer_id = $this->_session->getCustomer()->getId();

            $customshirt = $this->customshirtFactory->create();

            if (isset($data['xertigo_mymeasurements_customshirt_id']) && $data['xertigo_mymeasurements_customshirt_id'] == '') {
                unset($data['xertigo_mymeasurements_customshirt_id']);
            }

           //Validation
           $error = false;
          
           if ((!isset($data['fitStyle'])) || (!\Zend_Validate::is(trim($data['fitStyle']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['measurementName'])) || (!\Zend_Validate::is(trim($data['measurementName']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['whiteCollar'])) || (!\Zend_Validate::is(trim($data['whiteCollar']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['cuff'])) || (!\Zend_Validate::is(trim($data['cuff']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['pocket'])) || (!\Zend_Validate::is(trim($data['pocket']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['monogram'])) || (!\Zend_Validate::is(trim($data['monogram']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['monogramStyle'])) || (!\Zend_Validate::is(trim($data['monogramStyle']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['monogramColor'])) || (!\Zend_Validate::is(trim($data['monogramColor']), 'NotEmpty'))) {
                $error = true;
            }

           if ((!isset($data['monogramPlace'])) || (!\Zend_Validate::is(trim($data['monogramPlace']), 'NotEmpty'))) {
                $error = true;
            } 

           if ((!isset($data['measurementName'])) || (!\Zend_Validate::is(trim($data['measurementName']), 'NotEmpty'))) {
                $error = true;
            }

            if ($error) {
                throw new \Exception('Missing required field');
            }

           // Save to database
           $customshirt->setData($data);
           $customshirt->setData('customer_id',$customer_id);
           if( $customshirt->save()) {
               $this->_session->unsetData('customshirt_form');
        
            // Display the succes form validation message
               $this->_messageManager->addSuccess(__('Your Custom Shirt order has been saved.'));
           } else {
               throw new \Exception('Custom Shirt order did not get saved. Please try again!');
           }

           return $this->_redirect('mymeasurements/index/index');

       }catch (\Exception $e){

           $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e->getMessage());
           $this->_messageManager->addError(__('We were unable to submit your request. Please try again!'));

           return $this->_redirect('mymeasurements/index/createshirt');  
       }

    }
}