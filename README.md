# MVC 框架 - MPHP

**功能特性：**

 >* 使用MVC分层(其中M拆分成了Service层和Dao层)
 >* 方便的路由功能
 >* 多数据库支持
 >* I18N支持
 >* Redis/Cache缓存支持
 >* 集成日志类
 >* 集成SocketLog类，方便api调试

**目录结构：**

app 应用目录<br/>
|---- Configs 应用配置<br/>
|---- Controllers 应用控制器<br/>
|---- Dao 访问数据库层<br/>
|---- Helpers 存放函数库等的目录<br/>
|---- I18N 存放国际化的文件(po和mo文件)<br/>
|---- Models 应用模型类<br/>
|---- Services 业务逻辑类<br/>
|---- Views 视图页面<br/>
doc 文档目录<br/>
logs 项目日志目录<br/>
public 访问入口目录<br/>
|---- assets 静态文件目录<br/>
|&emsp;&emsp;|---- js 访问的js文件<br/>
|&emsp;&emsp;|---- css 访问的css文件<br/>
|&emsp;&emsp;|---- images 访问的images文件<br/>
|---------- index.php 入口文件<br/>
resources 静态资源目录<br/>
sql sql文件存放目录<br/>

框架参考了CI、ThinkPHP、SocketLog等开源产品,感谢创作这些框架的人们!!

框架不定期完善中...^ ^ 
