<?php

namespace portalium\base;

use Yii;
use ReflectionClass;
use yii\helpers\ArrayHelper;
use portalium\web\Application as WebApplication;
use portalium\console\Application as ConsoleApplication;

abstract class Portalium
{
    public $app;

    private $_isCli;
    private $_baseYiiFile;
    private $_appConfig;
    private $_configFiles = [];

    public function setConfigFiles(array $configFiles)
    {
        $this->_configFiles = $configFiles;
    }

    public function getConfigFiles()
    {
        return $this->_configFiles;
    }

    public function setBaseYiiFile($baseYiiFile)
    {
        $this->_baseYiiFile = $baseYiiFile;
    }

    public function getBaseYiiFile()
    {
        return $this->_baseYiiFile;
    }

    public function consoleApplication()
    {
        $config = $this->getAppConfig();
        $config['defaultRoute'] = 'help';
        $this->requireYii();
        $mConfig = ArrayHelper::merge($config, [
            'bootstrap' => ['portalium\console\Bootstrap'],
            'components' => [
                'urlManager' => [
                    'class' => 'portalium\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'showScriptName' => false
                ],
            ],
        ]);
        $this->app = new ConsoleApplication($mConfig);

        exit($this->app->run());
    }

    public function webApplication()
    {
        $config = $this->getAppConfig();
        $this->requireYii();
        $mConfig = ArrayHelper::merge($config, [
            'bootstrap' => ['portalium\web\Bootstrap']
        ]);
        $this->app = new WebApplication($mConfig);

        return $this->app->run();
    }

    public function getAppConfig()
    {
        if ($this->_appConfig === null) {
            foreach($this->_configFiles as $configFile){
                if (file_exists($configFile)) {
                    $config = require $configFile;
                }

                if (!is_array($config)) {
                    throw new Exception("config file '".$configFile."' found but no array returning.");
                }

                $this->_appConfig = ArrayHelper::merge($this->_appConfig, $config);
            }
        }

        return $this->_appConfig;
    }

    public function getCorePath()
    {
        $reflector = new ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }

    public function getSapiName()
    {
        return strtolower(php_sapi_name());
    }

    public function getIsCli()
    {
        if ($this->_isCli === null) {
            $this->_isCli = $this->getSapiName() === 'cli';
        }

        return $this->_isCli;
    }

    public function setIsCli($isCli)
    {
        $this->_isCli = $isCli;
    }

    public function isCli()
    {
        return $this->getIsCli();
    }

    public function run()
    {
        if ($this->getIsCli()) {
            return $this->consoleApplication();
        }

        return $this->webApplication();
    }

    private function requireYii()
    {
        if (file_exists($this->_baseYiiFile)) {
            defined('PORTALIUM_YII_VENDOR') ?: define('PORTALIUM_YII_VENDOR', dirname($this->_baseYiiFile));

            $baseYiiFolder = PORTALIUM_YII_VENDOR . DIRECTORY_SEPARATOR;

            $yiiFile = $this->getCorePath() . DIRECTORY_SEPARATOR .  'Yii.php';

            if (file_exists($yiiFile)) {
                require_once($baseYiiFolder . 'BaseYii.php');
                require_once($yiiFile);
            } else {
                require_once($baseYiiFolder . 'Yii.php');
            }

            Yii::setAlias('@portalium', $this->getCorePath());

            return true;
        }

        throw new Exception("YiiBase file does not exits '".$this->_baseYiiFile."'.");
    }
}