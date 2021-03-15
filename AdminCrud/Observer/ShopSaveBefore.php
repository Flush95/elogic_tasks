<?php
namespace Elogic\AdminCrud\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ShopSaveBefore implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        try {
            $model = $observer->getEvent()->getDataObject();

            if ($model && $model->isObjectNew()) {
                var_dump("NEW MODEL EVENT TRIGGERED");
                die();
            } else {
                var_dump("OLD VALUE EVENT TRIGGERED");
            }
        } catch (\Exception $e) {
        }
    }
}
