<?php

class NewsController extends Controller
{
    public function actionIndex()
    {
        $year = Yii::app()->request->getQuery('year');

        // Получаем распределение по годам
        $years = $this->getNewsYears();
        if (empty($years))
            Yii::app()->end();

        // Берем последний год
        $lastYear = $years[0]['year'];
        if ($year === null)
            $year = $lastYear;

        $news = News::model()->onSite()->byYear($year)->findAll();
        if (!$news)
            throw new CHttpException(404, 'News are not found');

        $this->render('/index', array(
            'year' => $year,
            'lastYear' => $lastYear,
            'years' => $years,
            'news' => $news,
        ));
    }

    public function actionShow()
    {
        $id = Yii::app()->request->getQuery('id');
        if ($id === null)
            throw new CHttpException(400, Yii::t('yii','Your request is invalid.'));

        // Получаем распределение по годам
        $years = $this->getNewsYears();
        if (empty($years))
            Yii::app()->end();

        $news = News::model()->onSite()->findByPk($id);
        if (!$news)
            throw new CHttpException(404);

        $this->render('/show', array(
            'year' => 0,
            'lastYear' => 0,
            'years' => $years,
            'news' => $news,
        ));
    }

    /**
     * Получаем распределение по годам
     * @return array Годы
     */
    private function getNewsYears()
    {
        $sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') as year, count(*) as cnt
                FROM News
                WHERE visible=1
                GROUP BY year
                ORDER BY year DESC;";
        return Yii::app()->db->commandBuilder->createSqlCommand($sql)->queryAll();
    }
}