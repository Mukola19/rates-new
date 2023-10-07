<?php

namespace App\Console\ParsersHtml;

use App\Models\Currency;
use App\Models\Rate;
use voku\helper\HtmlDomParser;



class ParserPrivatbank
{
    static  public function index()
    {
        $dom = HtmlDomParser::file_get_html('https://privatbank.ua/rates-archive');
        $elements = $dom->findMulti('.courses-currencies .currency-pairs');

        $rates = [];

        for ($i = 0; $i < 2; $i++) {
            $element =  $elements[$i];
            $name = $element->findOne('.names span')->text();
            $name = preg_replace("/[^a-zA-Z0-9]+/", "", $name);
            $name =  substr($name, 0, 3);

            $purchase =  $element->findOne('.purchase')->text();
            $sale  = $element->findOne('.sale')->text();
            $rates[] = [
                'code' => $name,
                'purchase' => $purchase,
                'sale' => $sale,
            ];
        }

        // saving to database
        foreach ($rates as $rate) {
            $currency =  Currency::where('code', $rate['code'])->first();
            if (!$currency) return;
            $newRate = new Rate();
            $newRate->sale = $rate['sale'];
            $newRate->purchase = $rate['purchase'];
            $newRate->bank_id = 1;
            $newRate->currency_id = $currency->id;
            $newRate->save();
        }
    }
}
