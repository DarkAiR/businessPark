<?php

class NewsController extends Controller
{
    public function actionIndex()
    {
        $year = Yii::app()->request->getQuery('year');

        // Получаем распределение по годам
        $sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') as year, count(*) as cnt
                FROM sphereart.news
                WHERE visible=1
                GROUP BY year
                ORDER BY year DESC;";
        $years = Yii::app()->db->commandBuilder->createSqlCommand($sql)->queryAll();
        if (empty($years))
            Yii::app()->end();

        // Берем последний год
        $lastYear = $years[0]['year'];
        if ($year === null)
            $year = $lastYear;

        $news = News::model()->onSite()->byYear($year)->findAll();
        $this->render('/index', array(
            'year' => $year,
            'lastYear' => $lastYear,
            'years' => $years,
            'news' => $news,
        ));
    }

    public function actionShow()
    {
        $id = Yii::app()->request->getQuery('id', false);
        if ($id === false)
            throw new CHttpException(400, Yii::t('yii','Your request is invalid.'));

        $news = News::model()->onSite()->findByPk($id);
        if (!$news)
            throw new CHttpException(404);

        $this->render('/show', array(
            'news' => $news,
        ));
    }
}