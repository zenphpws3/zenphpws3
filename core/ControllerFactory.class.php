<?php

/**
 +------------------------------------------------------------------------------
 * ControllerFactory 创建控制器类
 * 工厂方法
 * 将创建与使用分离，简化客户调用，负责控制器复杂的创建过程
 +------------------------------------------------------------------------------
 * @package core
 * @author    dogstar
 * @version   $Id: ControllerFactory.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class ControllerFactory
{
	/**
     * 创建控制器
     * 根据客户端提供控制器名称和需要调用的方法进行创建工作，如果创建失败，则抛出相应的自定义异常
     * 创建过程主要如下：
     * 1. 是否缺少控制器名称和需要调用的方法
     * 2. 控制器文件是否存在，并且控制器是否存在
     * 3. 方法是否可调用
     * 4. 控制器是否初始化成功
     * @param string $_REQUEST['c'] 控制器名称
     * @param string $_REQUEST['a'] 需要调用的方法
     * @return Controller 自定义的控制器
     * @see ZenException
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static function createController()
	{
		$error = '';
		
		$params = Validator::getParams(RulesManager::get('a,c'), $error);
		
		if(!empty($error))
		{
			throw new ZenException($error);
		}
		
		$className = ucfirst($params['controller']).'Controller';
        $path = dirname(__FILE__).'/../services/Controllers/'.$className.'.class.php';
        
        if(!file_exists($path))
        {
        	throw new ZenException("Illega controller ".$params['controller'].'!');
        }
        
		ZenLoader::load($params['controller'], 'C');
	        		
        if(!class_exists($className))
        {
        	throw new ZenException("No such class as $className !");
        }
        		
    	$controller = new $className();
    			
    	if(!is_callable(array($controller, $params['action'])))
    	{
    		throw new ZenException('No method '.$params['action'].' in class '.$className.' or uncalled!');
    	}
    	
    	$error = call_user_func(array($controller, 'getError'));
		if(!empty($error))
		{
			throw new ZenException($error, call_user_func(array($controller, 'getDebug')));
		}
		
		return $controller;
	}
	
}