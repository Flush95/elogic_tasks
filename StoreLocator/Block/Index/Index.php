<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Block\Index;

use Elogic\AdminCrud\Model\ShopRepository;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

class Index extends Template
{

    /**
     * CRUD constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getAllStores()
    {
        $objectManager = ObjectManager::getInstance();
        $collection = $objectManager->create('Elogic\AdminCrud\Model\ResourceModel\StoreModelCollections\Collection');
        return $collection;
    }

    public function getShopRepId()
    {
        $objectManager = ObjectManager::getInstance();

        /** @var ShopRepository $product */
        $product = $objectManager->create('Elogic\AdminCrud\Model\ShopRepository');

        try {
            $shop = $product->deleteShopById(13);
            var_dump($shop);
        } catch (NoSuchEntityException | CouldNotDeleteException $e) {
            echo $e->getMessage();
        }

    }
}
