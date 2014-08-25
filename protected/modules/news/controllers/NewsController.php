<?php

class NewsController extends Controller
{
    public function actionIndex()
    {
        $year = Yii::app()->request->getQuery('year');

        // Получаем распределение по годам
        $years = $this->getNewsYears();
        if (empty($years))
            $years = array(0 => array('year' => date('Y')));

        // Берем последний год
        $lastYear = $years[0]['year'];
        if ($year === null)
            $year = $lastYear;

        $news = News::model()->onSite()->byYear($year)->findAll();
        if (!$news)
            $news = array();

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

        $news = News::model()->onSite()->findByPk($id);
        if (!$news)
            throw new CHttpException(404);

        $year = date('Y', strtotime($news->createTimeDate));

        // Получаем распределение по годам
        $years = $this->getNewsYears();
        if (empty($years))
            Yii::app()->end();

        // Берем последний год
        $lastYear = $years[0]['year'];

        // Предыдущая и следующая новости
        $sql = "SELECT id
                FROM News
                WHERE createTime < {$news->createTime}
                AND DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') = {$year}
                ORDER BY createTime DESC";
        $prevId = Yii::app()->db->commandBuilder->createSqlCommand($sql)->queryScalar();
        $prevLink = $prevId ? News::getNewsLinkById($prevId) : null;

        $sql = "SELECT id
                FROM News
                WHERE createTime > {$news->createTime}
                AND DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') = {$year}
                ORDER BY createTime ASC";
        $nextId = Yii::app()->db->commandBuilder->createSqlCommand($sql)->queryScalar();
        $nextLink = $nextId ? News::getNewsLinkById($nextId) : null;

        $this->render('/show', array(
            'year' => $year,
            'lastYear' => $lastYear,
            'years' => $years,
            'news' => $news,
            'backUrl' => Yii::app()->getRequest()->getHostInfo(),
            'prevLink' => $prevLink,
            'nextLink' => $nextLink,
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