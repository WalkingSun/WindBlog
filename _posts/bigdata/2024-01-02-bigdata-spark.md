
执行spark-sql
```shell
spark-sql --master yarn --deploy-mode client \
  --executor-cores 8 \
  --num-executors 70 \
  --executor-memory 16G \
  --driver-memory 8G \
  --conf spark.executor.memoryOverhead=4G \
  --conf spark.debug.maxToStringFields=100 \
  --conf spark.driver.maxResultSize=10G
```
