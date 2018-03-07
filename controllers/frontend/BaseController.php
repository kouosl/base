<?php
namespace kouosl\base\controllers\frontend;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BaseController extends Controller
{		
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'signup','error'],
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

}
