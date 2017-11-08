<?php
namespace kouosl\base\controllers\backend;

use yii\web\Controller;

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
