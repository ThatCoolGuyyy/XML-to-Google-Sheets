<?php

namespace App\Traits;

// use Google\Client;
// use Google\Service\Sheets;
use App\Jobs\xmltospreadsheet;
use Revolution\Google\Sheets\Facades\Sheets;



trait processXmlTrait
{
    public function processXml($xml)
    {
        $data = [];
        foreach ($xml->item as $item) {
            $entity_id = (string)$item->entity_id;
            $category = (string)$item->CategoryName;
            $sku = (string)$item->sku;
            $name = (string)$item->name;
            $description = (string)$item->description;
            $shortdesc = (string)$item->shortdesc;
            $price = (float)$item->price;
            $link = (string)$item->link;
            $image = (string)$item->image;
            $brand = (string)$item->Brand;
            $rating = (int)$item->Rating;
            $caffeine_type = (string)$item->CaffeineType;
            $count = (int)$item->Count;
            $flavored = (bool)$item->Flavored;
            $seasonal = (bool)$item->Seasonal;
            $instock = (bool)$item->Instock;
            $facebook = (bool)$item->Facebook;
            $is_kcup = (bool)$item->IsKCup;

            $data[] = [
                'entity_id' => $entity_id,
                'category' => $category,
                'sku' => $sku,
                'name' => $name,
                'description' => $description,
                'shortdesc' => $shortdesc,
                'price' => $price,
                'link' => $link,
                'image' => $image,
                'brand' => $brand,
                'rating' => $rating,
                'caffeine_type' => $caffeine_type,
                'count' => $count,
                'flavored' => $flavored,
                'seasonal' => $seasonal,
                'instock' => $instock,
                'facebook' => $facebook,
                'is_kcup' => $is_kcup,
            ];

        }
        return $data;
    }


    public function appendtoSpreadsheet($data)
        {
            $chunkSize = 1000; // set the size of each chunk
            $chunks = array_chunk($data, $chunkSize);

            foreach ($chunks as $chunk) {
                dispatch(new xmltospreadsheet($chunk))->onQueue('spreadsheet');
            
        }
    }
}