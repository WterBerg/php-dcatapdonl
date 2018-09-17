# wterberg/dcatapdonl

[![Build Status](https://travis-ci.org/WterBerg/php-dcatapdonl.svg?branch=master)](https://travis-ci.org/WterBerg/php-dcatapdonl)

This package allows for creation and validation of datasets conforming to the DCAT-AP-DONL 1.1 
metadata standard, which is documented on [dcat-ap-donl.readthedocs.io](https://dcat-ap-donl.readthedocs.io).

## usage
Usage is a simple as:

```php
use DCAT_AP_DONL\DCATDataset;

$dataset = new DCATDataset();
$validation = $dataset->validate();

var_dump($validation->getMessages());
```

## dependencies

- PHP 7.2 and up
- PHP extension ext-curl
- PHP extension ext-json

## testing

```commandline
composer.phar run-script test
```

## license

wterberg/dcatapdonl is licensed under the MIT license. For more information visit the LICENSE file.
