
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





SELECT
        t1.creative_id as creative_id,
        t1.pos_id,
        imp,
        click,
        conversion,
        expect_income,
        income
        FROM
        (SELECT
            ad_creative_id as creative_id,
            pos_id,
            sum(ad_exp_cnt) as imp,
            sum(ad_clk_cnt) as click,
            SUM(ad_consume)/100000 as income
        FROM
            dm_cc_dsp_user_action_inc_d
        WHERE dt>= '2023-01-31'
        GROUP BY ad_creative_id,pos_id
        having sum(ad_exp_cnt)>0
        )t1
        LEFT JOIN
        (SELECT
            ad_creative_id as creative_id,
            pos_id,
            sum(ad_target_cost)/100 as expect_income,
            SUM (ad_oCPX_resp_cnt) as conversion
        FROM
            dm_cc_dsp_user_action_transform_inc_d
        WHERE dt>= '2023-01-31' and ad_campaign_id is not null 
        GROUP BY ad_creative_id, pos_id
        )AS t2
        ON t1.creative_id=t2.creative_id and t1.pos_id =t2.pos_id