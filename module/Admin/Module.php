<?php

namespace Admin;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Retorna a configuração do service manager do módulo
     * @return arary
     */
    /*
     * Essa configuração pode ser feita no module.config.php, e é o que foi feito.
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Service\Auth' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    return new Service\Auth($dbAdapter);
                }
            )
        );
    }
     * 
     */

}
