<?php

class NewsLentaWidget extends ExtendedWidget
{
    const LIMIT = 5;

    public $model;
    public $attribute;

    public function run()
    {
        echo 'Новости';
        return;
        
        $news = $this->getNews();
        $this->render('newsLenta', array(
            'news' => $news,
        ));
    }

    /**
     Получить список новостей
     */
    private function getNews()
    {
        $arr = array();
        $works = News::model()->onSite()->byLimit(self::LIMIT)->findAll();
        foreach ($works as &$work)
        {
            $arr[] = array(
                'id' => $work->id,
                'date' => DateHelper::formatNewsDate($work->createTime),
                'title' => $work->title,
                'text' => $work->shortDesc,
                'link' => CHtml::normalizeUrl(array('/news/news/show', 'id'=>$work->id))
            );
        }
        if (count($arr) < self::LIMIT)
        {
            for ($i=count($arr); $i < self::LIMIT; $i++)
                $arr[] = array();
        }
        return $arr;
    }
}
