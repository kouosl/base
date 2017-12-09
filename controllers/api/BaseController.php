<?php

namespace kouosl\base\controllers\api;

use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class BaseController extends Controller
{
	public function behaviors() {
		$behaviors = parent::behaviors();
		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];
		return $behaviors;
	}
	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}