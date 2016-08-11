# MVC 框架 - MF

**功能特性：**

 >* 使用MVC分层(其中M拆分成了Service层和Dao层)
 >* 方便的路由功能
 >* 多数据库支持
 >* I18N支持

**目录结构：**

app 应用目录
|---- Configs 应用配置

|---- Controllers 应用控制器

|---- Dao 访问数据库层

|---- Helpers 存放函数库等的目录

|---- I18N 存放国际化的文件(po和mo文件)

|---- Models 应用模型类

|---- Services 业务逻辑类

|---- Views 视图页面

doc 文档目录

logs 项目日志目录

public 访问入口目录

|---- assets 静态文件目录

|&emsp;&emsp;|---- js 访问的js文件

|&emsp;&emsp;|---- css 访问的css文件

|&emsp;&emsp;|---- images 访问的images文件

|---------- index.php 入口文件

resources 静态资源目录

sql sql文件存放目录

框架参考了CI、ThinkPHP、SocketLog等开源产品,感谢创作这些框架的人们!!

这是纯粹为了学习而写的框架,后面再完善^ ^ 
