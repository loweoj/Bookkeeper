<?php  namespace Bookkeeper\Import\Translator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportTranslator {

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
     * @param string $map   CSV Data Map array
     * @return array
     */
    public function makeAccountsArray($data, $map = 'null')
    {
        $transformer = $this->fetchTransformer();

        return $transformer->transform($data, $map);
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
            return \App::make($namespace .'CsvParser');
        }
        return \App::make($namespace . 'OfxParser');
    }

    protected function fetchTransformer()
    {
        $namespace = 'Bookkeeper\\Import\\Transformer\\';

        if ($extension == 'csv') {
            return \App::make($namespace .'CsvTransformer');
        }
        return \App::make($namespace . 'OfxTransformer');

    }



} 