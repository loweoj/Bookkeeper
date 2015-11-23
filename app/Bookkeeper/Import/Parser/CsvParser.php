<?php  namespace Bookkeeper\Import\Parser;

use League\Csv\Reader;

class CsvParser implements ImportParserInterface {

    /**
     * Load data from file into PHP objects/arrays
     *
     * @param string $filepath
     * @return mixed
     */
    public function parse($filepath = '')
    {
        // Read in the csv file
        $csv = Reader::createFromPath($filepath);

        // Get header row and strip empty fields
        $csvHeaders = $this->stripEmpty($csv->fetchOne(0));
        $returnHeaders = $this->buildHeaders($csvHeaders);

        // Create associate array with headers and values
        $lines = $csv->setOffset(1)->fetchAssoc($csvHeaders);

        return ['headers' => $returnHeaders,
                'lines'   => $lines];
    }

    /**
     * @param array $array
     * @return array
     */
    public function stripEmpty(array $array)
    {
        foreach ($array as $key => $value) {
            if ($value == '') unset($array[$key]);
        }

        return $array;
    }

    private function buildHeaders($headers)
    {
        $return = [];
        foreach( $headers as $k => $h ) {
            $return[$k]['id'] = \Str::camel($h);
            $return[$k]['title'] = $h;
        }
        return $return;
    }
}