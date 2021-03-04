<?php
namespace Elogic\AdminCrud\Controller\Adminhtml\Post;

use Elogic\AdminCrud\Model\ResourceModel\StoreResourceModel;
use Elogic\AdminCrud\Model\StoreModel;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;

class Create extends Action
{
    /**
     * @var StoreResourceModel
     */
    private StoreResourceModel $resourceModel;
    /**
     * @var StoreModel
     */
    private StoreModel $storeModel;

    public function __construct(
        Context $context,
        StoreResourceModel $resourceModel,
        StoreModel $storeModel
    ) {
        parent::__construct($context);
        $this->resourceModel = $resourceModel;
        $this->storeModel = $storeModel;
    }


    public function execute()
    {
        $data = $this->getRequest()->getParams();
        unset($data['key']);
        unset($data['back']);
        unset($data['form_key']);


        /*$shop_name = $data['shop_name'];
        $description = $data['description'];
        $img_url = $data['img_url'];
        $shop_city = $data['shop_city'];
        $shop_zip = $data['shop_zip'];
        $shop_state = $data['shop_state'];
        $shop_address = $data['shop_address'];
        $work_schedule = $data['work_schedule'];
        $holiday_work_schedule = $data['holiday_work_schedule'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];*/

        $shopModel = $this->storeModel->setData($data);

        $this->resourceModel->save($shopModel);
        //RETURN ERROR ON VALIDATION FORM FAIL
        $this->messageManager->addSuccessMessage(__('Shop have been created.'));

        return $this->_redirect("admin_crud/maincontroller/index");
    }
}
