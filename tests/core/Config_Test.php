<?php
/**
 * PhpUnderControl_AppAds_Test
 *
 * 针对 ../../core/Config.class.php Config 类的PHPUnit单元测试
 *
 * @author: dogstar 20140630
 */

require_once dirname(__FILE__) . '/test_env.php';

if (!class_exists('Config')) {
    require dirname(__FILE__) . '/../' . '../../core/Config.class.php';
}

class PhpUnderControl_Config_Test extends PHPUnit_Framework_TestCase
{
    public $config;

    protected function setUp()
    {
        parent::setUp();

        $this->config = new Config();
    }

    protected function tearDown()
    {
    }


    /**
     * @group returnFormat
     */ 
    public function testGetReturnFormat()
    {
        $key = '';

        $rs = Config::get($key);
    }

    /**
     * @depends testGetReturnFormat
     * @group businessData
     */ 
    public function testGetBusinessData()
    {
        $key = 'DB_TYPE';
        $rs = Config::get($key);
        $this->assertEquals('mysql', $rs);

        $key = 'BAN_IPS';
        $rs = Config::get($key);
        $this->assertTrue(is_array($rs));

        $key = 'NOT_THIS_KEY';
        $rs = Config::get($key);
        $this->assertEquals(null, $rs);
    }

    /**
     * @group returnFormat
     */ 
    public function testSetReturnFormat()
    {
        $key = '';
        $value = '';

        $rs = Config::set($key, $value);
    }

    /**
     * @depends testSetReturnFormat
     * @group businessData
     */ 
    public function testSetBusinessData()
    {
        $key = 'DB_PORT';
        $value = '3307';

        $rs = Config::set($key, $value);

        $this->assertTrue($rs);
        $this->assertEquals('3307', Config::get($key));
    }

}
