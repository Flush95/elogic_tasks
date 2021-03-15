<?php
declare(strict_types=1);
namespace Elogic\AdminCrud\Controller\Adminhtml\Post;

use Elogic\AdminCrud\Model\Image\ImageUploader;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Upload extends Action
{
    public ImageUploader $imageUploader;
    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('img_url');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorCode' => $e->getCode()];
        }
        $resultJson = $this->jsonFactory->create();
        return $resultJson->setData($result);
    }
}
