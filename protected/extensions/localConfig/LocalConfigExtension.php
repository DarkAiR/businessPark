<?php

Yii::import('application.models.LocalConfigItem');

class LocalConfigExtension extends CApplicationComponent
{
    public static $config;

    public function init()
    {
        parent::init();
        Yii::import('ext.localConfig.*');

        try {
            $items = @LocalConfigItem::model()->findAll();

            /** @var $item LocalConfigItem */
            foreach ($items as $item) {
                $key = '';
                if (!empty($item->module))
                    $key = $item->module.'.';
                $key .= $item->id;
                self::$config[$key] = $item->value;
            }
        } catch (Exception $e) {

        }
    }

    /**
     * @param  string     $path
     * @return mixed|null
     */
    public function getConfig($path)
    {
        return isset(self::$config[$path])
            ? self::$config[$path]
            : null;
    }
}
