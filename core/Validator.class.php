<?php

/**
 +------------------------------------------------------------------------------
 * Validator 参数生成类
 * 负责根据提供的参数规则，进行参数创建工作，并返回错误信息
 * 需要与参数规则配合使用
 * @uses RulesManager
 +------------------------------------------------------------------------------
 * @package core
 * @author    dogstar
 * @version   $Id: Validator.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class Validator
{
	/**
     * 获取参数
     * 根据提供的参数规则，进行参数创建工作，并返回错误信息
     * @param $rules string 参数规则 
     * @uses RulesManager
     * @param &$error string 错误信息，默认为空
     * @param $data mixed 提供的数据，默认使用$_REQUEST
     * @return array 创建的参数
     * @author	dogstar
     * @last modify 2012-12-23
     */
	static public function getParams($rules, &$error = '', $data = null)
	{
		$result = array();
		if(!isset($data) || empty($data))
			$data = $_REQUEST;
			
    	foreach ($rules as $key => $value)
    	{
    		$name = isset($rules[$key]['name']) ? $rules[$key]['name'] : $key;
    		$result[$name] = isset($rules[$key]['default']) && $rules[$key]['default'] != '' ? $rules[$key]['default'] : null;
    		$result[$name] = isset($data[$key]) ? $data[$key] : $result[$name];
    		
    		if(isset($result[$name]))
    		{
    			if(!isset($rules[$key]['type']))
    				$rule[$key]['type'] = 'string';
    				
    			switch ($rules[$key]['type'])
    			{
    				case 'int':
    					$result[$name] = intval($result[$name]);
    					break;
    				case 'float':
    					$result[$name] = floatval($result[$name]);
    					break;
    				default:
    					$result[$name] = strval($result[$name]);
    					break;
    			}
    		}else{
    			if(isset($rules[$key]['require']) && $rules[$key]['require'])
    				$error .= Translator::get('Miss '.$name.': Require!');
    		}
    	}
    	
    	return $result;
	}
}
