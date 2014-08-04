<?php

class CompanyController extends Controller
{
    /**
     * Управляющая компания
     */
    public function actionIndex()
    {
        $this->render('/company/company', array(
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