<?php
/**
 * PhpUnderControl_AppAds_Test
 *
 * 针对 ../../core/ControllerFactory.class.php ControllerFactory 类的PHPUnit单元测试
 *
 * @author: dogstar 20140630
 */

require_once dirname(__FILE__) . '/test_env.php';

if (!class_exists('ControllerFactory')) {
    require dirname(__FILE__) . '/../' . '../../core/ControllerFactory.class.php';
}

class PhpUnderControl_ControllerFactory_Test extends PHPUnit_Framework_TestCase
{
    public $controllerFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->controllerFactory = new ControllerFactory();
    }

    protected function tearDown()
    {
    }


    /**
     * @group returnFormat
     */ 
    public function testCreateControllerReturnFormat()
    {
        $rs = ControllerFactory::createController();
        $this->assertTrue(is_object($rs));
        $this->assertEquals('DefaultController', get_class($rs));
    }

    /**
     * @depends testCreateControllerReturnFormat
     * @group businessData
     */ 
    public function testCreateControllerBusinessData()
    {
        $_REQUEST['c'] = 'Examples';
        $_REQUEST['a'] = 'getWelcome';

        $rs = ControllerFactory::createController();

        unset($_REQUEST);

        $this->assertEquals('ExamplesController', get_class($rs));
    }

    /**
     * @expectedException ZenException
     */
    public function testCreateUnextsisController()
    {
        $_REQUEST['c'] = 'Examples404';
        $_REQUEST['a'] = 'getWelcome';

        $rs = ControllerFactory::createController();

        unset($_REQUEST);
    }

    /**
     * @expectedException ZenException
     */
    public function testCreateWithWrongFun()
    {
        $_REQUEST['c'] = 'Examples';
        $_REQUEST['a'] = 'getWelcome404';

        $rs = ControllerFactory::createController();

        unset($_REQUEST);
    }
}
