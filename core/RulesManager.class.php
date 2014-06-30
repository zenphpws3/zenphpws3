<?php

/**
 +------------------------------------------------------------------------------
 * RulesManager 参数规则管理类
 * 管理规则的容器，并提供了系统默认的规则
 * 可以与参数生成器配合使用，@uses Validator
 * 每一条规则为一数组，其格式如下：
 * 'a' => array(					//提供的参数名称
			'name' => 'action',		//生成后的参数名称（不提供时默认与原来一样）
			'type' => 'string',		//类型，目前为：int,float,string
			'default' => 'action',	//默认值
			'require' => true,		//是否为必须
			),
 +------------------------------------------------------------------------------
 * @package core
 * @static $rules array 全部规则
 * @author    dogstar
 * @version   $Id: RulesManager.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class RulesManager
{
	static private $rules = null;
	
	/**
     * 获取规则
     * 首次获取时，进行初始化
     * 支持多条规则同时获取，需要用“,”分割，如"a,c,f"
     * @param $names string 规则名字
     * @return array 需要获取的规则，不成功时返回空数组
     * @see RulesManager::createRules
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static public function get($names)
	{
		$result = array();
		
		if(RulesManager::$rules == null)
			RulesManager::createRules();
			
		$names = explode(',', $names);
		
		foreach ($names as $value) {
			if(isset(RulesManager::$rules[$value]))
				$result[$value] = RulesManager::$rules[$value];
		}
		
		return $result;
	}
	
	/**
     * 创建系统默认的规则
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static protected function createRules()
	{
		RulesManager::$rules = array(
			'a' => array(	
						'name' => 'action',
						'type' => 'string',
						'default' => Config::get('SYS_DEFAULT_ACTION'),
						'require' => true,
						),
			'c' => array(	
						'name' => 'controller',
						'type' => 'string',
						'default' => Config::get('SYS_DEFAULT_CONTROLLER'),
						'require' => true,
						),
			'f' => array(	
						'name' => 'format',
						'type' => 'string',
						'default' => Config::get('SYS_DEFAULT_FORMAT'),
						'require' => true,
						),
			'k' => array('name' => 'key',
						'type' => 'string',
						'default' => null,
						'require' => true,
						),
			'l' => array(	
						'name' => 'language',
						'type' => 'string',
						'default' => Config::get('SYS_DEFAULT_LANGUAGE'),
						'require' => true,
						),
			'p' => array(	
						'name' => 'protocol',
						'type' => 'string',
						'default' => Config::get('SYS_DEFAULT_PROTOCL'),
						'require' => true,
						),
			't' => array('name' => 'time',
						'type' => 'string',
						'default' => null,
						'require' => true,
						),
			'z' => array('name' => 'token',
						'type' => 'string',
						'default' => null,
						'require' => true,
						),
				);
	}
	
}