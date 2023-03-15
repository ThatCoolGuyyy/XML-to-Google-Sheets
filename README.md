# XML to Google Sheets

This console command imports an XML file to Google Sheets using the Google Sheets API. It allows users to choose whether to import from a local or remote file, and handles errors that may occur during the process.

## Installation

1. Clone the repository
2. Install dependencies with `composer install`
3. Follow [these instructions](https://developers.google.com/sheets/api/quickstart/php) to enable the Google Sheets API and download the `credentials.json` file.
4. Save the `credentials.json` file in the root directory of the project.

## Usage

To run the command, use the following command in your terminal:
```
php artisan run:xml
```
The command will ask you whether you want to import from a local or remote file. If you choose "local", you will need to provide the path to the XML file on your local machine. If you choose "remote", you will need to provide the URL to the XML file.

The command will then process the XML file and send the data to Google Sheets. If any errors occur, the command will display a message indicating the nature of the error.


