<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->redirect(array('mainPage/mainPage/index'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->getReturnUrl(array('site/index')));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Panorama
     */
    public function actionPanorama()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'createDate';
        $criteria->group = 'EXTRACT(YEAR_MONTH FROM createDate)';
        $criteria->order = 'createDate DESC';
        $criteria->condition = 'visible=1';
        $dates = Yii::app()->db->commandBuilder->createFindCommand('Panorama', $criteria)->queryAll();

        $panorams = Panorama::model()->onSite()->orderDefault()->findAll();
        $this->render('panorama', array(
            'dates' => $dates,
            'panorams' => $panorams
        ));
    }

    /**
     * Карта
     */
    public function actionMap()
    {
        $type = Yii::app()->request->getQuery('type', '');
        $showFastMap = Yii::app()->request->getQuery('fast', 0);

        $areas = MapArea::model()->findAll();

        $structureData = MapInfrastructure::model()->findAll();
        $structureAreas = array();
        foreach ($structureData as $v) {
            $structureAreas[$v->getTypeMapName()][$v->number] = array(
                'name' => str_replace("\r", "", str_replace("\n", "", nl2br($v->desc)))
            );
        }

        $this->render('map', array(
            'areas' => $areas,
            'structureAreas' => $structureAreas,
            'showType' => $type,
            'showFastMap' => $showFastMap
        ));
    }

    /**
     * Презентация
     */
    public function actionPresentation()
    {
        $this->render('presentation');
    }
}