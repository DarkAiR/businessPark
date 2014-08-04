<?php

class ProjectController extends Controller
{
    /**
     * Управляющая компания
     */
    public function actionAbout()
    {
        $this->render('/project/about', array(
        ));
    }
}