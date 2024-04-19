@extends('nav')
@section('title', 'ЗП')
@section('content')

<h1 class="mt-4">Заробітня плата {{$worker->pib}} {{empty(Request()->period) ? 'за минулий місяць' : ''}}</h1>
<table class="table table-success">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Виріб</th>
            <th scope="col">Оплата</th>
            <th scope="col">Кількість</th>
            <th scope="col">Всього</th>
            <th scope="col">Дата</th>
        </tr>
    </thead>
    <tbody>
        @php($summ = 0)
        @foreach($pays as $pay)
            @if($pay->count > 0)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$pay->title}}</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <div class="text-start">{{$pay->price + 0}}₴</div>
                            <div class="text-end pe-5">x</div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <div class="text-start">{{$pay->count}}</div>
                            <div class="text-end pe-5">=</div>
                        </div>
                    </td>
                    <td>{{$pay->count * $pay->price}}₴</td>
                    <td>{{$pay->date}}</td>
                </tr>
                @php($summ += $pay->count * $pay->price)
            @else
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="bg-danger">{{$pay->title}}</td>
                    <td class="bg-danger">{{-$pay->price + 0}}₴</td>
                    <td class="bg-danger">{{$pay->count}}</td>
                    <td class="bg-danger">{{-$pay->count * $pay->price}}₴</td>
                    <td>{{$pay->date}}</td>
                </tr>
                @php($summ = $pay->count * $pay->price)
            @endif
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Підсумок</td>
            <td>{{$summ}}₴</td>
            <td></td>
        </tr>
    </tbody>
</table>
@endsection