<?php
/**
 * AW-Report
 * @package aw-report Application
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface; 
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface; 
use Zend\Console\Adapter\AdapterInterface as Console;
// Add these import statements:
 use Application\Model\Transaction;
 use Application\Model\TransactionTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


class Module implements ConsoleBannerProviderInterface, ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**      * To show the console banner      
     * * @see \Zend\ModuleManager\Feature\ConsoleBannerProviderInterface::getConsoleBanner()      */     
    public function getConsoleBanner(Console $console)
    {         
        return
        "==---------------------------------------------------------==\n" .         
        "        Welcome to AW Reporting Sample                              \n" .
        "        Basic Usage: php index.php show merchant <merchantID> <currency>.      \n".      
        "==---------------------------------------------------------==\n" .         
        "Version 0.1\n"             ;     
        
    }         
    
    /**      * This method is defined in ConsoleUsageProviderInterface      */     
    public function getConsoleUsage(Console $console)
    {         
        return array(                         
            'show merchant <id> <currency>' => "Show transactions from specific merchant with id (int).\nOptional: desired currency in ISO format. default: GBP\n",             
            'show transactions <currency>'   => "show all transactions from all merchants.\nOptional desired currency in ISO format. default: GBP",                     
        );    
        
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                 'Application\Model\TransactionTable' =>  function($sm) {
                     $tableGateway = $sm->get('TransactionTableGateway');
                     $table = new TransactionTable($tableGateway);
                     return $table;
                 },
                 'TransactionTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Model\Transaction());
                     return new TableGateway('transactions', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
