<?php

class AdminMapAreaController extends MAdminController
{
    public $modelName = 'MapArea';
    public $modelHumanTitle = array('участок', 'участка', 'участков');


    public function getEditFormElements($model)
    {
        return array(
            'cadastral' => array(
                'type' => 'textField',
            ),
            'square' => array(
                'type' => 'textField',
            ),
            'width' => array(
                'type' => 'textField',
            ),
            'height' => array(
                'type' => 'textField',
            ),
            'price' => array(
                'type' => 'textField',
            ),
            'priceType' => array(
                'type' => 'dropdownlist',
                'data' => MapArea::getPriceTypes(),
                'htmlOptions' => array(
                    'data-placeholder' => MapArea::PRICE_RUB,
                ),
            ),
            'resident' => array(
                'type' => 'textField',
            ),
            'busy' => array(
                'type' => 'checkBox',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'cadastral',
            'square',
            'width',
            'height',
            $this->getBooleanColumn('busy'),
            $this->getButtonsColumn(),
        );
        return $attributes;
    }
}
