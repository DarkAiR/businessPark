<?php

class CompanyController extends Controller
{
    /**
     * Управляющая компания
     */
    public function actionIndex()
    {
        $typeStr = CompanyService::getTypeQueryStr();
        $type = Yii::app()->request->getQuery('type', $typeStr[CompanyService::TYPE_BASE]);

        $items = CompanyService::model()
            ->onSite()
            ->orderDefault()
            ->byTypeStr($type)
            ->findAll();

        $this->render('/company/company', array(
            'type' => $type,
            'typeStr' => $typeStr,
            'items' => $items
        ));
    }

    public function actionStructure()
    {
        $this->render('/company/structure', array(
        ));
    }

    public function actionContacts()
    {
        $this->render('/company/contacts', array(
        ));
    }
}