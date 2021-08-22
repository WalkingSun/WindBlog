layout: blog
title: Go并发模式
categories: [Go, 知识点]
description: 熟悉
keywords: Go
cnblogsClass: \[Markdown\],\[随笔分类\]Go
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]

# 背景

CSP（Communicating Sequential Process，通信顺序进程）模型，作为Go并发编程核心的CSP理论的核心概念只有一个：**同步通信**。

并发更关注的是程序的设计层面，并发的程序完全是可以顺序执行的，只有在真正的多核CPU上才可能真正地同时运行。

在并发编程中，对共享资源的正确访问需要精确地控制，在目前的绝大多数语言中，都是通过加锁等线程同步方案来解决这一困难问题，而Go语言却另辟蹊径，它将共享的值通过通道传递（实际上多个独立执行的线程很少主动共享资源）。Go语言将其并发编程哲学化为一句口号：**“不要通过共享内存来通信，而应通过通信来共享内存。”（Do not communicateby sharing memory; instead, share memory by communicating.）**

虽然像引用计数这类简单的并发问题通过原子操作或互斥锁就能很好地实现，但是通过通道来控制访问能够让你写出更简洁正确的程序。

# 并发执行

## 锁

```go
func main() {
  var mu sync.Mutex
  go func(){
    fmt.println("hello world")
    mu.Lock()
  }()
  mu.Unlock()
}
```

mu.Lock()和mu.Unlock()并不在同一个Goroutine中，所以也就不满足顺序一致性内存模型。

因为可能是并发的事件，所以main()函数中的mu.Unlock()很有可能先发生，而这个时刻mu互斥对象还处于未加锁的状态，因而会导致运行时异常。



改进：

```go
func main() {
  var mu sync.Mutex
  mu.Lock()
  go func(){
    fmt.println("hello world")
    mu.Unlock()
  }()
  mu.Unlock()
}
```

修复的方式是在main()函数所在线程中执行两次mu.Lock()，当第二次加锁时会因为锁已经被占用（不是递归锁）而阻塞，main()函数的阻塞状态驱动后台线程继续向前执行.退出的事件将是并发的：在main()函数退出导致程序退出时，后台线程可能已经退出了，也可能没有退出。

使用通道：

无缓存通道

```go
func main() {
  done := make(chan int)
   go func(){
    fmt.println("hello world")
    <-done
  }()
  done <- 1
}
```

待缓存通道

```go
func main() {
  done := make(chan int,1)
   go func(){
    fmt.println("hello world")
    done <- 1
  }()
  <-done
}
```

批量打印

```go
func main() {
  	var wg sync.WaitGroup
  // 开N个后台打印线程
  for i :=0; i < 10; i++ {
    wg.Add(1)
    go func() {
      fmt.Println("你好，世界")
      wg.Done()
    }
  }
  wg.Wait() //wg.Wait()是等待全部的事件完成。
}
```



## 生产-消费模型

```go
func Producer(out chan int) {
	for i := 0; i < 1000; i++ {
		out <- i
	}
	close(out)
}

func Consumer(in chan int, done chan bool) {
	for v := range in {
		fmt.Println("receive message ", v)
	}
	done <- true
}

func Producer2(out chan int, wg *sync.WaitGroup) {
	for i := 0; i < 1000; i++ {
		wg.Add(1)
		//go func(){
		out <- i
		//}()
	}
}

func Consumer2(in chan int, wg *sync.WaitGroup) {
	for v := range in {
		fmt.Println("receive message ", v)
		wg.Done()
	}
}


func TestProducerConsumer(t *testing.T) {
	done := make(chan bool, 100)
	ch := make(chan int)
	go Producer(ch)
	go Consumer(ch, done)
	<-done
}

func TestProducerConsumer2(t *testing.T) {
	ch := make(chan int, 10)
	wg := &sync.WaitGroup{}
	//Producer2(ch,wg)
	//go Consumer2(ch, wg)
	go Consumer2(ch, wg)
	Producer2(ch, wg)
	wg.Wait()
}

```

## 发布订阅模式

```go
type (
	subscriber chan interface{} // 订阅者
	topic      string           // 主题
)

func NewPublisher(timeout time.Duration, buffer int) *Publisher {
	return &Publisher{
		buffer:      buffer,
		timeout:     timeout,
		subscribers: make(map[subscriber]topic),
		wg:          make(map[subscriber]*sync.WaitGroup),
	}
}

type Publisher struct {
	m           sync.RWMutex                   // 读写锁
	buffer      int                            // 订阅队列缓冲区
	timeout     time.Duration                  // 发布超时时间
	subscribers map[subscriber]topic           // 订阅者
	wg          map[subscriber]*sync.WaitGroup // 等待组
}

// 订阅主题
func (p *Publisher) Subscribe(topic topic) chan interface{} {
	ch := make(chan interface{}, p.buffer)
	p.m.Lock()
	defer p.m.Unlock()
	p.subscribers[ch] = topic
	p.wg[ch] = &sync.WaitGroup{}
	return ch
}

// 取消订阅
func (p *Publisher) UnSubscribe(sub chan interface{}) {
	p.m.Lock()
	defer p.m.Unlock()
	delete(p.subscribers, sub)
	close(sub)
}

// 发布消息
func (p *Publisher) Publish(topic topic, v interface{}) {
	p.m.RLock()
	defer p.m.RUnlock()
	var wg sync.WaitGroup
	existTopic := false
	for sub, topic2 := range p.subscribers {
		if topic2 == topic {
			wg.Add(1)
			go p.sendToTopic(sub, topic, v, &wg)
			existTopic = true
		}
	}
	if !existTopic {
		err := fmt.Sprintf("%s", topic) + " topic not exist"
		panic(err)
	}
	wg.Wait()
}

// 发送主题，设置一定的超时
func (p *Publisher) sendToTopic(sub subscriber, topic topic, v interface{}, wg *sync.WaitGroup) {
	defer wg.Done()
	if topic == "" {
		return
	}
	select {
	case sub <- v:
	case <-time.After(p.timeout):
	}
	p.wg[sub].Add(1)
}

// 关闭主题chan
func (p *Publisher) Close() {
	p.m.Lock()
	defer p.m.Unlock()
	for sub, _ := range p.subscribers {
		delete(p.subscribers, sub)
		close(sub)
	}
}

func (p *Publisher) Consume(in chan interface{}, dealFunc func(interface{})) {
	go func() {
		for v := range in {
			dealFunc(v)
			p.wg[in].Done()
		}
	}()
	p.wg[in].Wait()
}

...
func TestPublishSubscribe(t *testing.T) {
	p := NewPublisher(100*time.Microsecond, 10)
	defer p.Close()

	// 订阅者、订阅主题、主题发布消息
	tests := []struct {
		topic topic
		msg   interface{}
	}{
		0: {
			topic: "book",
			msg:   "Golang",
		},
		1: {
			topic: "book",
			msg:   "PHP",
		},
		2: {
			topic: "movie",
			msg:   "哈利波特",
		},
		3: {
			topic: "movie",
			msg:   "ring king",
		},
		4: {
			topic: "movie",
			msg:   "投名状",
		},
	}

	msgChans := make([]subscriber, len(tests))
	for k, tt := range tests {
		msgChans[k] = p.Subscribe(tt.topic)
		p.Publish(tt.topic, tt.msg)
	}
	for _, msgChan := range msgChans {
		p.Consume(msgChan, func(i interface{}) {
			fmt.Printf("receive message %v, subscriber %v \n", i, msgChan)
		})
	}
}
```

