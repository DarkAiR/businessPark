<?php

class CompanyController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('/company/about');
    }

    public function actionAbout()
    {
        $this->render('/about', array(
        ));
    }

    public function actionCommand()
    {
        $persons = Persons::model()->onSite()->inCommand()->orderDefault()->findAll();
        $this->render('/command', array(
            'persons' => $persons,
        ));
    }

    public function actionFaq()
    {
        $faq = Faq::model()->onSite()->orderDefault()->findAll();
        $this->render('/faq', array(
            'items' => $faq,
        ));
    }
}