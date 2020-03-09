<?php

namespace portalium\web;


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
                        'actions' => ['login', 'signup','error','contact','about'],
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

    public function render($view, $params = [], $context = null)
    {
        $viewPath =  "@portalium/theme/views/" . $this->module->id . "/". Yii::$app->id . "/" . Yii::$app->controller->id . "/" . $view . ".php";
        if(is_file($viewPath))
            return parent::renderFile($viewPath, $params, $context);

        $viewPath =  "@portalium/" . $this->module->id . "/views/" . Yii::$app->id . "/" . Yii::$app->controller->id . "/" . $view . ".php";
        if(is_file($viewPath))
            return parent::renderFile($viewPath, $params, $context);

        return parent::render($view, $params, $context);
    }

}