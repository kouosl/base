<?php

namespace portalium\web;

use portalium\base\Bootstrap as BaseBootstrap;

class Bootstrap extends BaseBootstrap
{
    private $_apis = [];

    private $_urlRules = [];

    private $_apiRules = [];

    public function beforeRun($app)
    {
        foreach ($this->getModules() as $id => $module) {
            foreach ($module->urlRules as $key => $rule) {
                if (is_string($key)) {
                    $this->_urlRules[$key] = $rule;
                } else {
                    $this->_urlRules[] = $rule;
                }
            }

            foreach ($module->apiRules as $endpoint => $rule) {
                $this->_apiRules[$endpoint] = $rule;
            }


            foreach ($module->apis as $alias => $class) {
                $this->_apis[$alias] = ['class' => $class, 'module' => $module];
            }
        }
    }

    public function run($app)
    {
        $app->getUrlManager()->addRules($this->_urlRules);
    }
}