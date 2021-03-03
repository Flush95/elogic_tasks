<?php

namespace Elogic\AdminCrud\Model\ResourceModel\StoreModelCollections;

use Elogic\AdminCrud\Model\ResourceModel\StoreResourceModel;
use Elogic\AdminCrud\Model\StoreModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'store_id';

    protected function _construct()
    {
        $this->_init(StoreModel::class, StoreResourceModel::class);
    }
}
