#!/usr/bin/php
<?php

require __DIR__.'/vendor/autoload.php';

use Crawler\Command\CrawlCommand;
use Crawler\Observer\CrawlObserver;
use Spatie\Crawler\Crawler;
use Symfony\Component\Console\Application;

$observer = new CrawlObserver();
$crawler = Crawler::create();

$crawlerCommand = new CrawlCommand($crawler, $observer);

$application = new Application();
$application->add($crawlerCommand);
$application->setDefaultCommand($crawlerCommand->getName());

$application->run();
