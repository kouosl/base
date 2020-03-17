<?php

namespace portalium\web;

use Yii;

class UrlManager extends \yii\web\UrlManager
{
    public function init()
    {
        parent::init();

        /*foreach (Yii::$app->getModules() as $module)
        {
            $rules = (method_exists($module['class'],'initRules')) ? $module['class']::initRules() : [];
            parent::addRules($rules);
        }*/
    }
}