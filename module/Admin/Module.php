<?php

namespace Admin;

use Zend\Mvc\MvcEvent;

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
     * Executada no bootstrap do módulo
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap($e) {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao módulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
    }

    /**
     * Verifica se precisa fazer a autorização do acesso
     * Método utilizando o Zend ACL
     * @param  MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');

        $authService = $di->get('Admin\Service\Auth');
        if (!$authService->authorize($moduleName, $controllerName, $actionName)) {
            throw new \Exception('Você não tem permissão para acessar este recurso');
        }

        return true;
    }

    /**
     * Verifica se precisa fazer a autorização do acesso
     * @param  MvcEvent $event Evento
     * @return boolean
     */
    /*
      public function mvcPreDispatch($event) {
      $di = $event->getTarget()->getServiceLocator();
      $routeMatch = $event->getRouteMatch();
      $moduleName = $routeMatch->getParam('module');
      $controllerName = $routeMatch->getParam('controller');

      if ($moduleName == 'admin' && $controllerName != 'Admin\Controller\Auth') {
      $authService = $di->get('Admin\Service\Auth');
      if (!$authService->authorize()) {
      $redirect = $event->getTarget()->redirect();
      $redirect->toUrl('/admin/auth');
      }
      }
      return true;
      }
     */

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
