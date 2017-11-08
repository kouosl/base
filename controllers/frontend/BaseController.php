<?php
namespace kouosl\base\controllers\frontend;

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
