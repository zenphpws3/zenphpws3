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

class&nbsp;ExamplesController&nbsp;extends&nbsp;Controller
{
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;getRules()
&nbsp;&nbsp;&nbsp;&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'getWelcome'&nbsp;=>&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'name'&nbsp;=>&nbsp;array('type'&nbsp;=>&nbsp;'string',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'default'&nbsp;=>&nbsp;'nobody',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'require'&nbsp;=>&nbsp;false,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;}

&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;getWelcome()
&nbsp;&nbsp;&nbsp;&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->succeed();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;array('content'&nbsp;=>&nbsp;'Hello&nbsp;Wolrd',&nbsp;'name'&nbsp;=>&nbsp;$this->name);
&nbsp;&nbsp;&nbsp;&nbsp;}
}

HTTP请求

在实现了服务器接口后，就可以对其进行访问。如简单的直接使用浏览器输入接口链接（http方式）：http://localhost/index.php?c=examples&a=getWelcome&p=http&f=json，得到的结果如下：

{"status":"OK","data":{"content":"Hello Wolrd","name":"nobody"},"error":"","debug":[]}
