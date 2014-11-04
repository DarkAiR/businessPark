<?php

class AdminWorkLinePdfController extends MAdminController
{
    // Id записи в базе по-умолчанию
    const DEFAULT_MODEL_ID = 1;

    public $modelName = 'WorkLinePdf';
    public $modelHumanTitle = array('', 'файлов', 'файлов');

    public $allowedActions = 'edit';


    public function behaviors()
    {
        return array(
            'docBehavior' => array(
                'class' => 'application.behaviors.DocumentsControllerBehavior',
                'docField' => 'data',
            ),
        );
    }

    /**
     * При переходе на список перекидываем на редактирование
     */
    public function actionList()
    {
        $_GET['id'] = self::DEFAULT_MODEL_ID;
        $this->actionEdit();
    }


    public function beforeSave($model)
    {
        $this->docBehavior->docBeforeSave($model, $model->docBehavior->getStorePath());
        parent::beforeSave($model);
    }

    public function getEditFormElements($model)
    {
        return array(
            // Для того, чтобы отправлялся POST запрос
            'id' => array(
                'type' => 'hidden',
            ),
            '_docs' => array(
                'class' => 'application.components.admin.EditDocumentsWidget',
                'attributeRemove' => '_removeDocs',
                'maxRows' => 2,
            )
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
