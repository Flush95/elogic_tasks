<?php
namespace Elogic\AdminCrud\Controller\Adminhtml\FormController;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class CreateForm extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
