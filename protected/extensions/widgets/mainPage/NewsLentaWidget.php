<?php

class NewsLentaWidget extends ExtendedWidget
{
    const LIMIT = 2;

    public $model;
    public $attribute;

    public function run()
    {
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
        $news = News::model()
            ->onSite()
            ->onMain()
            ->byLimit(self::LIMIT)
            ->findAll();
        foreach ($news as &$n)
        {
            $arr[] = array(
                'id'    => $n->id,
                'date'  => DateHelper::formatNewsDate($n->createTime),
                'text'  => $n->shortDesc,
                'image' => $n->getImageUrl(),
                'link'  => CHtml::normalizeUrl(array('/news/news/show', 'id'=>$n->id))
            );
        }
        return $arr;
    }
}
