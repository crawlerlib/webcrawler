#!/usr/bin/php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Crawler\Normalizer\CsvNormalizer;
use Crawler\Normalizer\Normalizer;

$csvNormalizer = new CsvNormalizer(new Normalizer());

$crawlerCommand = new \Crawler\Command\NormalizerCommand($csvNormalizer);

$application = new Application();
$application->add($crawlerCommand);
$application->setDefaultCommand($crawlerCommand->getName());

$application->run();
