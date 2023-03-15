<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\processXmlTrait;

class xmltoGoogleSheets extends Command
{
    use processXmlTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will import an XML file to Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Import XML file to Google Sheets');
        $input = $this->choice('Do you want to import from a local or remote file?', ['local', 'remote']);
        $filePath = "";
        if ($input === strtolower("local")) {

            $filePath = $this->ask('Enter the path to the local XML file');
            try{
                $xml = simplexml_load_file($filePath);
            }
            catch(\Exception $e){
                $this->error('Please provide a valid xml file path');
                return;
            }
            try{
                $data= $this->processXml($xml);
            }
            catch(\Exception $e){
                $this->error('Sorry, an error occurred while processing the XML file');
                return;
            }
            $this->info('XML file loaded successfully \n');
            $this->info('Sending data to Google Sheets\n');
            $this->appendtoSpreadsheet($data);
            $this->info('Data sent successfully to Google Sheets');

        } elseif ($input === strtolower("remote")) {
            $url = $this->ask('Enter the URL of the remote XML file');
            if(!filter_var($url, FILTER_VALIDATE_URL)){
                $this->error('Please provide a valid xml remote url');
                return;
            }
           try{
                $xmlString = file_get_contents($url);
            }
            catch(\Exception $e){
                $this->error('Sorry, an error occurred while loading the XML file');
                return;
           }
           try{
                $xml = simplexml_load_string($xmlString);
            }
            catch(\Exception $e){
                $this->error('Sorry, an error occurred while processing the XML file');
                return;
           }
            $data= $this->processXml($xml);
            $this->info('XML file loaded successfully');
            $this->info('Sending data to Google Sheets');
            $this->appendtoSpreadsheet($data);
            $this->info('Data sent successfully to Google Sheets');

        } else {
            $this->error('Invalid input, please try again');
            return;
        }
       
    }
}
