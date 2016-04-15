<?php
class limiter_class {

    //初始连接redis
    function __construct() {
        $this->rlink = new Redis();
        $this->rlink->connect(REDIS_HOST,REDIS_PORT,10);
        $this->rlink->auth(REDIS_PASS);
    }


    //redis 接口限速器
    function limit_redis($userid)//可对验证的用户ID，IP地址参数
    {
        $redis=$this->rlink;
        $current = $redis ->lLen('limit:'.$userid);
        if ($current >= REDIS_COUNT) { //请求超限判断
            $data=array(
                "error"=>"-1",
            );
            $black_list=array(
                'userid'=>$userid,
                'time'=>time()
            );
            $redis->hSet('black_list',$userid,json_encode($black_list));//加入黑名单
            return $data;
        }
        if ($redis->exists('limit:'.$userid) == false) {
            $redis->multi();
            $redis->rPush('limit:'.$userid, 1);
            $redis->expire('limit:'.$userid, REDIS_TIME); //时间 秒
            $redis->exec();
        } else {
            $redis->rPush('limit:'.$userid, 1);
        }
        return $current;

    }


    function __destruct() {
        $this->close();
    }


    function close() {
        if ($this->redis_link) {
            $this->redis_link->close();
        }
    }


}

