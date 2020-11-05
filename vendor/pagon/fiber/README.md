
## Fiber?

Fiber 是一个基于PHP5.3的 `Dependency Injection Container` [介绍](http://www.potstuck.com/2009/01/08/php-dependency-injection/)

Fiber 在一些API上借鉴了 [Pimple](https://github.com/fabpot/Pimple), 但是使用的对象调用方式

[Fiber](https://github.com/hfcorriez/fiber)是该库的基础，与其不同之处在于`Pagon\Fiber`默认继承了[EventEmitter](https://github.com/hfcorriez/php-eventemitter)，方便基于Fiber就能够有事件驱动。

## 依赖

- PHP5.3+

## 安装

### 直接require文件

```php
require_once '/path/to/Fiber.php';
```

### 使用 [composer](http://getcomposer.org)

添加

```
"pagon/fiber": "*"
```

到`composer.json`
接着安装

```
composer.phar install
```


## 使用

创建空的容器

```php
$dic = new Fiber();
```

创建带成员的容器

```php
$dic = new Fiber(array(
    'db' => new Database();
));
```

## 例子

### 定义参数

使用对象成员赋值的方式来定义参数

```php
$dic->db_host = 'localhost';
$dic->db_name => 'test';
```

使用对象成员调用的方式来获取

```php
$db_host = $dic->db_host;
```

### 定义服务

使用对象成员赋值的方式来定义一个匿名函数作为服务

```php
// $dic也会做为参数传入

$dic->random = function ($dic) {
    return random();
};

$dic->time = function ($dic) {
    return time();
};
```

使用的时候直接调用成员

```php
$random = $dic->random;
$time = $dic->time;
```

`注意`

> 每次获取成员，函数都会被重新调用，所以不适合做数据库，缓存等需要连接资源的服务

### 定义共享服务

定义共享服务是指对给出的定义单例化，比较适合用来数据库对象等服务

```php

// 标准方式
$dic->db = $dic->share(function ($dic) {
    return new Database($dic->db_host);
});

// 键名定义方式
$dic->share('db', function ($dic) {
    return new Database($dic->db_host);
});
```

使用

```php
$db = $dic->db;

// 如果重新调用

$db1 = $dic->db // 这时候$db1和$db共享同一个数据库
```

### 自定义函数

自定义函数允许你配置一个自己可完全控制的函数，函数不会作为服务提供

```php

// 标准定义
$dic->save = $dic->protect(function($key, $value){
    return $_SESSION[$key] = $value;
})

// 键名定义
$dic->protect('save', function($key, $value){
    return $_SESSION[$key] = $value;
})
```

使用

```php
// 获取函数再调用
$save = $dic->save;
$save('test', 'value');

// 直接调用
$dic->save('test', 'value');
```

### 扩展服务

扩展服务允许对现有的服务进行加工，并返回新的服务

`注意：只能使用键名的方式进行扩展，如果要想保持共享服务，扩展时也需要使用共享定义`

```php
$dic->extend('db', $dic->share(function ($db, $dic) {
    $db->select($dic->db_name);
    return $db;
}));
```

## License

(The MIT License)

Copyright (c) 2012 hfcorriez &lt;hfcorriez@gmail.com&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.