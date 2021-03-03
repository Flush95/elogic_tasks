<?php

namespace Elogic\AdminCrud\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('elogic_shops', 'shop_id');
    }
}
