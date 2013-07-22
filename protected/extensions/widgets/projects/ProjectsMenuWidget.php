<?php

class ProjectsMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public $sectionId = false;      // Id раздела с проектами

    public function run()
    {
        $url = trim( Yii::app()->request->url, '/' );
        $itemsArr = array();
        $hasSelect = false;

        $items = Yii::app()->db->createCommand()
            ->select('count(*) as amount, sectionId, ps.name as name')
            ->from('projects')
            ->leftJoin('projectsections ps', 'ps.id = sectionId')
            ->group('sectionId')
            ->queryAll();

        foreach ($items as &$item)
        {
            $select = false;
            if ($item['sectionId'] == $this->sectionId)
            {
                $select = true;
                $hasSelect = true;
            }
            $item['select'] = $select;
        }
        $this->render('projectsMenu', array('items'=>$items, 'sectionId'=>$this->sectionId, 'hasSelect'=>$hasSelect));
    }
}