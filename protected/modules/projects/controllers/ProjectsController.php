<?php

class ProjectsController extends Controller
{
    public function actionIndex()
    {
        $sectionId = Yii::app()->request->getQuery('sectionId', false);

        $model = Projects::model()->onSite();
        if ($sectionId !== false)
            $model = $model->bySection($sectionId);
        $projects = $model->findAll();

        $this->render('/index', array(
            'projects' => $projects,
        ));
    }
}