# limiter
redis limiter

redis 限速器

针对各类接口实时监控数据访问量。一旦超限，就会加入黑名单，不能访问。


可对于IP地址和验证的用户进行限制。

可用于场景：投票，点赞，以及各类接口请求。

请求实例：

http://127.0.0.1/demo.php?userid=1
