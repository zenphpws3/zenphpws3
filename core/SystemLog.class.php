<?php
/**
 +------------------------------------------------------------------------------
 * SystemLog 系统纪录类
 * 对系统的各种情况进行纪录
 +------------------------------------------------------------------------------
 * @package core
 * @const LOG_FILE string 保存日记文件的目录
 * @author    dogstar
 * @version   $Id: SystemLog.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class SystemLog
{
	const LOG_FILE = 'log';
	
	/**
     * 系统纪录
     * 根据设置需要保存的错误级别进行相应保存
     * @param $result array 返回给客户端的数据
     * @return 
     * @author	dogstar
     * @last modify 2013-01-06
     */
	static public function log($result)
	{
		$path = dirname(__FILE__).'/../log/';
		$name = SystemLog::LOG_FILE.date('YmdH').'.log';
		
		if(!file_exists($path))
		{
			mkdir($path);
		}
		
		$f = fopen($path.$name, 'a');
		fwrite($f, date('Y-m-d H:i:s')."\t".$result['status']."\t".$result['error']."\n");
		fclose($f);
	}
}