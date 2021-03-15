<?php

declare(strict_types=1);

namespace Elogic\AdminCrud\Controller\Adminhtml\ImageUploader;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Upload extends Action
{
    protected $_fileUploaderFactory;
    private Filesystem $_filesystem;
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    public function __construct(
        Context $context,
        UploaderFactory $fileUploaderFactory,
        Filesystem $filesystem,
        JsonFactory $jsonFactory
    ) {
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
        $this->_filesystem = $filesystem;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'img_url']);

        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);

        $path = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('images/');

        $result = $uploader->save($path);
        $result['img_name'] = 'images/' . $uploader->getUploadedFileName();
        $result['url'] =  "/pub/media/images/" . $uploader->getUploadedFileName();

        return $resultJson->setData($result);
    }
}
