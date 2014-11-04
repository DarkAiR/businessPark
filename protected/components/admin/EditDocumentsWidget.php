<?php

class EditDocumentsWidget extends CWidget
{
    public $model;
    public $attribute;
    public $attributeRemove = '';
    public $form;

    public $maxRows = 0;        // Максимальное количество строк (0-бесконечно)


    public function run()
    {
        $model      = $this->model;
        $attribute  = $this->attribute;
        $array      = $model->$attribute;
        if (!is_array($array))
            throw new CException('passed attribute is not an array!');

        if ($this->maxRows > 0 && count($array) < $this->maxRows) {
            $array = array_fill(count($array), $this->maxRows - count($array), '');
        }


        $this->render('editDocuments',array(
            'form'                  => $this->form,
            'model'                 => $model,
            'modelClass'            => get_class($model),
            'attributeName'         => $attribute,
            'attributeRemoveName'   => $this->attributeRemove,
            'array'                 => $array,
            'maxRows'               => $this->maxRows,
            'fixed'                 => $this->maxRows > 0
        ));
    }
}
