<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener\Server;

use ZFMLL\ModuleManager\Listener\AbstractListener;

class DomainListener extends AbstractListener
{
    /**
     * Set config
     * @param mixed
     */
    public function setConfig($config)
    {   
    	if(is_string($config)) {
            $config = array($config);
        }
    	return parent::setConfig($config);
    }
    
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        $hostname 			= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : @$_SERVER['HTTP_HOST'];
    	$extractedHostname  = $this->extractHostname($hostname);
    	
        if (in_array("*.$extractedHostname", $this->config)) {
        	array_push($this->config, $hostname);
        }

    	return in_array($hostname, $this->config);
    }
    
    /**
     * 
     * Extract hostname from subdomain
     * @param $hostname
     */
	public function extractHostname($hostname)
	{
		$hostname = explode('.', $hostname);
		$hostname = array_reverse($hostname);

		return $hostname[1].'.'.$hostname[0];
	}
}
