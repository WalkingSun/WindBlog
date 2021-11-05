package main

import (
	"fmt"
	"strconv"
	"time"
)

/** 现在有一个日志收集任务触发的功能，日志条数达到100条或距上次存储间隔5分钟就需要触发一次日志存储的功能，请写出实现该功能的核心代码**/

func main() {
	logChan := make(chan string, 1000)
	go func() {
		logs := make([]string, 0, 1000)

		ticker := time.NewTicker(time.Minute * 1)
		startTime := time.Now().Unix()
		for {
			select {
			case <-ticker.C:
				logs = make([]string, 0, 1000)
				if lastTIme-startTIme >= 300*time.Second {
					// TODO日志存储

				}
				lastTIme = time.Now().Unix()
			case log := <-logChan:
				logs = append(logs, log)
				if len(logs) >= 100 {
					// TODO日志存储
					logs = make([]string, 0, 1000)
					lastTIme = time.Now().Unix()
				}
			}
		}
	}()

	// 模拟并发执行
	for i := 0; i < 10000; i++ {
		go func() {
			// 日志接收
			go func() {
				logChan <- fmt.Sprintf("日志：%s", strconv.Itoa(i))
			}()

			// 业务处理
		}()
	}

	select {}
}
