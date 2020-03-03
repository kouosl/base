<?php
namespace kouosl\base;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\HttpException;

class Module extends \yii\base\Module{
    public $controllerNamespace = '';
    public $namespace;
    public $isKouOslModule;
    
    public function init(){
        parent::init();
        $this->registerTranslations();
        $lang = yii::$app->session->get('lang');
        if($lang){
            yii::$app->language = $lang;
        }
        $isKouOslModule = explode("\\",self::className())[0] === "kouosl" ? true : false;
        $this->setNamespace();
        switch ($this->namespace){
            case 'backend':{
                if($isKouOslModule){
                    $this->controllerNamespace = 'kouosl\\'.$this->id.'\controllers\\'.$this->namespace;
                    $this->setViewPath('@kouosl/'.$this->id.'/views/backend');
                }else{
                    $this->controllerNamespace = 'backend\\modules\\'.$this->id.'\controllers';
                }
            };break;
            case 'frontend':{
                if($isKouOslModule){
                    $this->controllerNamespace = 'kouosl\\'.$this->id.'\controllers\\'.$this->namespace;
                    $this->setViewPath('@kouosl/'.$this->id.'/views/frontend');
                }else{
                    $this->controllerNamespace = 'backend\\modules\\'.$this->id.'\controllers';
                }
            };break;
            case 'console':{
                $this->controllerNamespace = 'kouosl\\'.$this->id.'\controllers\\'.$this->namespace;
            };break;
            case 'api':{
                $this->controllerNamespace = 'kouosl\\'.$this->id.'\controllers\\'.$this->namespace;
            };break;
            default:{
                throw new HttpException(500,'init');
            };break;
        }
    }

    public function setNamespace(){
        $explodedNamespace = explode("\\", Yii::$app->controllerNamespace);
        $this->namespace = $explodedNamespace[0];
    }

    public function behaviors(){
        if(!isset($this->namespace)){
            $this->setNamespace();
        }
        $behaviors = parent::behaviors();
        switch ($this->namespace){
            case 'backend':{

            };break;
            case 'frontend':{

            };break;
            case 'api':{
                $behaviors['authenticator'] = [
                    'class' => CompositeAuth::className(),
                    'authMethods' => [
                        HttpBasicAuth::className(),
                        HttpBearerAuth::className(),
                        QueryParamAuth::className(),
                    ],
                ];
            };break;
            case 'console':{

            };break;
            default:{
                throw new HttpException(500,'behaviors'.$this->namespace);
            };break;
        }
        return $behaviors;
    }
}