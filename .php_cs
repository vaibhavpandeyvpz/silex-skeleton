<?php

$header = <<<EOF
This file is part of vaibhavpandeyvpz/silex-skeleton package.

(c) Vaibhav Pandey <contact@vaibhavpandey.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.md.
EOF;

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\FixerInterface;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;

HeaderCommentFixer::setHeader($header);

return Config::create()
    ->finder(
        DefaultFinder::create()
            ->exclude('app/assets')
            ->exclude('app/storage')
            ->exclude('bower_components')
            ->exclude('node_modules')
            ->exclude('vendor')
            ->in(__DIR__)
    )
    ->fixers(array(
        'header_comment',
        'short_array_syntax'
    ))
    ->level(FixerInterface::PSR2_LEVEL)
    ->setUsingCache(true);
