<?php
/**
 +------------------------------------------------------------------------------
 * Response 响应类
 * 拥有各种结果返回状态 ，以及对返回结果 的格式化
 +------------------------------------------------------------------------------
 * @package core
 * @const string OK 正常响应，并成功调用
 * @const string FAIL 正常响应，但请求失败，如登录失败
 * @const string WRONG 用户操作错误
 * @const string ERROR 系统错误
 * @const string UNKNOW 未知错误
 * @author    dogstar
 * @version   $Id: Response.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class Response
{
    //响应结果状态类型
    const OK = 'OK';				//正常响应
    const FAIL = 'FAIL';			//正常响应，但请求失败，如登录失败
    const WRONG = 'WRONG';			//用户操作错误
    const ERROR = 'ERROR';			//系统错误
    const UNKNOW = 'UNKONW';		//未知错误
	
    /**
     * 格式化返回结果
     * @param $result mixed 待返回中的结果数据
     * @param $_REQUEST['f'] string 返回格式，为：json, xml或其他
     * @return mixed
     * @author	dogstar
     * @last modify 2013-01-06
     */
    public static function format($result)
    {
    	$params = Validator::getParams(RulesManager::get('f'));
    	$type = $params['format'];
    	
    	if($type == 'json')
    		return json_encode($result);
    	else if($type == 'xml')	
    	{
    		ZenLoader::load('ArrayToXml', 'U');
    		return ArrayToXML::toXml($result, 'xmlData');
    	}else if($type == 'array')
    	{
    		return $result;
    	}
    	
    	return $result;
    }
}