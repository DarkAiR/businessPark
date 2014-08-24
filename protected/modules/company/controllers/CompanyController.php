<?php

class CompanyController extends Controller
{
    /**
     * Управляющая компания
     */
    public function actionIndex()
    {
        $type = Yii::app()->request->getQuery('type', CompanyService::TYPE_BASE);
        $this->render('/company/company', array(
            'type' => $type
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