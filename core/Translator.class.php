<?php
/**
 +------------------------------------------------------------------------------
 * Translator 翻译类
 * 根据设置的语言导入相应的语言包，并进行翻译
 +------------------------------------------------------------------------------
 * @package core
 * @static $message array 用于存放当前翻译数据数组
 * @author    dogstar
 * @version   $Id: Translator.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class Translator
{
	private static $message = null;
	
	/**
     * 翻译
     * 首次获取时会进行初始化
     * 翻译不存在时，返回原来的字符串
     * @param $key string 配置键值
     * @return string 翻译后的字符串
     * @see Translator::setLanguge
     * @author	dogstar
     * @last modify 2012-12-23
     */
	public static function get($key)
	{
		if(Translator::$message == null)
		{
			$params = Validator::getParams(RulesManager::get('l'));
			Translator::setLanguge($params['language']);
		}
			
		return isset(Translator::$message[$key]) ? Translator::$message[$key] : $key;
	}
	
	/**
     * 根据语言，加载翻译文件
     * 搜索language下的翻译文件
     * @param $lan string 语言
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
	public static function setLanguge($lan)
	{
		$path = dirname(__FILE__).'/../language/'.strtoupper($lan).'/common.php';
		
		$message = null;
		if(file_exists($path))
			$message = include($path);
		
		Translator::$message = (!isset($message) || empty($message) || !is_array($message)) ? array() : $message;
	}
	
}