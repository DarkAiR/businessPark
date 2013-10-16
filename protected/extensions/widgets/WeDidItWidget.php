<?php

class WeDidItWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $items = Yii::app()->db->createCommand()
            ->select('count(*) as amount, sectionId, ps.title as title')
            ->from('Projects')
            ->leftJoin('ProjectSections ps', 'ps.id = sectionId AND ps.visible=1')
            ->group('sectionId')
            ->where('Projects.visible=1')
            ->queryAll();

        $this->render('weDidIt', array(
            'items' => $items
        ));
    }
}
