<?php

namespace Elogic\AdminCrud\Block\Adminhtml\Button;

use Magento\Ui\Component\Control\Container;

/**
 * Class Save
 */
class Save extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic
{
    /**
     * {@inheritdoc}
     */
    /*public function getButtonData()
    {
        return [
            'label' => __('Custom Button'),
            'class' => 'action-secondary',
            'on_click' => 'alert("Hello World")',
            'sort_order' => 10
        ];
    }*/
    public function getButtonData()
    {

        return [
            'label' => __('Create'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'elogic_admincrud_form.elogic_admincrud_form',
                                'actionName' => 'submit',
                                'params' => [
                                    false
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON
        ];
    }


}
