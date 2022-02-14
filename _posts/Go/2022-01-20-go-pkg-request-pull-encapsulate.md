队列通信 chan

构造第一页，及请求参数

请求接口推入总页数

失败重试，重新推入队列

记录错误信息

https://github.com/ph/moby/blob/1.12.x/pkg/pubsub/publisher.go#L22

```golang
package pkg

import (
	"sync"
)

// 三方接口拉取抽象处理
type Requester struct{
	requestFunc  RequestFunc
	processFunc  ProcessFunc
	wg           *sync.WaitGroup              // 控制chan退出
	queue        chan RequestFormat
	Retries      int						  // fail retries
	Tasks		 int 						  // set concurrency tasks
}

type RequestFunc func(RequestFormat) (ResponseFormat, error) // 定义接口请求func规范，行参标准请求格式，返回标准响应格式
type ProcessFunc func(ResponseFormat) error // 业务数据处理方法，行参为请准响应格式，return error

// standard request format
type RequestFormat struct{
	Page int
	Limit int
	fails int
	ReqFormat interface{}
}

// standard response format
type ResponseFormat struct{
	page int
	total int
	resFormat interface{}
}

func NewRequester(retries, tasks int) *Requester {
	return &Requester{
		Retries: retries,
		Tasks:  tasks,
		wg: &sync.WaitGroup{},
		queue: make(chan RequestFormat, 1000),
	}
}

func (r *Requester) SetRequestDeal(reqFunc RequestFunc) *Requester {
	r.requestFunc = reqFunc
	return r
}

func (r *Requester) SetDataProcess(repFunc ProcessFunc) *Requester {
	r.processFunc = repFunc
	return r
}

func (r *Requester) InitParams(params interface{}) *Requester {
	reqInfo := RequestFormat{
		Page: 1,
		Limit: 1,
		ReqFormat: params,
	}
	r.produce(reqInfo)
	return r
}

// error deal
// 1. return error slice 同步阻塞 （简单）
// 2. 定义形参error chan ，交给调用程序处理，如果err忘记处理，程序会堵塞
func(r *Requester) Run() (errs []error)  {
	wg := &sync.WaitGroup{}
	for i := 0; i < r.Tasks; i++ {
		wg.Add(1)
		go func() {
			defer wg.Done()
			errs = append(errs, r.pull()...)
		}()
	}
	r.close()
	wg.Wait()
	return errs
}


/**
request pull deal,return error slice
队列再抽象
 */
func(r *Requester) pull() (errs []error) {
	for reqInfo := range r.queue {
		func(reqInfo RequestFormat){
			defer r.wg.Done()
			res, err := r.requestFunc(reqInfo)
			if err != nil {
				if reqInfo.fails > r.Retries {
					errs = append(errs,err)
					return
				}
				reqInfo.fails++
				r.produce(reqInfo)
				return
			}

			// 首页拉取补充剩余页数
			if res.page == 1 {
				for i := 2; i <= res.total; i++ {
					reqInfo.Page = i
					r.produce(reqInfo)
				}
			}

			// data process
			err = r.processFunc(res)
			if err != nil {
				errs = append(errs,err)
			}
		}(reqInfo)
	}
	return errs
}

// sends the request data to channel 
func(r *Requester) produce(d RequestFormat) {
	defer r.wg.Add(1)
	r.queue <- d
}

// close the channel to all consumers
func(r *Requester) close() {
	r.wg.Wait()
	close(r.queue)
}
```