<?php

class WorkLineController extends Controller
{
    public function actionIndex()
    {
        $steps = WorkLine::model()->onSite()->orderDefault()->findAll();
        $this->render('/index', array(
            'steps' => $steps
        ));
    }
}