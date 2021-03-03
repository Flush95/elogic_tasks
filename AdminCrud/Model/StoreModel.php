<?php

namespace Elogic\AdminCrud\Model;

use Elogic\AdminCrud\Model\ResourceModel\StoreResourceModel;
use Magento\Framework\Model\AbstractModel;

class StoreModel extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(StoreResourceModel::class);
    }
}
