<?php

/**
 +------------------------------------------------------------------------------
 * ExamplesController 示例控制器类
 +------------------------------------------------------------------------------
 * @package services/Controllers
 * @author    dogstar
 * @version   $Id: Config.class.php 474 2013-01-14 11:47:13Z dogstar23 $
 +------------------------------------------------------------------------------
 */

class ExamplesController extends Controller
{
    public function getRules()
    {
        return array(
            'getWelcome' => array(
                'name' => array('type' => 'string',
                'default' => 'nobody',
                'require' => false,
                ),
            ),
        );
    }

    public function getWelcome()
    {
		$this->succeed();
        return array('content' => 'Hello Wolrd', 'name' => $this->name);
    }    
}
