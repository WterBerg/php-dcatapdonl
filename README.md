# wterberg/dcatapdonl

[![Build Status][travis-image]][travis-url] 
[![Quality Gate Status][sonarcloud-quality-image]][sonarcloud-quality-url]
[![Coverage][sonarcloud-coverage-image]][sonarcloud-coverage-url]
[![License: MIT][mit-image]][mit-url]

[travis-image]: https://travis-ci.org/WterBerg/php-dcatapdonl.svg?branch=master
[travis-url]: https://travis-ci.org/WterBerg/php-dcatapdonl
[sonarcloud-quality-image]: https://sonarcloud.io/api/project_badges/measure?project=WterBerg_php-dcatapdonl&metric=alert_status
[sonarcloud-quality-url]: https://sonarcloud.io/dashboard?id=WterBerg_php-dcatapdonl
[sonarcloud-coverage-image]: https://sonarcloud.io/api/project_badges/measure?project=WterBerg_php-dcatapdonl&metric=coverage
[sonarcloud-coverage-url]: https://sonarcloud.io/dashboard?id=WterBerg_php-dcatapdonl
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

wterberg/dcatapdonl is licensed under the MIT license. For more information visit the LICENSE.md file.
