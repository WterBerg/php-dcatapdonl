# wterberg/dcatapdonl

[![Build Status][travis-image]][travis-url] 
[![codecov][codecov-image]][codecov-url]
[![License: MIT][mit-image]][mit-url]

[travis-image]: https://travis-ci.org/WterBerg/php-dcatapdonl.svg?branch=master
[travis-url]: https://travis-ci.org/WterBerg/php-dcatapdonl
[codecov-image]: https://codecov.io/gh/WterBerg/php-dcatapdonl/branch/master/graph/badge.svg
[codecov-url]: https://codecov.io/gh/WterBerg/php-dcatapdonl
[mit-image]: https://img.shields.io/badge/License-MIT-yellow.svg
[mit-url]: https://opensource.org/licenses/MIT

This package allows for creation and validation of datasets conforming to the DCAT-AP-DONL 1.1 
metadata standard, which is documented on [dcat-ap-donl.readthedocs.io](https://dcat-ap-donl.readthedocs.io).

## usage
Usage is a simple as:

```php
use DCAT_AP_DONL\DCATDataset;
use DCAT_AP_DONL\DCATLiteral;

$dataset = new DCATDataset();
$dataset->setTitle(new DCATLiteral('my Title');

$validation = $dataset->validate();
var_dump($validation->getMessages());
```

## dependencies

- PHP 7.2 and up
- PHP extension ext-curl
- PHP extension ext-json

## license

wterberg/dcatapdonl is licensed under the MIT license. For more information visit the LICENSE file.
