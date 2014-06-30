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
    }

    protected function tearDown()
    {
    }

    public function testGetName()
    {
        $this->controller = new Controller_Mock();
        $rs = $this->controller->getName();
        $this->assertEquals(array (
            'mark' => 'getName',
            'name' => 'nobody',
        ), $rs);
    }

    public function testGetNameLikeWebServices()
    {
        $_REQUEST['a'] = 'getName';
        $_REQUEST['c'] = 'Controller_Mock';
        $_REQUEST['name'] = 'dogstar';

        $this->controller = new Controller_Mock();
        $rs = $this->controller->getName();

        unset($_REQUEST);

        $this->assertEquals(array (
            'mark' => 'getName',
            'name' => 'dogstar',
        ), $rs);
    }
}

class Controller_Mock extends Controller
{
    protected function getRules()
    {
        return array(
            '*' => array(
                'name' => array('type' => 'string',
                'default' => 'nobody',
                'require' => false,
                ),
            ),
        );
    }

    public function getName()
    {
        $this->succeed();
        return array('mark' => 'getName', 'name' => $this->name);
    }
}
