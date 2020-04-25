<?php

namespace portalium\helpers;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class RestHelper
{
    public static function modelError(Model $model)
    {
        if (!$model->hasErrors()) {
            throw new InvalidParamException('The model as thrown an unknown Error.');
        }

        Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'name' => $name,
                'message' => $message,
            ];
        }

        return $result;
    }
}
