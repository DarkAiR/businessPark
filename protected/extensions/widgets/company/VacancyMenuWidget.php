<?php

class VacancyMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $vacancyId;
    public $vacancies;

    public function run()
    {
        $this->render('vacancyMenu', array(
            'vacancyId' => $this->vacancyId,
            'vacancies' => $this->vacancies
        ));
    }
}