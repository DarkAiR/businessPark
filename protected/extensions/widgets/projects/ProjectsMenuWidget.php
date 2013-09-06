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
            ->from('Projects')
            ->leftJoin('ProjectSections ps', 'ps.id = sectionId AND ps.visible=1')
            ->group('sectionId')
            ->where('Projects.visible=1')
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