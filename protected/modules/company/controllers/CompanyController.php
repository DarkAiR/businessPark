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
        $this->render('/command', array(
        ));
    }

    public function actionFaq()
    {
        $faq = Faq::model()->onSite()->orderDefault()->findAll();

        $this->render('/faq', array(
            'items' => $faq,
        ));
    }

    public function actionVacancy()
    {
        $this->render('/vacancy', array(
        ));
    }
}