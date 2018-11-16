<?php

namespace Crawler\Normalizer;

/**
 * Class CsvNormalizer
 */
class CsvNormalizer
{
    /**
     * @var Normalizer A normalizer
     */
    private $normalizer;

    /**
     * CsvNormalizer constructor.
     * @param Normalizer $normalizer
     */
    public function __construct(Normalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * Normalizes a whole CSV file
     *
     * @param $fileName
     */
    public function normalizeCsv($fileName)
    {
        $handle = fopen($fileName, 'r+');

        $output = array();

        if ($handle) {
            while (($buffer = fgetcsv($handle, 4096)) !== false) {
                $output = array_merge($output, $this->normalizer->normalize($buffer));
            }

            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }

            fclose($handle);
        }

        foreach ($output as $outputLine) {
            echo $outputLine . "\n";
        }
    }
}
