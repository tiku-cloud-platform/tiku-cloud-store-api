## 项目文档

### 项目部署

#### 获取代码

```shell
git clone xxxx.git
```

#### 安装依赖包

```shell
cd /path/api/ && composer install
```
> /path/api为你的项目目录，与composer.json文件同级别目录。
#### 配置参数

```shell
APP_NAME=应用名称
APP_ENV=项目环境

DB_DRIVER=mysql
DB_HOST=数据库地址
DB_PORT=数据库端口号
DB_DATABASE=数据库名称
DB_USERNAME=数据库账号
DB_PASSWORD=数据库密码
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_PREFIX=数据库前缀

REDIS_HOST=Redis地址
REDIS_AUTH=Redis密码
REDIS_PORT=Redis端口号
REDIS_DB=Redis数据库

PASSWORD_SALT=商户端密码盐
```

#### NGINX配置

```shell
upstream 服务名称 {
 server php:9501;
}

server {
   listen 80;
   server_name 你的域名.com;

   access_log  /var/log/nginx/nginx.你的域名.com.access.log;
   error_log  /var/log/nginx/nginx.你的域名.com.error.log;

   location / {
         # 设置跨域
         add_header Access-Control-Allow-Origin *;
         add_header Access-Control-Allow-Methods *;
         add_header Access-Control-Allow-Headers 'X-Token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization,Store-Id,Current-Version,Client-Type';

         if ($request_method = 'OPTIONS') {
               return 204;
            }
         }

         proxy_set_header Host $http_host;
         proxy_set_header X-Real-IP $remote_addr;
         proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

         proxy_cookie_path / "/; secure; HttpOnly; SameSite=strict";

         proxy_pass http://服务名称;
   }
}
```
