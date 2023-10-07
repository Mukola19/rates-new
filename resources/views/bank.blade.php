@extends('layouts.main') @section('title', 'Rates') @inject('carbon', 'Carbon\Carbon') @section('content')

<div class="bank-title">
    <div class="">
        <h2>Курс валют в {{ $bank->display_name }}</h2>
        <span>Cтаном на {{ $carbon->parse($currencieUpdatedBy)->format('H:i') }}</span>
    </div>
</div>

<div class="d-flex justify-content-between mt-3">
    {{-- table of rates --}}
    <div class="card" style="width: 44rem">


        <div class="p-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Валюта</th>
                        <th scope="col"> </th>
                        <th scope="col">Покупка </th>
                        <th scope="col"> Продаж</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($actualRates as $rate)
                        <tr>
                            @isset($rate)
                                <th scope="row">{{ $rate->currency->name }} </th>
                                <th scope="row">{{ $rate->currency->code }} </th>
                                <th scope="row">{{ $rate->purchase }} </th>
                                <th scope="row">{{ $rate->sale }}</th>
                            @endisset
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




    </div>
    {{-- rate history table --}}
    <div class="card" style="width: 44rem">
        <div class="p-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link @if ($ratesByDate['time_period'] === 'today') active @endif"
                        href="{{ route('getBankById', ['id' => $bank->id, 'time_period' => 'today']) }}">День</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($ratesByDate['time_period'] === 'week') active @endif"
                        href="{{ route('getBankById', ['id' => $bank->id, 'time_period' => 'week']) }}">Тиждень</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($ratesByDate['time_period'] === 'month') active @endif"
                        href="{{ route('getBankById', ['id' => $bank->id, 'time_period' => 'month']) }}">Місяць</a>
                </li>
                <li class="nav-item">
                    <h5 class="bank-tables-nav__title">
                        Динаміка курсів валют
                    </h5>
                </li>
            </ul>
            <div class="p-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            @foreach ($currencys as $currency)
                                <th scope="col">
                                    <div class="">
                                        <div class="">
                                            {{ $currency->name }} {{ $currency->code }}
                                        </div>
                                        <div class="mt-1" style="font-size: 13px">
                                            Покупка Продаж
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ratesByDate['rates'] as $dataTime => $rates)
                            <tr>
                                <th scope="row">
                                    @switch($ratesByDate['time_period'])
                                        @case('today')
                                            {{ $carbon->parse($dataTime)->format('H:i') }}
                                        @break

                                        @case('week' || 'month')
                                            {{ $carbon->parse($dataTime)->format('d.m') }}
                                        @break

                                        @default
                                    @endswitch
                                </th>

                                @foreach ($currencys as $currency)
                                    @if ($rates[$currency->code])
                                        <td style="font-size: 15px">
                                            {{ $rates[$currency->code]?->purchase }}
                                            {{ $rates[$currency->code]?->sale }}
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
