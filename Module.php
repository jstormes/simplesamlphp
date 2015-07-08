<?php
namespace JStormes\SimpleSAMLphp;

use Zend\Log\Filter\Priority;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Log\Logger as ZendLogger;



class Module
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface 
     */
    static $zf2service = null;
    
    public function onBootstrap(MvcEvent $e)
    {         
        
        /**
         * Save a refrence to the Srvice Manager for SimpleSAMLphp.
         */
        self::$zf2service = $e->getApplication()->getServiceManager();
        
        /**
         * Force login if the user is not currently logged in.
         */
        // don't redirect if we are currently in the SimpleSAMLphp library.
        if (strpos($_SERVER['REQUEST_URI'],"/saml/")!==0) {
            //$as = new \SimpleSAML_Auth_Simple('example-userpass'); 
            $as = new \SimpleSAML_Auth_Simple('example-zf2sql'); 
            $as->requireAuth();
            $attributes = $as->getAttributes();
        }
        
        
    }
    
    /**
     * @return array
     */
    public function getConfig()
    {
        
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array();

//         return array(
//             'Zend\Loader\StandardAutoloader' => array(
//                 'namespaces' => array(
//                     '' => __DIR__ . '/src',
//                 ),
//             ),
//         );
    }
    
    /**
     * This bridges the ZF2 Service Manager into the
     * SimpleSAMLphp library so we can use the ZF2 services
     * from the zf2sqlauth SimpleSAMLphp module.
     * 
     * This may not be the best way but it is expedient.
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     * @throws \Exception
     */
    public function getServiceManager()
    {
        if (self::$zf2service!==null)
            return self::$zf2service;
        else  
            throw new \Exception('ZF2 Service Manager not initlized.');
    }

}
