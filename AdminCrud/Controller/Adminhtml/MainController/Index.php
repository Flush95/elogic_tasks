<?php
namespace Elogic\AdminCrud\Controller\Adminhtml\MainController;


use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index implements ActionInterface
{
    const MENU_ID = 'Elogic_AdminCrud::crud';

    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        //$resultPage->getConfig()->getTitle()->prepend(__('Hello'));

        return $resultPage;
    }
}
