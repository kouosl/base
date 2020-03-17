<?php

namespace portalium\base;

use Yii;
use yii\base\BootstrapInterface;

abstract class Bootstrap implements BootstrapInterface
{
    private $_modules;

    public function getModules()
    {
        return $this->_modules;
    }

    public function bootstrap($app)
    {
        $this->findModules($app);
        $this->beforeRun($app);
        $this->registerModules($app);
        $this->run($app);
    }

    public function findModules($app)
    {
        if ($this->_modules === null) {
            foreach ($app->getModules() as $id => $obj) {
                $moduleObject = Yii::$app->getModule($id);
                if ($moduleObject instanceof \portalium\base\Module) {
                    $this->_modules[$id] = $moduleObject;
                }
            }

            if ($this->_modules === null) {
                $this->_modules = [];
            }
        }
    }

    private function registerModules($app)
    {
        foreach ($this->getModules() as $id => $module) {
            Yii::setAlias('@portalium/'.$id, $module->getBasePath());

            foreach ($module->registerComponents() as $componentId => $definition) {
                if (!$app->has($componentId)) {
                    Yii::trace('Register component ' . $componentId, __METHOD__);
                    $app->set($componentId, $definition);
                }
            }

            $module->portaliumBootstrap($app);
        }
    }

    abstract public function beforeRun($app);

    abstract public function run($app);
}