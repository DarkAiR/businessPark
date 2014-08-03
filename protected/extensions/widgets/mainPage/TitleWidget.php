<?php

class TitleWidget extends ExtendedWidget
{
    public function run()
    {
        $this->render('title', array(
            'title' => nl2br(Yii::app()->localConfig->getConfig('title')),
            'titleDesc' => nl2br(Yii::app()->localConfig->getConfig('titleDesc'))
        ));
    }
}
