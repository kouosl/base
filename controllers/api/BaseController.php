<?php

namespace kouosl\base\controllers\api;

use yii\rest\Controller;

class BaseController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}