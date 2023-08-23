# WterBerg / PHP DCAT-AP-DONL

[github.com/WterBerg/php-dcatapdonl](https://github.com/WterBerg/php-dcatapdonl)

This package allows for creation and validation of datasets conforming to the [DCAT-AP-DONL 1.1](https://dcat-ap-donl.readthedocs.io) metadata standard.

## License

View the `LICENSE.md` file for licensing details.

## Installation

Installation of [`wterberg/dcat-ap-donl`](https://packagist.org/packages/wterberg/dcat-ap-donl) is done via [Composer](https://getcomposer.org).

```shell
composer require wterberg/dcat-ap-donl
```

## Usage

Usage can be as simple as:

```php
use DCAT_AP_DONL\DCATDataset;
use DCAT_AP_DONL\DCATLiteral;

$dataset = new DCATDataset();
$dataset->setTitle(new DCATLiteral('My new dataset');

$validation = $dataset->validate();
var_dump($validation->getMessages());
```
