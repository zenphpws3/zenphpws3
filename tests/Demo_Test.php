<?php
/**
 * PhpUnderControl_AppAds_Test
 *
 * 针对 ./Demo.php Demo 类的PHPUnit单元测试
 *
 * @author: dogstar 20140630
 */


if (!class_exists('Demo')) {
    require dirname(__FILE__) . '/' . './Demo.php';
}

class PhpUnderControl_Demo_Test extends PHPUnit_Framework_TestCase
{
    public $demo;

    protected function setUp()
    {
        parent::setUp();

        $this->demo = new Demo();
    }

    protected function tearDown()
    {
    }


    /**
     * @group returnFormat
     */ 
    public function testIncReturnFormat()
    {
        $left = '';
        $right = '';

        $rs = $this->demo->inc($left, $right);
    }

    /**
     * @depends testIncReturnFormat
     * @group businessData
     */ 
    public function testIncBusinessData()
    {
        $left = '1';
        $right = '8';

        $rs = $this->demo->inc($left, $right);

        $this->assertEquals(9, $rs);
    }

}
