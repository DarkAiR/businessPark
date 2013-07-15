<?php

class TwigFunctions
{
    /**
     * @param string $class
     * @param array $properties
     * @return string
     */
    public static function widget($class, $properties = array())
    {
        $className = Yii::import($class, true);
        foreach ($properties as $propertyName => $value)
        {
            if (!property_exists($className, $propertyName))
                unset($properties[$propertyName]);
        }

        $c = Yii::app()->getController();
        return $c->widget($class, $properties, true);
    }

    /**
     * @param string $class
     * @param string $property
     * @return mixed
     */
    public static function constGet($class, $property)
    {
        $c = new ReflectionClass($class);
        return $c->getConstant($property);
    }

    public static function _unset($array, $elementName)
    {
        unset($array[$elementName]);

        return $array;
    }

    /**
     * @param string $class
     * @param string $method
     * @param array $params
     * @return mixed
     */
    public static function staticCall($class, $method, $params = array())
    {
        return call_user_func_array($class . '::' . $method, $params);
    }

    /**
     * Добавить CSS
     */
    public static function importResource($type, $filename, $alias=false)
    {
        switch ($type)
        {
            case 'css':
                if ($alias === false)
                    $alias = 'application.views.css';
                $assetsPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias($alias)."/".$filename);
                Yii::app()->getClientScript()->registerCssFile($assetsPath, '');
                break;

            case 'js':
                if ($alias === false)
                    $alias = 'application.views.js';
                $assetsPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias($alias)."/".$filename);
                Yii::app()->getClientScript()->registerScriptFile($assetsPath);
                break;
        }
    }
}
