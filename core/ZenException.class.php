<?php

/**
 +------------------------------------------------------------------------------
 * ZenException 自定义异常类
 * 对于系统已存在Exception类，故加Zen前缀以区分为自定义的类
 +------------------------------------------------------------------------------
 * @package core
 * @var $debug array 用于存放当前调试信息数组，默认为空数组
 * @author    dogstar
 * @version   $Id: ZenException.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class ZenException extends Exception
{
	private $debug = array();
	
	/**
     * 默认构造函数
     * @param 
     * @return 
     * @author	dogstar
     * @last modify 2012-12-23
     */
	public function __construct($message, $debug = array())
	{
		if(is_array($debug))
			$this->debug = $debug;
			
		parent::__construct($message);
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
}