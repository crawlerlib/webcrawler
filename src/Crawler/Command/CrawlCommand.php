<?php

namespace Crawler\Command;

use Crawler\Model\UrlText;
use Crawler\Observer\CrawlObserver;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlInternalUrls;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CrawlCommand
 */
class CrawlCommand extends Command
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var CrawlObserver
     */
    private $observer;

    /**
     * CrawlCommand constructor.
     * @param Crawler $crawler
     * @param CrawlObserver $observer
     * @param null $name
     */
    public function __construct(Crawler $crawler, CrawlObserver $observer, $name = null)
    {
        $this->crawler = $crawler;
        $this->observer = $observer;

        $this->crawler->addCrawlObserver($observer);

        parent::__construct($name);
    }

    /**
     * Configures the crawling command
     */
    protected function configure()
    {
        $this
            ->setName('crawl')
            ->setDescription('Crawls a website and prints all its texts and their URL')
            ->setHelp('Outputs per line to be stored in a CSV')
            ->addArgument('urls', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The URLs to crawl')
        ;
    }

    /**
     * Executes the crawling command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($input->getArgument('urls') as $url) {
            $url = 'http://' . $url;

            $this->crawler->setCrawlProfile(new CrawlInternalUrls($url));
            $this->crawler->startCrawling($url);
        }

        $fp = fopen('php://temp', 'w+');
        $texts = $this->observer->getTexts();
        fputcsv($fp, $texts->getCSVHeader());

        foreach ($texts->toCSV() as $text) {
            fputcsv($fp, $text);
        }
        rewind($fp); // Set the pointer back to the start
        $csvContents = stream_get_contents($fp); // Fetch the contents of our CSV
        fclose($fp); // Close our pointer and free up memory and /tmp space

        $output->write($csvContents);
    }
}
