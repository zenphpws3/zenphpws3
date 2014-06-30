<?php
/**
 +------------------------------------------------------------------------------
 * Controller 控制器基类
 * 实现身份验证、参数获取生成、设置参数规则等操作，并由开发人员自宝义的控制器继承
 +------------------------------------------------------------------------------
 * @package core
 * @var $error string 错误提示信息，默认为空
 * @var $debug array 调试信息，默认为空数组
 * @var $status 响应状态，默认为Response::FAIL
 * @see Response 
 * @author    dogstar
 * @version   $Id: Controller.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class Controller
{
	private $error = '';
    private $debug = array();
    private $status = '';
    
	/**
     * 默认构造函数
     * 调用初始化函数进行初始化工作
     * @param 
     * @return 
     * @see Controller::initialize
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function __construct()
    {
       	$this->initialize();
    }
    
    /**
     * 缺省调用方法
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function __call($method, $args)
    {
        throw new ZenException('Wrong Action: '.$method);
    }
    
    /**
     * 动态设置类成员变量
     * @param $name string 变量名字
     * @param $value mixed 变量值
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function __set($name, $value)
    {
    	$this->$name = $value;
    }
    
    /**
     * 动态获取类成员变量
     * 值不存在时，抛出异常
     * @param $name string 变量名字
     * @return mixed 变量值
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function __get($name)
    {
    	if(!isset($name) || empty($name))
    		return;
    		
    	if(!isset($this->$name))
    		throw new ZenException('Visit Undefied Class Member '.$name);

    	return $this->$name;
    }
    
    /**
     * 获取错误提示信息
     * @param 
     * @return string
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * 获取调试信息
     * @param 
     * @return array
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function getDebug()
    {
    	return $this->debug;
    }
    
    /**
     * 获取状态值
     * 注意：错误信息不为空时，统一强制认为是不成功
     * @param 
     * @return string
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function getStatus()
    {
    	return !empty($this->error) ? Response::FAIL : $this->status;
    }
    
    /**
     * 设置已成功响应
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function succeed()
    {
    	$this->status = Response::OK;
    }
    
    /**
     * 添加错误信息
     * 将错误信息翻译后，与原来的拼接
     * @param $newError string 错误信息
     * @param $isNeedTran bool 是否需要翻译，默认是
     * @see Translator::get
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function addError($newError, $isNeedTran = true)
    {
    	if($isNeedTran)
    		$newError = Translator::get($newError);
    		
    	$this->error .= $newError.' ';
    }
    
    /**
     * 添加调试信息
     * @param $key string 键值
     * @param $value mixed 值
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function addDebug($key, $value)
    {
    	$this->debug[$key] = $value;
    }
    
    /**
     * 初始化
     * 主要完成的初始化工作有：
     * 1. 根据设置的自定义规则，从$_REQUEST获取所需要的参数，并保存在成员变量内 @see Controller::createMemberValue
     * 2. 验证Token @see Controller::verifyToken
     * 3. 验证App Key @see Controller::verifyAppKey
     * 4. 验证用户身份
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function initialize()
    {
    	$this->createMemberValue();

    	$this->verifyToken();
    	
    	$this->verifyAppKey();
    	
    	$this->checkStatus();
    	
    	$this->status = Response::FAIL;		//默认是失败
    }
    
    /**
     * 过滤并创建参数
     * 根据客户商调用的方法名字，搜索相应的自定义参数规则进行过滤创建，并把参数存放在类成员变量里面。
     * @param string $_REQUEST['a'] 客户端调用的方法
     * @see Controller::getRules
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function createMemberValue()
    {
    	$rules = $this->getRules();
    	$error = '';
    	$params = Validator::getParams(RulesManager::get('a'), $error);
    	$action = $params['action'];
    	
    	if(!isset($action) || empty($action))
    	{
    		$this->addError(Translator::get('Miss Action When create member value!'));
    		$this->addDebug('rule', RulesManager::get('a'));
    		return;
    	}
    	
    	$rule = (isset($rules[$action]) && is_array($rules[$action])) ? $rules[$action] : array();
		$rule = isset($rules['*']) ? array_merge($rules['*'], $rule) : $rule;
    	
    	$params = Validator::getParams($rule, $this->error);
    	foreach ($params as $key => $val)
    		$this->$key = $val;
    }
    
    /**
     * 验证App Key
     * 利用服务器提供给客户端的密钥，以及统一的加密方法，验证时间+AppKey
     * 如果控制器手动取消验证，或者系统默认不验证，则跳过
     * @param string $_REQUEST['t'] 时间
     * @param string $_REQUEST['k'] 客户端加密后的值
     * @see Controller::encryptAppKey
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function verifyAppKey()
    {
    	if(!Config::get('VERIFY_APP_KEY'))
    		return;
		
    	$error = '';
    	$params = Validator::getParams(RulesManager::get('t,k'), $error);
    	if(!empty($error))
    	{
    		$this->addError($error);
    		return;
    	}
    	
    	$serverKey = $this->encryptAppKey($params['time'].Config::get('APP_KEY'));
    	if($serverKey != $params['key'])
    	{
    		$this->addError(Translator::get('Wrong App Key!'));
    		$this->debug['serverKey'] = $serverKey;
    	}
    }
    
    /**
     * 自定义AppKey加密方法
     * 可由开发人员根据需要进行动态重载
     * @param string $key 待加密的字符串
     * @return string 加密后的字符串
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function encryptAppKey($key)
    {
    	return md5($key);
    }
    
    /**
     * 验证Token
     * 验证客户端的token值 是否与服务器的一致
     * 如果控制器手动取消验证，或者系统默认不验证，则跳过
     * @param string $_REQUEST['z'] token值
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function verifyToken()
    {
    	if(!Config::get('VERIFY_TOKEN'))
    		return;
    		
    	if(!isset($_SESSION['token']))
    	{
    		$this->addError('No token at server!');
    		return;
    	}
    	
    	$error = '';
    	$params = Validator::getParams(RulesManager::get('z'), $error);
    	
    	if(!empty($error))
    	{
    		$this->addError($error);
    		return;
    	}
    	
    	if($_SESSION['token'] != $params['token'])
    	{
    		$this->addError(Translator::get('Wrong token!'));
    		$this->debug['serverToken'] = $_SESSION['token'];
    	}
    }
    
    /**
     * 验证用户身份
     * 可由开发人员根据需要重载
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function checkStatus()
    {
    	
    }
    
    /**
     * 获取参数设置的规则
     * 可由开发人员根据需要重载，如果有冲突，以子类为准
     * @param 
     * @return array
     * @author	dogstar
     * @last modify 2012-12-23
     */
    protected function getRules()
    {
    	return array();
    }
    
}