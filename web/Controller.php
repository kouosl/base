<?php
namespace portalium\web;

use Yii;
use portalium\base\Module;

abstract class Controller extends \yii\web\Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['home','login', 'signup','error','contact','about','captcha','lang'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function getViewPath()
    {
        if ($this->module instanceof Module) {
            return '@portalium/' . $this->module->id . '/views/' . Yii::$app->id . DIRECTORY_SEPARATOR . $this->id;
        }

        return parent::getViewPath();
    }
}