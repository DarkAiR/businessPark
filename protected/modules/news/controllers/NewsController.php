<?php

class NewsController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::app()->request->getQuery('id', false);
        if ($id === false)
            throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));

        $news = News::model()->onSite()->findByPk($id);
        if (!$news)
            throw new CHttpException(404);

        $this->render('/index', array(
            'news' => $news,
        ));
    }
}