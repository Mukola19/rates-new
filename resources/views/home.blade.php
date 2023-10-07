@extends('layouts.main')

@section('title', 'Rates')
@inject('carbon', 'Carbon\Carbon')


@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col"><small>Валюта</small></th>
                @foreach ($currenceis as $currency)
                    <th scope="col">{{ $currency->name }} {{ $currency->code }}</th>
                @endforeach
            </tr>

            <tr>
                <th scope="col">Обміники</th>
                @foreach ($currenceis as $currency)
                    <th scope="col">Покупка Продаж</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $bank)
                <tr>
                    <th scope="row">
                        <div>
                            <a href="{{ route('getBankById', $bank->id) }}"
                                class="text-decoration-none ">{{ $bank->display_name }}</a>
                            <small>Станом на
                                {{ $carbon->parse(array_values($bank->rates)[0]->created_at ?? '')->format('H:i') }}</small>
                        </div>
                    </th>

                    @foreach ($bank->rates as $rate)
                        @if ($rate)
                            <th scope="row">{{ $rate?->purchase }} {{ $rate?->sale }}
                            </th>
                        @else
                            <td>-</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
