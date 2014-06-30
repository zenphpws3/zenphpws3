zenphpws3
=========

场景

目前我发现不少的项目都需要使用到调用服务器的接口获取相应的业务数据，实现客户端和服务器间的通信交互，特别在App应用和网站开发时尤其明显。但是就PHP程序员而言，大多数情况下都是使用CURL进行请求，甚至用fopen来操作。对于这种开发方式，就个人而言，不是说不好，只是不够好。也许不是因为性能上，也不是安全上，而是对于Web Services这一领域的规范上，毕竟我们要朝着专业的方向要求自己。

而且现在Web Services的思想和应用都已日渐成熟，还有REST这样的接口开发规范，以及SOAP、RPC等各种协议，和各种开源的开发框架。为什么不使用这些规范、协议和开发框架更好地进行接口请求呢？

这里的目的不是发明一种新的思想，或者是新的协议，而是把现在主流的Web Services各方面整合起来，并提供一个轻量级的开发构架，以应对服务器接口轻易编写和客户端的快速调用，让前后端的开发人员可以更加关注业务上的构建，进行无绪开发，同时又不丢失Web Services的好处。

所以，就有了zenphpWS3。
zenphpWS3简介

zenphpWS3是自主开发、利用PHP实现并基于phprpc的Web Services轻量级开发框架，融合了开源社区的优秀框架精神和相关开发框架、应用框架（如Yii、ThinkPHP、phpcms、RedBean 等），支持远程调用协调RPC、简单对象接入协议SOAP和HTTP协议，具有 便于开发、便于使用、便于扩展三大特点。

快速入门
服务端接口开发示例 - PHP

在部署好zenphpWS3开发框架后，添加新的接口类如：./services/Controllers/ExamplesController.class.php ，并实现了获取欢迎语的getWelcome接口，同时为该接口定义了非必须的类型为字符串的名字参数，默认值为nobody，然后返回结果。也就是服务器接口开发主要工作在于：参数规则定义+接口业务实现。

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

HTTP请求

在实现了服务器接口后，就可以对其进行访问。如简单的直接使用浏览器输入接口链接（http方式）：http://localhost/index.php?c=examples&a=getWelcome&p=http&f=json，得到的结果如下：

{"status":"OK","data":{"content":"Hello Wolrd","name":"nobody"},"error":"","debug":[]}


框架设计
服务器接口开发框架

由于对服务端接口开发框架已经有编写了文档进行详细说明，这里不再重复。但会挑一点值得关注和了解的点来进行说明。毕竟，当你决定使用第三方的框架或者SDK包时，应该了解其底层和原理，以便更好地利用和完善。同时不要绝对相信第三方，因为代码是人写，我们连自己的代码都不能完全相信，更不应该完全相信和依赖别人的代码。
统一入口

在开发框架部署好后，可以看到统一入口文件index.php。这里演示了加载和使用开发框架是如此的方便，如同很多其他开源框架一样。

<?php 
// 加载框架公共入口类文件 
require(dirname(__FILE__).'/ZenWebService.class.php'); 

//实例化一个Web Server应用实例 
ZenWebService::run(); 
?>

参数规则

这里的参数规则参考自很多框架（如Yii）对参数的处理方式。同样，为了减少后端开发人员对参数获取的关注，且加强对参数的过滤、检测和处理，这里引入了参数规则。这样的话，可以做到一条规则，多处使用。开发人员可以说不用任何开发量，只需要简单配置参数的规则，便可通过$this->name这样的方式获取客户端提供的参数。

当需要定义参数规则时，只需要在Controller类下重定义getRules()即可。如下：

    protected function getRules()
    {
        return array(
            '*' => array(
                'name' => array('type' => 'string',
                                'default' => 'nobody',
                                'require' => false,
                                ),
            ),
            'getInfo' => array(
                'sex' => array('type' => 'string',
                                'default' => 'unkonw',
                                'require' => false,
                                ),
                ),
            );
    }
    
    上面定义了两条参数规则，分别从上到下是姓名和性别。并且姓名name应用于该Controller下的全部接口，但性别sex只应用于getInfo接口。这两个参数都是非必须参数，且有默认值。

我想，参数规则应该是这个开发框架中比较有意思的一个地方。
接口验证

对于接口身份验证这一块，由于各项目的需求和约定不同，所以对于接口验证，各项目可以根据需求去实现。或者配置是否需要使用appKey和token。
