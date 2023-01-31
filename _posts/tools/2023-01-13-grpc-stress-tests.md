
GRPC压测工具

## Apache Jmter

配置说明：https://www.oschina.net/news/177976/jmeter-grpc-request-1-2-1-released

语言修改中文，文件：bin/jmeter.properties
```properties
#Preferred GUI language. Comment out to use the JVM default locale's language.
language=zh_CN
```


命令行执行测试计划：
```sh
# 切换到jmeter目录
bin/jmeter -n -t tests/RecommendSort.jmx -l tests/result/result.txt -e -o tests/webreport
```
说明：

`testplan/RedisLock.jmx` 为测试计划文件路径  
`testplan/result/result.txt` 为测试结果文件路径  
`testplan/webreport` 为web报告保存路径。

参考：https://www.cnblogs.com/stulzq/p/8971531.html


图标分析
https://blog.csdn.net/lijing742180/article/details/81183084


# ghz


