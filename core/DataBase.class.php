<?php
/**
 +------------------------------------------------------------------------------
 * DataBase 数据库类
 * 外观模式，基于RedBean实现
 * 负责数据库的连接和关闭
 +------------------------------------------------------------------------------
 * @package core
 * @author    dogstar
 * @version   $Id: DataBase.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class DataBase
{
	/**
     * 初始化数据库连接
     * 若配置不使用数据库，则不连接
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public static function initialDbConnect()
    {
    	if(!Config::get('DB_ON'))
    		return;
    		
    	ZenLoader::load('RedBeanPHP/rb.php', 'E');
    	
    	if(Config::get('DB_TYPE') == 'mysql')
    	{
	    	R::setup('mysql:host='.Config::get('DB_HOST').';dbname='.Config::get('DB_NAME'),
	        	Config::get('DB_USER'),Config::get('DB_PWD')); //mysql
    	}else if(Config::get('DB_TYPE') == 'pgsql')
    	{
	    	R::setup('pgsql:host='.Config::get('DB_HOST').';dbname='.Config::get('DB_NAME'),
	        	Config::get('DB_USER'),Config::get('DB_PWD')); //mysql
    	}else{
    		//Since 3.2:
	    	R::setup('cubrid:host='.Config::DB_HOST.';port='.Config::DB_PORT.';dbname='.Config::get('DB_NAME'),
		        		Config::get('DB_USER'), 
		        		Config::get('DB_PWD')); //CUBRID
    	}
    }
    
    /**
     * 关闭数据库连接
     * 若配置不使用数据库，则不断开
     * @return 
     * @author	dogstar
     * @last modify 2013-01-06
     */
    public static function closeDbConnect()
    {
    	if(!Config::get('DB_ON'))
    		return;
    		
    	R::close();
    }

    public static function create($modelName, $data = array())
    {
    	$bean = R::dispense(DataBase::getModelName($modelName));
    	foreach ($data as $key => $val)
    	{
    		$bean -> $key = $val;
    	}
    		
    	return $bean;
    }
    
    public static function findByKey($modelName, $key)
    {
    	return R::load(DataBase::getModelName($modelName), $key);
    }
    
    public static function save($obj)
    {
    	return R::store($obj);
    }
    
    public static function delete($obj)
    {
    	return R::trash($obj);
    }
    
    public static function getModelName($modelName)
    {
    	return Config::get('DB_PREFIX').$modelName;
    }
}