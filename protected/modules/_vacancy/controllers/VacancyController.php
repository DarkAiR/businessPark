<?php

class VacancyController extends Controller
{
    public function actionIndex()
    {
        $vacancies = Vacancy::model()->onSite()->orderDefault()->findAll();
        $this->render('/index', array(
            'vacancies' => $vacancies
        ));
    }

   	public function actionShow()
    {
        $id = Yii::app()->request->getQuery('id', false);
        if ($id === false)
            throw new CHttpException(400, Yii::t('yii','Your request is invalid.'));

        $vacancies = Vacancy::model()->onSite()->findAll();
        if (!$vacancies)
            throw new CHttpException(404, 'Nothing found');

        $vacancy = null;
        foreach ($vacancies as $v)
        {
            if ($v->id == $id)
            {
                $vacancy = $v;
                break;
            }
        }
        if (!$vacancy)
            throw new CHttpException(404, 'Vacancy not found');

        $this->render('/show', array(
            'vacancies' => $vacancies,
            'vacancy' => $vacancy,
        ));        
   	}
}