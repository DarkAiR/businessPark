<?php

class AdminNewsController extends MAdminController
{
    public $modelName = 'News';
    public $modelHumanTitle = array('новость', 'новости', 'новостей');

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
                'imageWidth' => News::IMAGE_SMALL_W,
                'imageHeight' => News::IMAGE_SMALL_H,
            ),
            'imageBigBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'imageBig',
                'imageWidth' => News::IMAGE_BIG_W,
                'imageHeight' => News::IMAGE_BIG_H,
                'innerImageField' => '_imageBig',
                'innerRemoveBtnField' => '_removeImageBigFlag',
            )
        );
    }

    public function getEditFormElements($model)
    {
        return array(
        	'title' => array(
        		'type' => 'textField',
        	),
            'createTimeDate' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'dd.mm.yyyy'
                    ),
                ),
            ),
            'createTimeTime' => array(
                'type' => 'timepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'showMeridian' => false,
                        'defaultTime' => 'value',
                    ),
                ),
            ),
            'shortDesc' => array(
                'type' => 'ckEditor',
            ),
            'desc' => array(
                'type' => 'ckEditor',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
            ),
            '_imageBig' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_imageBig',
                'removeImageFieldName' => '_removeImageBigFlag',
            ),
            'onMain' => array(
                'type' => 'checkBox',
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            '_createTime',
            $this->getImageColumn('image', 'getImageUrl()'),
            'title',
            'newsLink',
            $this->getBooleanColumn('onMain'),
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        $this->imageBigBehavior->imageBeforeSave($model, $model->imageBigBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
