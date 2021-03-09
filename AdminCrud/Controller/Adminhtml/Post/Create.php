<?php
namespace Elogic\AdminCrud\Controller\Adminhtml\Post;

use Elogic\AdminCrud\Helper\Geo;
use Elogic\AdminCrud\Model\ResourceModel\StoreResourceModel;
use Elogic\AdminCrud\Model\StoreModel;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Filesystem\Driver\File;

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
    /**
     * @var File
     */
    private File $file;
    /**
     * @var Geo
     */
    private Geo $geo;


    /**
     * Create constructor.
     * @param Context $context
     * @param StoreResourceModel $resourceModel
     * @param StoreModel $storeModel
     * @param File $file
     * @param Geo $geo
     */
    public function __construct(
        Context $context,
        StoreResourceModel $resourceModel,
        StoreModel $storeModel,
        File $file,
        Geo $geo
    ) {
        parent::__construct($context);
        $this->resourceModel = $resourceModel;
        $this->storeModel = $storeModel;
        $this->file = $file;
        $this->geo = $geo;
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        unset($data['key']);
        unset($data['back']);
        unset($data['form_key']);

        $fileName = $data['img_url'][0]['img_name'];

        $data['img_url'] = $fileName;

        if (empty($data['latitude'] && $data['longitude'])) {
            $geolocation = $this->geo->getCoordinates($data['shop_state'] . '+' . $data['shop_city'] . '+' . $data['shop_address']);
            $data['latitude'] = $geolocation['latitude'];
            $data['longitude'] = $geolocation['longitude'];
        }

        try {
            $shopModel = $this->storeModel->setData($data);
            $this->resourceModel->save($shopModel);
            $this->messageManager->addSuccessMessage(__('Shop have been created.'));
        } catch (AlreadyExistsException | \Exception $e) {
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
            $mediaRootDir = $mediaDirectory->getAbsolutePath();

            if ($this->file->isExists($mediaRootDir . $fileName)) {
                $this->file->deleteFile($mediaRootDir . $fileName);
            }
            $this->messageManager->addErrorMessage(__('Error occurred when creating shop.'));
        }
        return $this->_redirect("admin_crud/maincontroller/index");
    }

}
