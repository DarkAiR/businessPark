<?php

class ProjectsMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public $sectionId = false;      // Id раздела с проектами

    public function run()
    {
        $items = Yii::app()->db->createCommand()
            ->select('count(*) as amount, sectionId, ps.name as name')
            ->from('projects')
            ->leftJoin('projectsections ps', 'ps.id = sectionId')
            ->group('sectionId')
            ->queryAll();

        $this->render('projectsMenu', array('items'=>$items, 'sectionId'=>$this->sectionId));
    }
}
