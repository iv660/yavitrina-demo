INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
php composer.phar create-project --prefer-dist --stability=dev iv660/yavitrina-demo
~~~

CONFIGURATION
-------------

1. Create a copy of config/secure-default.ini configuration file with the name 
"secure.ini" and set parameters there according to your environment.

2. Run <code>php yii migrate</code>.