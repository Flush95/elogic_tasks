<?php
namespace Elogic\AdminCrud\Controller\Adminhtml\FormController;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class CreateForm extends Action
{

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
