<?php
/**
 * PhpUnderControl_AppAds_Test
 *
 * 针对 ../../core/Controller.class.php Controller 类的PHPUnit单元测试
 *
 * @author: dogstar 20140630
 */

require_once dirname(__FILE__) . '/test_env.php';

if (!class_exists('Controller')) {
    require dirname(__FILE__) . '/../' . '../../core/Controller.class.php';
}

class PhpUnderControl_Controller_Test extends PHPUnit_Framework_TestCase
{
    public $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new Controller();
    }

    protected function tearDown()
    {
    }


    /**
     * @group returnFormat
     */ 
    public function testGetErrorReturnFormat()
    {
        $rs = $this->controller->getError();
        $this->assertTrue(is_string($rs));
    }

    /**
     * @depends testGetErrorReturnFormat
     * @group businessData
     */ 
    public function testGetErrorBusinessData()
    {
        $rs = $this->controller->getError();
    }

    /**
     * @group returnFormat
     */ 
    public function testGetDebugReturnFormat()
    {
        $rs = $this->controller->getDebug();
        $this->assertTrue(is_array($rs));
    }

    /**
     * @depends testGetDebugReturnFormat
     * @group businessData
     */ 
    public function testGetDebugBusinessData()
    {
        $rs = $this->controller->getDebug();
    }

    /**
     * @group returnFormat
     */ 
    public function testGetStatusReturnFormat()
    {
        $rs = $this->controller->getStatus();
    }

    /**
     * @depends testGetStatusReturnFormat
     * @group businessData
     */ 
    public function testGetStatusBusinessData()
    {
        $rs = $this->controller->getStatus();
    }

}
