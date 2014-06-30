<?php

/**
 +------------------------------------------------------------------------------
 * ZenLoader 文件加载类
 * 自定义文件加载类
 +------------------------------------------------------------------------------
 * @package core
 * @static $loadFiles array 用于存放当前已经回载文件名称（不含路径）
 * @author    dogstar
 * @version   $Id: ZenLoader.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

define('PRE_PATH', dirname(__FILE__).'/../');

class ZenLoader
{
    //已加载文件
    static private $loadFiles = array('ZenLoader.class.php');
    
	/**
     * 加载php文件
     * @param $path string 文件绝对路径或者类标记符
     * @param $type string 类型  E:扩展  C:控制器  M:模型  U:工具
     * @see ZenLoader::loadByPath
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static public function load($path, $type = '')
    {
    	if($path == null || empty($path))
    		return;
    		
    	$type = strtoupper($type);
    	switch ($type)
    	{
    		case 'E':
    			ZenLoader::loadByPath(PRE_PATH.'extensions/'.$path);
    			break;
    		case 'C':
    			ZenLoader::loadByPath(PRE_PATH.'services/Controllers/'.ucfirst($path).'Controller.class.php');
    			break;
    		case 'M':
    			ZenLoader::loadByPath(PRE_PATH.'services/Models/'.ucfirst($path).'Model.class.php');
    			break;
    		case 'U':
    			ZenLoader::loadByPath(PRE_PATH.'common/util/'.$path.'.class.php');
    			break;
    		default:
    			ZenLoader::loadByPath(PRE_PATH.$path);
    			break;
    	}
    }
    
	/**
     * 加载php文件
     * @param $path string 文件绝对路径
     * @see ZenLoader::recordAndLoadFiles
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static private function loadByPath($path)
    {
        if(strlen($path) > 4 && substr($path, -4) == '.php')
        {
            ZenLoader::recordAndLoadFiles($path);
            return;
        }
        
        if(!file_exists($path))
        	return;
        	
        $root = scandir($path);
        
        foreach($root as $value) 
        { 
            if($value === '.' || $value === '..') 
            	continue;
            	
            if(is_file("$path/$value")) {
                $pInfo = pathinfo($value);                                
                if ($pInfo['extension'] == "php") {
                    ZenLoader::recordAndLoadFiles("$path/$value");
                }
            } else {
                ZenLoader::loadByPath($path);
            }
        }
    }
    
	/**
     * 纪录已加载文件
     * @param $path string 文件绝对路径
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static public function recordAndLoadFiles($path)
    {
        $name = strrchr($path, '/');
        $name = ($name === false ? $path: substr($name, 1));
        	
        if(!in_array($name, ZenLoader::$loadFiles))
        {
        	if(!file_exists($path))
        		return;
        		
        	require($path);
        		
            array_push(ZenLoader::$loadFiles, $name);
        }
    }
    
    /**
     * 获取已加载文件名称，用于调试
     * @param 
     * @return array 已加载文件名称
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static public function getRecords()
    {
    	return ZenLoader::$loadFiles;
    }
}