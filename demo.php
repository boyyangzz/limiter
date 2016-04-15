<?php
define("REDIS_HOST", '127.0.0.1');//服务器IP
define("REDIS_PASS", '123');//授权密码
define("REDIS_PORT", 6379);
#redis 限速配置
define("REDIS_COUNT", 60);//次数
define("REDIS_TIME", 7200);//时间 单位秒
include('limiter_class.php');


$userid=addslashes($_GET['userid']);
$new=new limiter_class();

$limit=$new->limit_redis($userid);
echo $limit['error']==-1 ? '访问频繁,稍后尝试' :  '正常访问';
