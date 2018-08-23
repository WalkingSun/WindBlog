CREATE TABLE "public"."AM_user" (
"userid" SERIAL primary key,    -- 自增 主键
"mobile" varchar(30) COLLATE "default" NOT NULL,
"password" varchar(30) COLLATE "default" NOT NULL,
"userIn.userPasswd" varchar(255) COLLATE "default" NOT NULL,
"imei" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"token" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"imsi" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"remark" varchar(255) COLLATE "default" DEFAULT ''::character varying NOT NULL,
"isDelete" int2 DEFAULT 0,
"loginClass" int2,
"clientVersion" varchar(32) COLLATE "default" DEFAULT '5.1.4'::character varying
)
WITH (OIDS=FALSE)
;

ALTER TABLE "public"."AM_user" OWNER TO "postgres";

COMMENT ON COLUMN "public"."AM_user"."userIn.userPasswd" IS '设备加密串';

COMMENT ON COLUMN "public"."AM_user"."imei" IS '设备imei';

COMMENT ON COLUMN "public"."AM_user"."token" IS '设备token';

COMMENT ON COLUMN "public"."AM_user"."imsi" IS '设备imsi';

COMMENT ON COLUMN "public"."AM_user"."isDelete" IS '是否删除 1是；0否';

COMMENT ON COLUMN "public"."AM_user"."clientVersion" IS '版本';



CREATE TABLE "public"."AM_failQueue" (
"queue_id" SERIAL primary key,
"mobile" varchar(30) COLLATE "default" NOT NULL,
"userIn.userPasswd" varchar(64) COLLATE "default" NOT NULL,
"imei" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"token" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"imsi" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"remark" varchar(255) COLLATE "default" DEFAULT ''::character varying,
"count" int4 DEFAULT 0,
"createtime" date,
"isDelete" int2 DEFAULT 0
)
WITH (OIDS=FALSE)
;

ALTER TABLE "public"."AM_failQueue" OWNER TO "postgres";

COMMENT ON COLUMN "public"."AM_failQueue"."count" IS '失败计数';

CREATE TABLE "public"."jp_blogRecord" (
"id"  SERIAL ,
"title" varchar(255) COLLATE "default",
"content" varchar(8000) COLLATE "default",
"fileurl" varchar(255) COLLATE "default",
"cnblogsId" varchar(32) COLLATE "default",
"51ctoId" varchar(32) COLLATE "default",
"sinaId" varchar(32) COLLATE "default",
"csdnId" varchar(32) COLLATE "default",
"163Id" varchar(32) COLLATE "default",
"oschinaId" varchar(32) COLLATE "default",
"chinaunixId" varchar(32) COLLATE "default",
"cnblogsType" varchar(32) COLLATE "default",
"createtime" date,
"isDelete" int2 DEFAULT 0,
CONSTRAINT "jp_blogRecord_pkey" PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;

ALTER TABLE "public"."jp_blogRecord" OWNER TO "postgres";

COMMENT ON COLUMN "public"."jp_blogRecord"."id" IS '博客记录表';

COMMENT ON COLUMN "public"."jp_blogRecord"."title" IS '标题';

COMMENT ON COLUMN "public"."jp_blogRecord"."content" IS '内容';

COMMENT ON COLUMN "public"."jp_blogRecord"."fileurl" IS '文件地址';

COMMENT ON COLUMN "public"."jp_blogRecord"."cnblogsId" IS 'cnblog博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."51ctoId" IS '51cto博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."sinaId" IS 'sina博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."csdnId" IS 'csdn博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."163Id" IS '163博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."oschinaId" IS 'oschina博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."chinaunixId" IS 'chinaunix博客id';

COMMENT ON COLUMN "public"."jp_blogRecord"."cnblogsType" IS '博客分类';

COMMENT ON COLUMN "public"."jp_blogRecord"."createtime" IS '创建时间';

COMMENT ON COLUMN "public"."jp_blogRecord"."isDelete" IS '是否删除 1 是；0否';

CREATE TABLE "public"."jp_blogQueue" (
"queueId" SERIAL,
"blogId" int4 NOT NULL,
"action" int2 DEFAULT 1,
"publishStatus" int2,
"response" varchar(500) COLLATE "default",
"createtime" date,
"updatetime" date,
"blogType" int2,
CONSTRAINT "jp_blogQueue_pkey" PRIMARY KEY ("queueId", "blogId")
)
WITH (OIDS=FALSE)
;

ALTER TABLE "public"."jp_blogQueue" OWNER TO "postgres";

COMMENT ON COLUMN "public"."jp_blogQueue"."blogId" IS '博客记录id';

COMMENT ON COLUMN "public"."jp_blogQueue"."action" IS '执行动作，1 创建，2 更新，3 删除';

COMMENT ON COLUMN "public"."jp_blogQueue"."publishStatus" IS '发布状态 0 待发布，1 发布中，2 发布完成，3 发布失败';

COMMENT ON COLUMN "public"."jp_blogQueue"."response" IS '响应';

COMMENT ON COLUMN "public"."jp_blogQueue"."updatetime" IS 'blog发送队列';

COMMENT ON COLUMN "public"."jp_blogQueue"."blogType" IS '博客类型 1代表51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix';

CREATE TABLE "public"."jp_blogConfig" (
  "blogType" int2 NOT NULL,
  "username" varchar(64) COLLATE "default" NOT NULL,
  "password" varchar(64) COLLATE "default" NOT NULL,
  "blogid" varchar(64) COLLATE "default",
  "isEnable" int2 DEFAULT 1
)
WITH (OIDS=FALSE)
;

ALTER TABLE "public"."jp_blogConfig" OWNER TO "postgres";

COMMENT ON COLUMN "public"."jp_blogConfig"."blogType" IS '博客类型 1代表51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix';

COMMENT ON COLUMN "public"."jp_blogConfig"."username" IS '用户名';

COMMENT ON COLUMN "public"."jp_blogConfig"."password" IS '密码';

COMMENT ON COLUMN "public"."jp_blogConfig"."blogid" IS '博客地址Id';

COMMENT ON COLUMN "public"."jp_blogConfig"."isEnable" IS '是否启用 1是，0 否';
