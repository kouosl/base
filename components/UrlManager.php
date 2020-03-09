<?php

namespace portalium\components;

use Yii;

class UrlManager extends \yii\web\UrlManager
{
	public function init()
    {
	    parent::init();
		
		$modules = Yii::$app->getModules();
		
		foreach ($modules as $module)
		{
            $rules = (method_exists($module['class'],'initRules')) ? $module['class']::initRules() : [];
            parent::addRules($rules);
		}
	}
}