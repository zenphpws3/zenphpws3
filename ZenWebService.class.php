<?php

/**
 +------------------------------------------------------------------------------
 * ZenLoader Web Services 应用类
 * 实现远程服务的响应、调用等操作
 +------------------------------------------------------------------------------
 * @package 
 * @author    dogstar
 * @version   $Id: ZenWebService.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */
 
class ZenWebService{
	
    /**
     * 运行服务
     * @param string $_REQUEST['p'] 协议
     * @return 
     * @see ZenWebService::runRpc
     * @see ZenWebService::runSoap
     * @see ZenWebService::runHttp
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static public function run()
    {
    	//error_reporting(E_ALL);
    	//set_error_handler(array('ZenWebService', 'webServiceError'));
    	//set_exception_handler(array('ZenWebService', 'webServiceException'));
    	
    	require dirname(__FILE__).'/core/ZenLoader.class.php';
    	
        ZenLoader::load('common/fun/');
        ZenLoader::load('core/');
        
        $params = Validator::getParams(RulesManager::get('p'));
        $protocol = strtolower(trim($params['protocol']));
        if($protocol == 'rpc')
        {
        	$_REQUEST['p'] = $protocol;
        	ZenWebService::runRpc();
        }else if($protocol == 'soap')
        {
        	ZenWebService::runSoap();
        }else if($protocol == 'http')
        {
        	ZenWebService::runHttp();
        }
    }
    
    /**
     * 通过RPC协议运行服务
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static private function runRpc()
    {
        ZenLoader::load('phprpc/phprpc_server.php');
        
    	$server = new PHPRPC_Server();  
        $server->add(
            array(
                'response',
        	), 
            new ZenWebService()
            );  
        $server->start();
    }
    
    /**
     * 通过SOAP协议运行服务
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static private function runSoap()
    {
    	$soap = new SoapServer(null,array('uri'=>'http://localhost/zenWS3/index.php', 'port'=>null));
		$soap->setClass('ZenWebService');
		$soap->handle();
    }
    
    /**
     * 通过HTTP协议运行服务
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
    static private function runHttp()
    {
		header( 'Content-Type:text/html;charset=utf-8');

    	$server = new ZenWebService();
    	
    	$result = $server->response();
    	
    	if(is_array($result))
    		print_r($result);
    	else
    		echo $result;
    }
    
    /**
     * 响应操作
     * 通过工厂方法创建合适的控制器，然后调用指定的方法，最后返回格式化的数据。
     * @param string $_REQUEST['a'] 客户端调用的方法
     * @return mixed 根据配置的或者手动设置的返回格式，将结果返回，其结果包含以下元素：
     * array('status' => Response::UNKNOW,	//服务器响应状态
    					'data' => null,		//正常并成功响应后，返回给客户端的数据	
    					'error' => '',		//错误提示信息
    					'debug' => array(),	//调试信息，开启调试状态时返回
    			);
     * @see ControllerFactory::createController
     * @author	dogstar
     * @last modify 2012-12-23
     */
    public function response()
    {
    	$resutl = array('status' => Response::UNKNOW,
    					'data' => null,
    					'error' => '',
    					'debug' => array(),
    			);
    	
		session_start();
		ini_set('session.gc_maxlifetime',3600); 

    	DataBase::initialDbConnect();		
    	
    	try{
    		ZenLoader::load('IpBan', 'U');
    		IpBan::checkIP();
    		
    		$controller = ControllerFactory::createController();	//如果不成功，抛出 ZenException 
    		
    		$params = Validator::getParams(RulesManager::get('a'));
    		
				
        	$resutl['data'] = call_user_func(array($controller, $params['action']));
        	$resutl['status'] = call_user_func(array($controller, 'getStatus'));
        	$resutl['error'] .= call_user_func(array($controller, 'getError'));
        	$resutl['debug'] = call_user_func(array($controller, 'getDebug'));
        		
    	}catch (ZenException $e)
    	{
    		$resutl['status'] = Response::WRONG;
        	$resutl['error'] .= $e->getMessage();
        	$resutl['debug'] = $e->getDebug();
    	}catch (Exception $e)
    	{
    		$resutl['status'] = Response::ERROR;
        	$resutl['error'] .= $e->getMessage();
        	$resutl['debug']['file'] = $e->getFile();
        	$resutl['debug']['line'] = $e->getLine();
        	$resutl['debug']['code'] = $e->getCode();
    	}
    	
        SystemLog::log($resutl);
		DataBase::closeDbConnect();
        
        if(!Config::get('DEBUG'))
			 unset($resutl['debug']);
			    		
    	return Response::format($resutl);
    }
    
    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
	public static function webServiceException($e)
	{
		
	}
	
	/**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
	public static function webServiceError($errno, $errstr, $errfile, $errline)
	{
		switch ($errno) {
	          case E_ERROR:
	          case E_USER_ERROR:
	          case E_STRICT:
	          case E_USER_WARNING:
	          case E_USER_NOTICE:
	          default:
	            break;
	      }
	}
    
}
