<?php 

/**
 +------------------------------------------------------------------------------
 * Config 配置类
 * 获取或动态改变系统所需要的参数配置
 +------------------------------------------------------------------------------
 * @package core
 * @static $map array 用于存放当前配置信息数组
 * @author    dogstar
 * @version   $Id: Config.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class Config
{
	//@static $map array 用于存放当前配置信息数组
	static private $map = null;
	
	/**
     * 获取配置
     * 首次获取时会进行初始化
     * @param $key string 配置键值
     * @return mixed 需要获取的配置值
     * @see Config::loadConfig
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static public function get($key)
	{
		if(Config::$map == null)
		{
			Config::loadConfig();
		}
		
		return isset(Config::$map[$key]) ? Config::$map[$key] : null;
	}
	
	/**
     * 动态获取配置
     * 键值不存在是，不保存
     * @param $key string 配置键值
     * @param $value mixed 配置值
     * @return bool 是否改变成功
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static public function set($key, $value)
	{
		if(isset(Config::$map[$key]))
		{
			Config::$map[$key] = $value;
			return true;
		}
		
		return false;
	}
	
	/**
     * 加载配置文件
     * 加载保存配置信息数组的config.php文件，若文件不存在，则将$map置为空数组
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static private function loadConfig()
	{
		$path = dirname(__FILE__).'/../config/config.php';
		
		$map = null;
		if(file_exists($path))
			$map = include($path);
		
		Config::$map = (!isset($map) || empty($map) || !is_array($map)) ? array() : $map;
	}
}
?>