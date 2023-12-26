---
layout: blog
title: mac deal
categories: [工具, 快捷键]
description: 他山之石
keywords: Mac

---

记录些mac常用操作、快捷键，以备不时之需。

官方文档：

https://support.apple.com/zh-cn/HT201236

# 文件

- 创建目录：**``command + shift + N``**;
- 创建文件：使用文本编辑.app；
- 移至废纸篓：**```command + delete```**;
- **Command-O：**打开所选项，或打开一个对话框以选择要打开的文件。



# 应用

- **Option-Command-Esc**：[强制退出](https://support.apple.com/zh-cn/HT201276)应用。
- **Command-逗号 (,)**：打开最前面的应用的偏好设置。

## 应用限制地区
注册APPID，选择香港地区
https://github.com/oneclickearth/oneclick/blob/main/appleid.md

# 截屏

默认情况下，截屏会以“Screen Shot [日期] [时间].png”作为文件名存储到桌面。

- 拍摄截屏：**Shift-Command-3**；
- 捕捉屏幕上的某一部分：**Shift-Command-4**；
- 设置截屏选项：**```Shift-Command-5```**
  - 设置默认存储位置：桌面、剪贴板等；
  - 定时；
  - 截屏默认全屏、局部等；
  - 录屏；



# .bash_profile不起作用
soucr ~/.bash_profile
mac安装了Zsh，执行：source ~/.zshrc

# 默认输入法
https://www.liuvv.com/p/88c7abb.html


# 压缩
Mac 上用 unzip 命令解压带密码保护的 zip 文件报错 unsupported compression method 99  
解决办法： mac自带的解压工具，无法解密加密的文件。不要安装一个7zip的软件，  
mac上 brew install p7zip  
然后使用命令 7z x file.zip


# 标签页
https://support.apple.com/zh-cn/guide/mac-help/mchla4695cce/mac


# 端口占用
查找占用pid
```
lsof -i tcp:8080

kill pid
```

# python环境
https://blog.csdn.net/baidu_30506559/article/details/127386192


https://blog.csdn.net/qq_38603174/article/details/134187647


```
# To activate this environment, use
#
#     $ conda activate B
#
# To deactivate an active environment, use
#
#     $ conda deactivate

```



安装依赖
https://mofanpy.com/tutorials/python-basic/interactive-python/py-install-env


# 执行su
用su登录root用户，输入密码，都会提示su:Sorry，然后还怀疑自己记错了密码，其实不然。
正确方式：
```
sudo su
```