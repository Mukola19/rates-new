<?php

namespace App\Console\ParsersHtml;

use App\Models\Currency;
use App\Models\Rate;
use voku\helper\HtmlDomParser;



class ParserBalance
{

    static  public function index()
    {

        $dom = HtmlDomParser::file_get_html('https://balance.lutsk.ua/');
        $elements = $dom->find('.w0[data-key]');

        $rates = [];

        for ($i = 0; $i < 2; $i++) {

            $tdelements = $elements[$i];
            $code = $tdelements->getElementByClass('title')[0]->text();

            $purchase = $tdelements->find('.w0')[2]->text();
            $purchase = floatval($purchase);

            $sale = $tdelements->find('.w0')[3]->text();
            $sale = floatval($sale);


            $rates[] = [
                'code' => $code,
                'purchase' => $purchase,
                'sale' => $sale,
            ];
        }

        foreach ($rates as $rate) {
            $currency =  Currency::where('code', $rate['code'])->first();
            if (!$currency) return;
            $newRate = new Rate();
            $newRate->sale = $rate['sale'];
            $newRate->purchase = $rate['purchase'];
            $newRate->bank_id = 3;
            $newRate->currency_id = $currency->id;
            $newRate->save();
        }
    }
}
