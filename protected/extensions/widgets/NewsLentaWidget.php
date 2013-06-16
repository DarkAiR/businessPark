<?php

class NewsLentaWidget extends ExtendedWidget
{
    const SECTION_NEWS = 1;
    const SECTION_EVENTS = 2;
    const SECTION_ARTICLES = 3;

    public $model;
    public $attribute;

    public function run()
    {
        $news = $this->getNews();
        $news = $this->prepareNews($news);
        $this->render('newsLenta', array(
            'news' => $news,
        ));
    }

    /**
     Получить список новостей
     */
    private function getNews()
    {
        $arr = array(
            array( 'id'=>1, 'ts'=>time(), 'sectionId'=>self::SECTION_NEWS, 'text'=>'Открыта вакансия <a href="">Оптового продавца кофе</a>' ),
            array( 'id'=>2, 'ts'=>time(), 'sectionId'=>self::SECTION_EVENTS, 'text'=>'На сайтах наших кафе теперь есть раздел "Фотки"' ),
            array( 'id'=>3, 'ts'=>time(), 'sectionId'=>self::SECTION_NEWS, 'text'=>'Опубликованы вакансии оптового продавца и координатора продаж.' ),
            array( 'id'=>4, 'ts'=>time(), 'sectionId'=>self::SECTION_NEWS, 'text'=>'В Мурманске открылся наш партнерский магазин <a href="">«Непочатый край»</a>.' ),
            array( 'id'=>5, 'ts'=>time(), 'sectionId'=>self::SECTION_ARTICLES, 'text'=>'Работаем 10:00 до 19:00<br/>сб вс выходной' ),
        );
        shuffle($arr);
        return $arr;
    }

    /**
     Подготовить новости к выводу
     */
    private function prepareNews($news)
    {
        foreach ($news as &$item)
        {
            $sectionName = '';
            $sectionClass = '';
            switch ($item['sectionId'])
            {
                case self::SECTION_NEWS:
                    $sectionClass = 'news';
                    $sectionName = 'Новости';
                    break;

                case self::SECTION_ARTICLES:
                    $sectionClass = 'articles';
                    $sectionName = 'Статьи';
                    break;

                case self::SECTION_EVENTS:
                    $sectionClass = 'events';
                    $sectionName = 'События';
                    break;
            }
            $item['sectionName'] = $sectionName;
            $item['sectionClass'] = $sectionClass;

            $item['date'] = date('j M', $item['ts']);
        }
        return $news;
    }
}
