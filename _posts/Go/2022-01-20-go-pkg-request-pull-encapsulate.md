队列通信 chan

构造第一页，及请求参数

请求接口推入总页数

失败重试，重新推入队列

记录错误信息



```golang
type Req struct{
    RequestFunc(reqInfo)  func
    ResponseFunc(ResponseInfo)  func
    ErrorFunc(errorInfo) func
    queue chan reqInfo
    Retrys int
    wg Wait.Group               // 控制chan退出
    
}

type reqInfo struct{
    page int
    total int
    fails int
    reqFormat interface{}
}

type ResponseInfo struct{
    page int
    total int
    resFormat interface{}
}

func(r *Req) pull() {
    for reqInfo := range r.queue {
        res, err := r.RequestFunc(reqInfo)
        if err != nil {
        // 失败重试
            if reqInfo.fails > r.retry {
                // err 记录     
                continue
            }
           reqInfo.fails++
           r.queue <- reqInfo
           continue
        }
        
        // 数据处理
        ResponseFunc(res)
    }
}

//  初始化请求格式
func(r *Req) Init(reqFormat interface{}) {
    reqInfo := reqInfo{
        page: 1,
        total: 1,
        reqFormat: reqFormat,
    }
   res, err := r.RequestFunc(reqInfo)
   if err != nil {
       // err 记录
       return
   }
   for i := 1; i <= res.total; i++ {
      reqInfo.page = i
      r.queue <- reqInfo
   }
}

// TODO 错误信息提取

```