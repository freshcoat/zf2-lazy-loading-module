<?php

namespace ZFMLL\Module\Listener\Environment;

use ZFMLL\Module\Listener\AbstractListener,
    ZFMLL\Module\ModuleEvent;

class SapiListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'sapi';
	
    /**
     * 
     * @param string $module
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        return php_sapi_name() == $this->config;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment(ModuleEvent $e)
    {
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1')
    	{
    		return null;
    	}
    	
    	$argv = $_SERVER['argv'];
    	$parameter = $e->getParameterEnvironnement();
    	foreach($argv as $arg) {
    		$match = array();
    		if(preg_match('#^--'.$parameter.'=(.*)$#', $arg, $match)) {
    			return $match[1];
    		}
    	}
        return null;
    }
}