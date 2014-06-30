<?php

/**
 +------------------------------------------------------------------------------
 * DefaultController 默认控制器类
 +------------------------------------------------------------------------------
 * @package services/Controllers
 * @author    dogstar
 * @version   $Id: DefaultController.class.php 476 2013-03-01 07:33:07Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class DefaultController extends Controller
{
	public function __construct()
    {
    	Config::set('VERIFY_APP_KEY', false);
    	Config::set('VERIFY_TOKEN', false);
    	
       	parent::__construct();
    }

	public function action()
	{
		$this->succeed();
		$this->addDebug('msg', 'This is default service!');
		return Translator::get('Welcome to use zenphpWS3!');
	}
}
