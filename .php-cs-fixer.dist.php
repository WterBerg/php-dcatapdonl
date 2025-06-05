<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

use Composer\InstalledVersions;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use XpertSelect\Tools\ProjectType;

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

include 'vendor/autoload.php';

$package = InstalledVersions::getRootPackage()['name'];
$rules   = include ProjectType::Standard->phpCsFixerRuleFile();

$rules['header_comment']['header'] = trim('
This file is part of the ' . $package . ' package.

This source file is subject to the license that is
bundled with this source code in the LICENSE.md file.
');

$finder = Finder::create()
    ->in([__DIR__])
    ->append([__FILE__])
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true);

return (new Config('XpertSelect/PHP'))
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setRules($rules)
    ->setFinder($finder);
