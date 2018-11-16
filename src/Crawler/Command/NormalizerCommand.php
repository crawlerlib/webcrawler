<?php

namespace Crawler\Command;

use Crawler\Normalizer\CsvNormalizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class NormalizerCommand
 */
class NormalizerCommand extends Command
{
    /**
     * @var CsvNormalizer
     */
    private $csvNormalizer;

    /**
     * NormalizerCommand constructor.
     * @param CsvNormalizer $csvNormalizer
     */
    public function __construct(CsvNormalizer $csvNormalizer, $name = null)
    {
        $this->csvNormalizer = $csvNormalizer;

        parent::__construct($name);
    }

    /**
     * Configures the crawling command
     */
    protected function configure()
    {
        $this
            ->setName('normalize')
            ->setDescription('Normalizes a CSV file')
            ->setHelp('Normalizes a CSV file')
            ->addArgument('file', InputArgument::REQUIRED, 'The file to normalize')
        ;
    }

    /**
     * Executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->csvNormalizer->normalizeCsv($input->getArgument('file'));
    }
}
