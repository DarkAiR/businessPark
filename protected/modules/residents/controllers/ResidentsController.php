<?php

class ResidentsController extends Controller
{
    public function actionIndex()
    {
        $residents = Residents::model()->onSite()->orderDefault()->findAll();
        if (!$residents)
            $residents = array();

        $this->render('/index', array(
            'residents' => $residents,
        ));
    }
}