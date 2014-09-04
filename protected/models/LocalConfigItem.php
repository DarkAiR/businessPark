<?php

class LocalConfigItem extends CActiveRecord
{
    const TYPE_BOOL             = 'bool';
    const TYPE_INT              = 'int';
    const TYPE_FIXEDARRAY       = 'fixedarray';
    const TYPE_DYNAMICARRAY     = 'dynamicarray';
    const TYPE_STRING           = 'string';
    const TYPE_MULTILINESTRING  = 'multilinestring';
    const TYPE_FILE             = 'file';
    const TYPE_TWOPOWARRAY      = 'twopowarray'; // Массив, ключами которого являются степени двойки

//    public $_file = null;
//    public $_file_delete = null;

    public $value = null;
    public $example = null;

    /**
     * @static
     * @param  string $className
     * @return LocalConfigItem|CActiveRecord
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'localconfig';
    }

    public function attributeLabels()
    {
        return array(
            'id'            => 'Имя параметра',
            'value'         => 'Значение',
//            '_file'         => 'Значение',
//            '_file_delete'  => 'Удалить и использовать пример',
            'example'       => 'Пример',
            'description'   => 'Описание',
        );
    }

    public function rules()
    {
        return array(
//            array('_file_delete', 'safe'),
            array('value', 'localConfigValueValidator'),
//            array('_file', 'localConfigFileValidator'),

        );
    }

    public function scopes()
    {
        return array(
//            'filesOnly' => array(
//                'condition' => 't.type = '.self::TYPE_FILE
//            )
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function localConfigValueValidator($attribute,$params)
    {
        if ($this->type == self::TYPE_INT) {
            $numericValidator = CValidator::createValidator('CNumberValidator', $this, $attribute, array('allowEmpty' => false, 'integerOnly' => true));
            $numericValidator->validate($this);
        }
    }

/*    public function localConfigFileValidator($attribute, $params)
    {
        if ($this->type == self::TYPE_FILE) {
            $validateParams = localConfigValidateHelper::getParams();
            $_params = array('origin'   => 'value');
            if (isset($validateParams[$this->id]) && is_array($validateParams[$this->id])) {
                $_params = array_merge($_params, $validateParams[$this->id]);
            }
            if (isset($_params['type']) && $_params['type'] === 'image') {
                unset($_params['type']);

                $validator = CValidator::createValidator('ImageValidator', $this, $attribute, $_params);
                $validator->validate($this);
            } elseif (isset($_params['type']) && $_params['type'] === 'file') {
                if ($this->$attribute || $this->$attribute = CUploadedFile::getInstance($this, $attribute)) {
                    $fileSize = isset($_params['fileSize']) ? $_params['fileSize'] : 15728640;
                    if ($this->$attribute->getSize() > $fileSize)
                        $this->addError($attribute, 'Размер файла слишком большой. (файл должен быть не больше 15мб)');

                    $valid_ext = (isset($_params['extensions']) && is_array($_params['extensions'])) ? $_params['extensions'] : array('doc', 'rtf', 'docx', 'txt', 'pdf');

                    if (!in_array($this->$attribute->getExtensionName(), $valid_ext))
                        $this->addError($attribute, 'Неправильный формат файла. Допустимые форматы: ' . implode(', ', $valid_ext));
                }
            } else {
                $this->addError($attribute, 'Неправильный валидатор!');
            }
        }
    }
*/
    public function byModule($name='')
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'module = :module',
            'params' => array(
                ':module' => $name,
            )
        ));

        return $this;
    }

    protected function afterFind()
    {
        parent::afterFind();

        if (in_array($this->type, array(self::TYPE_FIXEDARRAY, self::TYPE_DYNAMICARRAY, self::TYPE_TWOPOWARRAY))) {
            $this->value = json_decode($this->value, true);
            $this->example = json_decode($this->example, true);
        }

        // Возвращаем именно тот тип данных, в котором хранится конфиг
        $this->checkReturnValue();

    }

    private function checkReturnValue()
    {
        switch ($this->type) {

            case self::TYPE_BOOL:
                $this->value = (bool) $this->value;
                break;

            case self::TYPE_INT:
                $this->value = (int) $this->value;
                break;

//            case self::TYPE_FIXEDARRAY:
//                $this->value = (array) $this->value;
//                break;

            case self::TYPE_DYNAMICARRAY:
                $this->value = (array) $this->value;
                break;

            case self::TYPE_STRING:
                $this->value = (string) $this->value;
                break;

            case self::TYPE_MULTILINESTRING:
                $this->value = (string) $this->value;
                break;

//            case self::TYPE_FILE:
//                $this->value = (string) $this->value;
//                break;

//            case self::TYPE_TWOPOWARRAY:
//                $this->value = (array) $this->value;
//                break;
        }
    }

    protected function beforeSave()
    {
        if (in_array($this->type, array(self::TYPE_FIXEDARRAY, self::TYPE_DYNAMICARRAY))) {
            $this->value = json_encode($this->value);
            $this->example = json_encode($this->example);
        }

        // Расстановка степеней двойки в качестве ключей массива
//        if ($this->type == self::TYPE_TWOPOWARRAY) {
//            $res = array();
//            foreach ($this->value as $id => $v)
//                $res[pow(2, $id + 1)] = $v;
//            $this->value = json_encode($res);
//            $this->example = json_encode($this->example);
//        }

        // Удаляем файл
//        if ($this->_file_delete && $this->value != $this->example) {
//            $userFilesManager = Yii::app()->getComponent('userFilesManager');
//            $userFilesManager->deleteFileByUid($this->value);
//            $this->value = $this->example;
//        }

        // Загружаем файл
//        if ($this->_file || $this->_file = CUploadedFile::getInstance($this, '_file')) {
//            $userFilesManager = Yii::app()->getComponent('userFilesManager');
//            $this->value = $userFilesManager->publishFile($this->_file->getTempName(), $this->_file->getExtensionName())->getUID();
//            if (empty($this->value))
//                $this->addError($attribute, 'Файл <'.$this->_file->getTempName.'>не загружен');
//        }

        return parent::beforeSave();
    }

    /**
     * @param  null         $param
     * @return array|string
     */
    public function getPrintable($param = null)
    {
        // Проверяем что $param был передан, он существует и имеет область видимости public, иначе возвращаем пустую строку
        // В случае исключения возвращаем текст сообщение об ошибке
        try {
            $checker = new ReflectionProperty(__CLASS__, $param);
            if (is_null($param) || !isset($this->$param) || !$checker->isPublic())
                return '';
        } catch (ReflectionException $e) {
            return $e->getMessage();
        }


        return StringUtils::getPrintableRepresentation($this->$param);
/*
        if ($this->type != self::TYPE_FILE)
            return StringUtils::getPrintableRepresentation($this->$param);

        $validateParams = localConfigValidateHelper::getParams();
        if (isset($validateParams[$this->id]) && is_array($validateParams[$this->id])) {
            $_params = $validateParams[$this->id];
        }
        $userFilesManager = Yii::app()->getComponent('userFilesManager');
        $fileUrl = $userFilesManager->getUrlByFileUid($this->$param);

        if (isset($_params['type']) && $_params['type'] === 'image')
            return '<img src="' . $fileUrl . '" />';
        return '<a href="' . $fileUrl . '" >' . $this->$param . '</a>';
*/
    }

//    public function isFile()
//    {
//        return $this->type == self::TYPE_FILE ? true : false;
//    }
}
