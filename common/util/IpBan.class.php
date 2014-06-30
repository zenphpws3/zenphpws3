<?php
/**
 +------------------------------------------------------------------------------
 * IpBan IP地址禁止类
 +------------------------------------------------------------------------------
 * @package common/util
 * @author    dogstar
 * @version   $Id: IpBan.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class IpBan
{
	 /**
     * 检测本地IP是否被禁止
     * @return  返回被禁止的理由或原因，非禁止则返回null
     * @author	dogstar
     * @last modify 2012-03-20
     */
	static public function checkIP()
	{
		$cur_ip = ip2long(get_client_ip());
    	
		if(empty($cur_ip))
			return;

    	$result = Config::get('BAN_IPS');
    	if($result == null)
    		$result = array();
    		
    	foreach($result as $val)
    	{
    		if($cur_ip >= ip2long($val["min"]) && $cur_ip <= ip2long($val["max"]))
    			throw new ZenException(Translator::get('IP baned! Reason: ').$val["reason"]);
    	}
	}
}
?>
