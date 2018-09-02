feature count
=============
功能使用频率统计

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist larax/feature-count "*"
```

or add

```
"larax/feature-count": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

在 web.php 中添加配置

```php
'as beforeRequest' => 
[
    'class' => 'larax\feature\AppFilter'
]