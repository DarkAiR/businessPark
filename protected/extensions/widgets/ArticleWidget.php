<?php

Yii::import('application.models.Articles');

class ArticleWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public $type = Articles::TYPE_CUSTOM;

    public function run()
    {
        $article = Articles::model()->onSite()->byType($this->type)->find();
        if (empty($article))
            return;

        $this->render('article', array(
            'article' => $article
        ));
    }
}
