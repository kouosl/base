<?php
namespace portalium\base;

use Yii;
use yii\web\HttpException;

class Module extends \yii\base\Module
{

    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'portalium\\'.$this->id.'\controllers\\' . Yii::$app->id;
        Yii::$app->language = (Yii::$app->session->get('lang') != "") ? Yii::$app->session->get('lang') : Yii::$app->language;
        static::moduleInit();
    }

    public static function moduleInit()
    {
    }

    public static function registerTranslation($prefix, $basePath, array $fileMap)
    {
        if (!isset(Yii::$app->i18n->translations[$prefix])) {
            Yii::$app->i18n->translations[$prefix] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => $basePath,
                'fileMap' => $fileMap,
            ];
        }
    }

    public static function coreT($category, $message, array $params = [], $language = null)
    {
        static::moduleInit();
        return Yii::t($category, $message, $params, $language);
    }
}