# WindBlog 博客及博客同步系统
一开始想做是就是自动发布博客到博客园，了解到MetaWeblog协议；后面又想自己搭建博客网站，发现这种Github Pages很好用，这种Jekyll规范的静态网页让我震撼很多，才发现可以这么玩，就想建一个博客网站和同步发布博客的服务系统，WindBlog诞生。


## 静态博客网站
使用的是Github Pages,源码分支：gh-pages（分支必须为这个），访问地址：username.github.io/WindBlog,username改为你的用户名。我用的是马志写的基于jekyll的皮肤（感谢大神）。
### 博客目录
- _posts 文件夹中是我已发布的博客文章。
-  _drafts 文件夹中是我尚未发布的博客文章。
-  _wiki 文件夹中是我已发布的 wiki 页面。
-  images 文件夹中是我的文章和页面里使用的图片。

## 博客同步系统
基于Yii2.0框架，对博客的管理、发布做些自动化。

### 数据库
~~sql文件放在public.sql,数据库名称jump，用的是PostGresql，
如果你用的事Mysql或者其他数据库，找些工具，例如DBConvert for MySQL & PostgreSQL，做下转换。~~
改变方案使用Yii Migrate数据迁移组件,优点支持各类数据库，控制台进入WindBlog目录,执行
```
php ./yii migrate/up
```

### 功能
当前支持 博客园、CSDN、51CTO、sina、163、oscina、chinaunix
- 初始化设置：配置你需要同步博客的账户信息
- 博客操作：添加记录、编辑记录、删除记录、同步操作
- 增加github同步服务。定时从github gh-pages分支上拉取所写博客，进行同步操作，解决手动操作。
添加到系统任务(crontab -e)：
```
*/30 * * * * php 【WindBlog路径】/yii autosync/index   #30分钟跑一次
```
- 增加队列处理服务，之前的手动操作还是支持的。
```
*/1 * * * * php 【WindBlog路径】/yii metaweblog/index  #每分钟跑一次
```

复杂度不高，觉得方便吧！

# to do
平时用的有道云笔记，平时记录什么的都放在上面，所以想打通[有道云笔记](http://note.youdao.com/open/apidoc.html)，可以同步过去;
可能有使用别的笔记的，如果你有兴趣加入我们。


<!-- ## 赞助 -->

喜欢点个赞呗(`・ω・´)

<!-- <img src="https://files.cnblogs.com/files/followyou/zfb.bmp" width="256" height="350" style="display:inline;"> -->
<!-- <img src="https://files.cnblogs.com/files/followyou/wx.bmp" width="256" height="350" style="display:inline;"> -->

## 贡献

有任何意见或建议都欢迎提 issue
