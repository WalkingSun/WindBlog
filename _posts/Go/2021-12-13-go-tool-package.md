---
layout: blog
title: Go 工具包
categories: [Go]
description: 熟悉
keywords: Go
---

# cobra
https://github.com/spf13/cobra

参考 https://github.com/spf13/cobra/blob/master/user_guide.md

有介绍PreRun and PostRun Hooks用法··


# goimports-reviser
import分组管理利器
https://github.com/incu6us/goimports-reviser

```
goimports-reviser -rm-unused -set-alias -format ./
```

https://zhuanlan.zhihu.com/p/411181637

# Diff
```
package diff  
  
import (  
   "fmt"  
   "strings"   "testing"  
   "github.com/sergi/go-diff/diffmatchpatch")  
  
const (  
   text1 = `  
Lorem  
3  
ipsum  
2  
dolor.`  
   text2 = `  
1  
Lorem  
dolor  
4  
sit  
amet.  
5`  
)  
  
func TestDiff(t *testing.T) {  
   dmp := diffmatchpatch.New()  
  
   diffs := dmp.DiffMain(text1, text2, false)  
  
   dels := ""  
   adds := ""  
   for _, v := range diffs {  
      if v.Type == diffmatchpatch.DiffDelete {  
         dels += v.Text  
         continue  
      }  
      if v.Type == diffmatchpatch.DiffInsert {  
         adds += v.Text  
         continue  
      }  
   }  
   fmt.Println(strings.Split(dels, "\n"), strings.Split(adds, "\n"))  
   //fmt.Println(dmp.DiffPrettyText(diffs))  
}
```