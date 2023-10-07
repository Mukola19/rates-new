<?php

namespace App\Console\ParsersHtml;

use App\Models\Currency;
use App\Models\Rate;
use voku\helper\HtmlDomParser;



class ParserOschadbank
{
    static  public function index()
    {

        $dom = HtmlDomParser::file_get_html('https://www.oschadbank.ua/currency-rate');
        $elements = $dom->find('.heading-block-currency-rate__table-row');

        $rates = [];

        for ($i = 1; $i < 3; $i++) {
            $tdelements = $elements[$i]->find('.heading-block-currency-rate__table-col span');
            $code = $tdelements[1]->text();

            $purchase =  floatval($tdelements[3]->text());
            $sale =  floatval($tdelements[4]->text());

            $rates[] = [
                'code' => $code,
                'purchase' => $purchase,
                'sale' => $sale,
            ];
        }
        // saving to database
        foreach ($rates as $rate) {
            $currency =  Currency::where('code', $rate['code'])->first();
            $newRate = new Rate();
            $newRate->sale = $rate['sale'];
            $newRate->purchase = $rate['purchase'];
            $newRate->bank_id = 2;
            $newRate->currency_id = $currency->id;
            $newRate->save();
        }
    }
}
