Roku PHP Library
================================================

PHP Library for communication with Roku External Control Protocol

Installation
================

Installing via Composer
-----------------------
Install composer in a common location or in your project:

```bash
curl -s http://getcomposer.org/installer | php
```

Create the composer.json file as follows:

```json
{ 
    "require": {
        "phalcon/devtools": "dev-master"
    }
}
```

Run the composer installer:

```bash
php composer.phar install
```

Requirements
============

* PHP Version >=5.3.2.
* PHP Httpful Library

Usage
=====


```php


$roku = new \Roku\Roku("192.168.72.10", 8060, 0.2);

$roku->up();

$roku->select();

$roku->literals("test@gmail.com");

$roku->down();

$roku->down();

$roku->select();

```
Usage Commandline
=================

For the list of commands execute :

```bash

$ vendor/bin/roku --help

```

It displays :

```bash

PHP Roku Console

Usage: roku [OPTION] ..

-h <host>       Host
-p <port>       Port
-d <delay>      Delay between each command
-i              Interactive mode (Listens for keyboard keystrokes)
-c <commands>   Command mode (Specify commands to be executed, Example -c "up down test@gmail.com down select home")
-t              Test Mode (Does not send commands.Just simulates them.)
--help          Shows this help

```

Example usage of command and interactivemodes :

```bash

$ vendor/bin/roku -h 192.168.72.10 -p 8060 -d 1 -c "up test@gmailc.om down down select home"

$ vendor/bin/roku  -h 192.168.72.10 -d 1 -i

```

Running the tests
=================

First, install PHPUnit with `composer.phar install --dev`, then run
`./vendor/bin/phpunit`.
