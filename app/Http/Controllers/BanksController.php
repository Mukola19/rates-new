<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BanksController extends Controller
{

    /**
     *  Shows all banks.
     *
     * @return \Illuminate\View\View
     */



    public function getAllBanks()
    {
        $banks = Bank::all();
        $currenceis = Currency::all();
        $viewBanks = [];

        foreach ($banks as $bank) {
            $viewRates = [];
            foreach ($currenceis as  $currency) {
                $rate = $bank->rates()
                    ->where('currency_id', $currency->id)
                    ->orderby('created_at', 'desc')
                    ->first();

                $viewRates[$currency->code] = $rate;
            }
            $bank->rates = $viewRates;
            $viewBanks[] = $bank;
        }

        return view('home', [
            'banks' => $viewBanks,
            'currenceis' => $currenceis
        ]);
    }


    /**
     *  Gives one bank per id and shows it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function getBankById(Request $request, $id)
    {

        $bank = Bank::find($id);
        $currencys = Currency::all();

        $ratesByDate = [];



        // selecting time_period 

        switch ($request->query('time_period')) {
            case 'today':
                global $ratesByDate;
                $ratesByDate = [
                    'time_period' => 'today',
                    'rates' => $this->getRatesByDateTime($bank,  Carbon::now()->subDay(), 'H')
                ];
                break;

            case 'week':
                global $ratesByDate;
                $ratesByDate = [
                    'time_period' => 'week',
                    'rates' => $this->getRatesByDateTime($bank,  Carbon::now()->subWeek(), 'd')
                ];
                break;

            case 'month':
                global $ratesByDate;
                $ratesByDate = [
                    'time_period' => 'month',
                    'rates' => $this->getRatesByDateTime($bank,  Carbon::now()->subMonth(), 'd')
                ];
                break;

            default:
                global $ratesByDate;
                $ratesByDate = [
                    'time_period' => 'today',
                    'rates' => $this->getRatesByDateTime($bank,  Carbon::now()->subDay(), 'H')
                ];
                break;
        }

        //  current rates for the bank
        $actualRates = $this->getRatesActual($bank);


        return view('bank', [
            'actualRates' => $actualRates,
            'bank' => $bank,
            'ratesByDate' => $ratesByDate,
            'currencys' => $currencys,
            'currencieUpdatedBy' => reset($actualRates)?->created_at
        ]);
    }


    public function getRatesByDateTime($bank, $time_limit, $time_format = 'H')
    {
        // $time_format = H | d

        // function to create a time group
        function createGroup($time_format)
        {
            return function ($date) use ($time_format) {
                return Carbon::parse($date->created_at)->format($time_format);
            };
        }

        $rates = $bank->rates();

        // get rates group by datatime
        $ratesGroup = $rates
            ->where('created_at', '>=', $time_limit)
            ->get()
            ->groupBy(createGroup($time_format));

        $currencys =  Currency::all();

        $ratesByDataTime = [];

        // obtaining one indicator in a group by datetime
        foreach ($ratesGroup as  $rateGroup) {
            $rateGroupOne = [];
            foreach ($currencys as  $currency) {
                $rate = null;

                // choosing a selection method
                switch ($time_format) {
                    case 'd':
                        $rate =  $rateGroup
                            ->where('currency_id', $currency->id)
                            ->last();
                        break;
                    case 'H':
                        $rate =  $rateGroup
                            ->where('currency_id', $currency->id)
                            ->first();
                        break;
                }

                // push $rate to $rateGroupOne by code
                $rateGroupOne[$currency->code] = $rate;
                if ($rate?->created_at->toDateTimeString()) {
                    $created_at = $rate?->created_at->toDateTimeString();
                }
            }
            // push $rateGroupOne to $ratesByDataTime by created_at
            $ratesByDataTime[$created_at] = $rateGroupOne;
        }

        // sort 
        ksort($ratesByDataTime);
        return $ratesByDataTime;
    }

    public function getRatesActual($bank)
    {
        $currencys =  Currency::all();
        $actualRates = [];
        // forms groups by currencys
        foreach ($currencys as $currency) {
            $rates = $bank->rates();
            $actualRates[$currency->code] = $rates
                ->where('currency_id', $currency->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }
        return $actualRates;
    }
}
