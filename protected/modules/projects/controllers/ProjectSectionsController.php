<?php

class ProjectSectionsController extends Controller
{
    public function actionIndex()
    {
        $projectSections = ProjectSections::model()->onSite()->orderDefault()->findAll();

        $this->render('/sections', array(
            'projectSections' => $projectSections,
        ));
    }
}