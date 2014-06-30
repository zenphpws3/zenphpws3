<?php
/**
 * 单元测试骨架代码自动生成脚本
 * 主要是针对当前项目系列生成相应的单元测试代码，提高开发效率
 *
 * 用法：
 * Usage: php ./build_phpunit_test_tpl.php <file_path> <class_name> [bootstrap] [author = dogstar]
 *
 * 1、针对全部public的函数进行单元测试
 * 2、各个函数对应返回格式测试与业务数据测试
 * 3、源文件加载（在没有自动加载的情况下）
 *
 * 备注：另可使用phpunit-skelgen进行骨架代码生成
 *
 * @author: dogstar 20140630
 * @version: 2.0.0
 */

if ($argc < 3) {
    die("Usage: php $argv[0] <file_path> <class_name> [bootstrap] [author = dogstar]\n");
}

$filePath = $argv[1];
$className = $argv[2];
$bootstrap = isset($argv[3]) ? $argv[3] : null;
$author = isset($argv[4]) ? $argv[4] : 'dogstar';

if (!empty($bootstrap)) {
    require $bootstrap;
}

require $filePath;

if (!class_exists($className)) {
    die("Error: cannot find class($className). \n");
}

$reflector = new ReflectionClass($className);

$methods = $reflector->getMethods(ReflectionMethod::IS_PUBLIC);

date_default_timezone_set('Asia/Shanghai');
$objName = lcfirst(str_replace('_', '', $className));

$code = "<?php
/**
 * PhpUnderControl_AppAds_Test
 *
 * 针对 $filePath $className 类的PHPUnit单元测试
 *
 * @author: $author " . date('Ymd') . "
 */

";

if (file_exists(dirname(__FILE__) . '/test_env.php')) {
    $code .= "require_once dirname(__FILE__) . '/test_env.php';
";
}

$code .= "
if (!class_exists('$className')) {
    require dirname(__FILE__) . '/' . '$filePath';
}

class PhpUnderControl_" . str_replace('_', '', $className) . "_Test extends PHPUnit_Framework_TestCase
{
    public \$$objName;

    protected function setUp()
    {
        parent::setUp();

        \$this->$objName = new $className();
    }

    protected function tearDown()
    {
    }

";

foreach ($methods as $method) {
    if($method->class != $className) continue;

    $fun = $method->name;
    $Fun = ucfirst($fun);

    if (strlen($Fun) > 2 && substr($Fun, 0, 2) == '__') continue;

    $rMethod = new ReflectionMethod($className, $method->name);
    $params = $rMethod->getParameters();
    $isStatic = $rMethod->isStatic();
    $isConstructor = $rMethod->isConstructor();

    if($isConstructor) continue;

    $initParamStr = '';
    $callParamStr = '';
    foreach ($params as $param) {
        $initParamStr .= "
        \$" . $param->name . " = '';";
        $callParamStr .= '$' . $param->name . ', ';
    }
    $callParamStr = empty($callParamStr) ? $callParamStr : substr($callParamStr, 0, -2);

    $code .= "
    /**
     * @group returnFormat
     */ 
    public function test$Fun" . "ReturnFormat()
    {" . (empty($initParamStr) ? '' : "$initParamStr\n") . '
        ' . ($isStatic ? "\$rs = $className::$fun($callParamStr);": "\$rs = \$this->$objName->$fun($callParamStr);") . "
    }
";
    $code .= "
    /**
     * @depends test$Fun" . "ReturnFormat
     * @group businessData
     */ 
    public function test$Fun" . "BusinessData()
    {" . (empty($initParamStr) ? '' : "$initParamStr\n") . '
        ' . ($isStatic ? "\$rs = $className::$fun($callParamStr);": "\$rs = \$this->$objName->$fun($callParamStr);") . "
    }
";
}

$code .= "
}";

echo $code;
echo "\n";
