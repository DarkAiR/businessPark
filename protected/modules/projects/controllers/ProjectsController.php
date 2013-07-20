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


    public function actionShow()
    {
        $id = Yii::app()->request->getQuery('id', false);
        if ($id === false)
            throw new CHttpException(400, Yii::t('yii','Your request is invalid.'));

        $project = Projects::model()->onSite()->findByPk($id);
        if (!$project)
            throw new CHttpException(404);

        $this->render('/show', array(
            'project' => $project,
        ));        
    }
}