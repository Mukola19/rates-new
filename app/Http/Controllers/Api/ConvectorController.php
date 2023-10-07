<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Currency;
use Illuminate\Http\Request;

class ConvectorController extends Controller
{

    /**
     *  Banks.
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function index(Request $request)
    {

        $banks = Bank::all();
        $currencies = Currency::all();

        // all banks 
        $banksAll = $banks->toArray();

        // get bank by id
        $bank = $banks->find($request->query('bank_id', 1));

        $groupsCurrencies = [];

        // creation of currency groups
        foreach ($currencies as $currency) {
            $rate = $bank->rates()
                ->where('currency_id', $currency->id)
                ->orderby('created_at', 'desc')
                ->first();

            $groupsCurrencies[$currency->code] = $rate;
        }


        $bank->currencies = $groupsCurrencies;



        return response()->json(['banks' => $banksAll, 'bank' => $bank, 'currencies' => $currencies]);
    }
}
