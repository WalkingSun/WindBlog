## 一、什么是跨域问题？

### 1.1 同源策略（Same-Origin Policy）

浏览器有一个安全机制叫“同源策略”，它规定：一个网页只能访问和它同源的资源。

什么是“同源”？三个条件必须全部相同：

- 协议（http/https）

- 域名（example.com）

- 端口（80/443/3000）

✅ 同源示例：

https://ai.qmniu.com → https://ai.qmniu.com/api/v1/user/info  ✅

http://localhost:3000 → http://localhost:3000/api/data       ✅

❌ 跨域示例：

http://localhost:3000 → https://api-ai.qmniu.com/api/v1/user/info  ❌

https://ai.qmniu.com → https://api-ai.qmniu.com/api/v1/user/info   ❌

http://ai.qmniu.com → https://ai.qmniu.com/api/v1/user/info        ❌（协议不同）

### 1.2 为什么需要跨域？

你的项目架构：

前端页面：https://ai.qmniu.com（用户访问的网页）

后端API：  https://api-ai.qmniu.com（提供数据的接口）

前端页面需要调用后端 API，但域名不同，浏览器会阻止这个请求。

## 二、CORS 是什么？

CORS（Cross-Origin Resource Sharing，跨域资源共享）是浏览器允许跨域访问的机制。

工作原理：后端在响应头中告诉浏览器“我允许哪些域名访问我”。

## 三、CORS 的工作原理

### 3.1 两种请求类型

#### 简单请求（Simple Request）

条件（需同时满足）：

- 方法：GET、POST、HEAD

- 请求头：只能是简单请求头（如 Content-Type: text/plain）

- 无自定义请求头

流程：

1. 浏览器直接发送请求

2. 后端返回数据 + CORS 响应头

3. 浏览器检查 CORS 头，如果允许就显示数据

#### 预检请求（Preflight Request）

当不满足简单请求条件时，浏览器会先发送一个 OPTIONS 请求询问：

1. 浏览器发送 OPTIONS 预检请求

   ↓

2. 后端返回允许的配置（CORS 头）

   ↓

3. 浏览器检查，如果允许，再发送真正的请求

   ↓

4. 后端返回数据 + CORS 头

### 3.2 实际例子

你的项目中的例子（从测试脚本中可以看到）：

# 这是一个预检请求

OPTIONS /api/v1/workflow/run

Headers:

  Origin: http://localhost:3000

  Access-Control-Request-Method: POST

  Access-Control-Request-Headers: Content-Type

浏览器在问：“localhost:3000 想用 POST 方法发送 Content-Type 头，可以吗？”

后端回答（通过 CORS 响应头）：

Access-Control-Allow-Origin: http://localhost:3000

Access-Control-Allow-Methods: POST, GET, OPTIONS, ...

Access-Control-Allow-Headers: Content-Type, ...

Access-Control-Allow-Credentials: true

浏览器看到这些头后，才会发送真正的 POST 请求。

## 四、项目中每个 CORS 响应头的含义

让我们看看你的代码中每个头的作用：

// 1. Access-Control-Allow-Origin

// 告诉浏览器：允许哪个域名访问

c.Header("Access-Control-Allow-Origin", allowOrigin)

// 例如：Access-Control-Allow-Origin: https://ai.qmniu.com

// 或者：Access-Control-Allow-Origin: * （允许所有，但和 credentials 不能同时用）

// 2. Access-Control-Allow-Credentials

// 告诉浏览器：允许携带 Cookie、Authorization 等凭证

c.Header("Access-Control-Allow-Credentials", "true")

// 注意：如果设为 true，Allow-Origin 不能是 *

// 3. Access-Control-Allow-Headers

// 告诉浏览器：允许前端发送哪些自定义请求头

c.Header("Access-Control-Allow-Headers", "Content-Type, Authorization, Token, ...")

// 前端可以发送这些头，否则会被浏览器拦截

// 4. Access-Control-Allow-Methods

// 告诉浏览器：允许使用哪些 HTTP 方法

c.Header("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE, UPDATE")

// 5. Access-Control-Expose-Headers

// 告诉浏览器：哪些响应头可以被前端 JavaScript 读取

c.Header("Access-Control-Expose-Headers", "Content-Type, Authorization, ...")

// 默认只能读取：Cache-Control, Content-Language, Content-Type, Expires, Last-Modified, Pragma

// 6. Access-Control-Max-Age

// 告诉浏览器：预检请求的结果可以缓存多久（秒）

c.Header("Access-Control-Max-Age", "172800")  // 2天

// 浏览器在 2 天内不会重复发送 OPTIONS 请求

## 五、为什么项目要设计两层 CORS？

### 5.1 架构图
```
┌─────────────────────────────────────────────────────────┐
│  浏览器 (https://ai.qmniu.com)                          │
└──────────────────────┬──────────────────────────────────┘
                       │ HTTP 请求
                       ↓
┌─────────────────────────────────────────────────────────┐
│  Nginx Ingress Controller (第一层 CORS)                 │
│  - 快速处理 OPTIONS 预检请求                             │
│  - 统一配置，减少后端压力                                │
│  - 作为安全第一道防线                                    │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ↓
┌─────────────────────────────────────────────────────────┐
│  Kubernetes Service                                     │
└──────────────────────┬──────────────────────────────────┘
                       │
                       ↓
┌─────────────────────────────────────────────────────────┐
│  Pod (后端应用) - Gin 中间件 (第二层 CORS)               │
│  - 业务逻辑判断（动态 Origin 验证）                      │
│  - 错误响应时确保 CORS 头存在                            │
│  - 灵活的调试和日志                                      │
└─────────────────────────────────────────────────────────┘
```

### 5.2 为什么需要两层？

#### 第一层：Ingress 层（Nginx）

作用：

1. 性能优化：在网关层快速处理 OPTIONS，减少后端负载

2. 统一配置：所有服务共享同一套 CORS 配置

3. 提前拦截：不合法请求在网关层就被拒绝

代码位置：deployments/backend/templates/ingress.yaml

nginx.ingress.kubernetes.io/enable-cors: 'true'

nginx.ingress.kubernetes.io/cors-allow-methods: 'POST, GET, OPTIONS, ...'

# 如果匹配，直接返回，不转发到后端

#### 第二层：后端中间件（Gin）

作用：

1. 精确控制：根据业务逻辑动态判断 Origin

2. 错误处理：即使返回 4xx/5xx，也确保有 CORS 头

3. 灵活调试：可以在代码中打日志、断点调试

代码位置：backend/api/middleware/cors.go

```go

// 根据环境动态判断

switch os.Getenv("APP_MODE") {

case "local":

    allowOrigin = "*"

case "test1":

    // 只允许特定域名

    if origin == "https://ai-t.qmniu.com" || ...

case "prod":

    // 生产环境更严格

    if origin == "https://ai.qmniu.com" {

        allowOrigin = origin

    }

}


```

### 5.3 两层配合的优势

#### 场景 1：正常请求

1. 浏览器发送 OPTIONS 预检

   ↓

2. Ingress 层：快速处理，返回 CORS 头 ✅

   ↓

3. 浏览器发送真正的 POST 请求

   ↓

4. Ingress 层：添加 CORS 头，转发到后端

   ↓

5. 后端中间件：再次验证，确保安全 ✅

   ↓

6. 返回数据（两层都有 CORS 头）

#### 场景 2：错误响应

1. 浏览器发送请求

   ↓

2. Ingress 层：添加 CORS 头，转发到后端

   ↓

3. 后端处理出错，返回 500 错误

   ↓

4. 后端中间件：确保错误响应也有 CORS 头 ✅

   ↓

5. 浏览器能正常读取错误信息（不会因为缺少 CORS 头而拦截）

#### 场景 3：恶意请求

1. 恶意网站尝试访问你的 API

   ↓

2. Ingress 层：检查 Origin，不匹配，拒绝或添加空 CORS 头

   ↓

3. 即使通过了 Ingress，后端中间件也会再次验证 ✅

   ↓

4. 双重保护，更安全

## 六、项目设计的具体原因

### 6.1 环境隔离

不同环境需要不同的跨域策略：

```go


// 本地开发：允许所有（方便调试）

case "local":

    allowOrigin = "*"

// 测试环境：允许测试域名和 localhost（方便测试）

case "test1":

    if origin == "https://ai-t.qmniu.com" || 

       origin == "http://ai-t.qmniu.com" || 

       strings.HasPrefix(origin, "http://localhost") {

        allowOrigin = origin

    }

// 生产环境：只允许生产域名（最严格）

case "prod":

    if origin == "https://ai.qmniu.com" {

        allowOrigin = origin

    }
    ```

### 6.2 性能考虑

- Ingress 层：用 Nginx 快速处理 OPTIONS，减少后端压力

- 缓存：Access-Control-Max-Age: 172800（2天），减少重复预检

### 6.3 安全性

- 白名单：只允许特定域名

- 双重验证：Ingress + 后端中间件

- 凭证保护：Access-Control-Allow-Credentials: true 时，不能使用 *

### 6.4 可维护性

- 统一配置：Ingress 层统一管理基础配置

- 灵活调整：后端可以根据业务逻辑动态调整

- 易于调试：后端可以打日志、断点

## 七、实际请求流程示例

假设前端 https://ai.qmniu.com 调用 POST /api/v1/workflow/run：

步骤 1：浏览器发送 OPTIONS 预检请求

─────────────────────────────────────
```

Request:

  Method: OPTIONS

  Origin: https://ai.qmniu.com

  Access-Control-Request-Method: POST

  Access-Control-Request-Headers: Content-Type, Authorization

Response (Ingress 层):

  Access-Control-Allow-Origin: https://ai.qmniu.com

  Access-Control-Allow-Methods: POST, GET, OPTIONS, ...

  Access-Control-Allow-Headers: Content-Type, Authorization, ...

  Access-Control-Allow-Credentials: true

  Access-Control-Max-Age: 172800
  ```

步骤 2：浏览器发送真正的 POST 请求

─────────────────────────────────────
```
Request:

  Method: POST

  Origin: https://ai.qmniu.com

  Content-Type: application/json

  Authorization: Bearer xxx

  Body: {...}

Response (后端处理 + 两层 CORS 头):

  Access-Control-Allow-Origin: https://ai.qmniu.com

  Access-Control-Allow-Credentials: true

  Content-Type: application/json

  Body: {"code": 200, "data": {...}}
  ```

## 总结

1. CORS 解决跨域问题：让不同域名的前端可以访问后端 API

2. 两层设计的原因：

- Ingress 层：性能优化，快速处理预检请求

- 后端中间件：精确控制，确保错误响应也有 CORS 头

1. 安全考虑：双重验证，环境隔离，白名单机制

2. 实际效果：前端可以正常调用后端 API，浏览器不会拦截

这样设计既保证了性能，又保证了安全性和灵活性。





## ingress案例：
```yaml
apiVersion: networking.k8s.io/v1

kind: Ingress

metadata:

annotations:

nginx.ingress.kubernetes.io/backend-protocol: "HTTP"

nginx.ingress.kubernetes.io/ssl-redirect: "true"

nginx.ingress.kubernetes.io/force-ssl-redirect: "true"

nginx.ingress.kubernetes.io/whitelist-source-range: "192.168.0.0/16,10.0.0.0/8,172.16.0.0/12,180.169.86.54,220.248.25.99,58.49.206.134,122.115.224.200/29,123.127.228.248/29,39.155.184.151,59.49.203.122,47.245.41.165,218.28.5.58,61.52.18.251,123.58.10.194/32,123.58.10.195/32,101.126.59.19/32,101.126.59.20/32,101.126.59.21/32,101.126.59.22/32,101.126.59.23/32,101.126.59.24/32,101.126.59.78/32,101.126.59.79/32,101.126.59.80/32,101.126.59.81/32,101.126.59.82/32,122.14.241.24/32,122.14.241.25/32,122.14.241.26/32,122.14.241.27/32,122.14.241.28/32,36.110.131.0/24,106.38.226.0/24,106.38.221.64/26,106.38.221.128/26,180.97.54.0/25,221.194.170.128/25,221.194.187.128/25,221.194.189.0/27,116.132.239.0/24,116.132.184.64/26,116.132.184.8/29,116.147.22.0/25,121.30.179.0/24,121.30.178.80/28,121.30.178.16/28,111.62.106.0/24,111.62.113.176/28,111.63.61.128/25,111.63.211.128/25,183.201.126.0/24,183.201.116.64/27,183.201.116.0/26,183.201.116.128/26,221.181.196.0/25,220.243.131.0/24,123.103.48.12/30,123.103.49.12/30,123.58.10.0/24,47.102.140.60,122.115.224.200/29,39.155.184.151,114.242.191.56/29,123.56.92.212"

nginx.ingress.kubernetes.io/cors-allow-methods: 'POST, GET, OPTIONS, PUT, DELETE, UPDATE'

nginx.ingress.kubernetes.io/cors-allow-headers: 'Content-Type, Test-Env, Authorization, Qm-Params, Qmp, Content-Length, X-CSRF-Token, Token, Session, X-Qm-Devops-Token, X-Qm-Csrf-Token'

nginx.ingress.kubernetes.io/cors-expose-headers: 'Content-Type, Test-Env, Authorization, Qm-Params, Qmp, Content-Length, Access-Control-Allow-Origin, Access-Control-Allow-Headers, Date, X-Qm-Devops-Token, X-Qm-Csrf-Token'

nginx.ingress.kubernetes.io/cors-max-age: '172800'

nginx.ingress.kubernetes.io/cors-allow-credentials: 'true'

nginx.ingress.kubernetes.io/enable-cors: 'true'

{{- if eq .Values.env.mode "test1" }}
# nginx配置片段：只有当请求的 Origin 在白名单里时，Ingress 才把 Access-Control-Allow-Origin 设置为该 Origin，并加 Vary: Origin 防缓存串号；always 确保错误响应也带 CORS 头。
nginx.ingress.kubernetes.io/configuration-snippet: |

# 根据请求头里的 Origin 做白名单匹配
if ($http_origin ~* "^(https?://(ai-t\.qmniu\.com|ai\.qmniu\.com|api-ai-t\.qmniu\.com|api-ai\.qmniu\.com))$") {

set $allow_origin $http_origin;   

}

# 动态写入响应头 Access-Control-Allow-Origin
add_header Access-Control-Allow-Origin $allow_origin always; 

add_header Vary Origin always; # 告诉浏览器根据Origin动态缓存响应（- 否则会出现“先 A 域请求缓存了 Allow-Origin: A，后 B 域拿到同一个缓存响应但头还是 A”，导致跨域异常或安全问题。）

{{- else if eq .Values.env.mode "prod" }}

nginx.ingress.kubernetes.io/configuration-snippet: |

if ($http_origin ~* "^(https?://(ai-t\.qmniu\.com|ai\.qmniu\.com|api-ai-t\.qmniu\.com|api-ai\.qmniu\.com))$") {

set $allow_origin $http_origin;

}

add_header Access-Control-Allow-Origin $allow_origin always;

add_header Vary Origin always; # 告诉浏览器根据Origin动态缓存响应

{{- else }}

nginx.ingress.kubernetes.io/cors-allow-origin: '*'

{{- end }}

name: {{ .Values.app.name }}-ingress-api

namespace: {{ .Values.namespace }}

labels:

name: {{ .Values.app.name }}-ingress-api

spec:
```