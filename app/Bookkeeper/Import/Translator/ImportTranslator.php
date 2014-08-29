<?php  namespace Bookkeeper\Import\Translator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportTranslator {

    /**
     * @var
     */
    private $transformer;

    /**
     * @var
     */
    private $extension;

    /**
     * @param UploadedFile $file
     * @return mixed
     */
    public function parseInputFile(UploadedFile $file)
    {
        // Get the file extension
        $ext = $file->getClientOriginalExtension();

        // Fetch the parser for this extension
        $parser = $this->fetchParser($ext);

        // Parse the file
        return $parser->parse($file->getRealPath());
    }

    /**
     * Return an array of Bank Accounts with transactions
     *
     * @param        $data
     * @param string $map CSV Data Map array
     * @return array
     */
    public function makeAccountsArray($data, $map = 'null')
    {

        $this->transformer = $this->fetchTransformer();

        $transformedData = $this->transformer->transform($data, $map);

        return $this->validateTransformedData($transformedData);
    }

    /**
     * Make sure any transformer implementation
     * returns the expected data.
     *
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function validateTransformedData($accountData)
    {
        foreach( $accountData as $data) {
            if ( ! isset($data['account-number'])
                or ! isset($data['sort-code'])
                or ! isset($data['transactions'])
                or ! isset($data['transactions'][0]['date'])
                or ! isset($data['transactions'][0]['payee'])
                or ! isset($data['transactions'][0]['amount'])
                or ! isset($data['transactions'][0]['type'])
                or ! isset($data['transactions'][0]['description'])
            ) {
                throw new \Exception(get_class($this->transformer) . '::transform() does not return expected array');
            }
        }

        return $accountData;
    }

    /**
     * @return mixed
     */
    public function getCurrentExtension()
    {
        return $this->extension;
    }

    protected function fetchParser($extension)
    {
        $this->extension = $extension;

        $namespace = 'Bookkeeper\\Import\\Parser\\';

        if ($extension == 'csv') {
            return \App::make($namespace . 'CsvParser');
        }

        return \App::make($namespace . 'OfxParser');
    }

    /**
     * @return mixed
     */
    protected function fetchTransformer()
    {
        $namespace = 'Bookkeeper\\Import\\Transformer\\';

        if ($this->extension == 'csv') {
            return \App::make($namespace . 'CsvTransformer');
        }

        return \App::make($namespace . 'OfxTransformer');
    }
}