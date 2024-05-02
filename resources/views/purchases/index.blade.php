@extends('navbar/main')
@section('title', 'Закуп')
@section('action', 'Закупка матеріалів')
@section('btntext', 'Закупити')
@section('btnroute', 'purchases/new')
@section('content')

<table class="table table-striped table-success" name="jsTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва</th>
            <th scope="col">Колір</th>
            <th scope="col">Кількість</th>
            <th scope="col">Одиниця</th>
            <th scope="col">Ціна одиниці ₴</th>
            <th scope="col">Вартість ₴</th>
            <th scope="col">Дата</th>
            <th scope="col">Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$purchase->title}}</td>
                <td>
                    <div style="background-color:#{{$purchase->hex}};">
                        <span style="mix-blend-mode: difference; color:white">
                            {{$purchase->ctitle}}
                        </span>
                    </div>
                </td>
                <td>{{$purchase->count + 0}}</td>
                <td>{{$purchase->unit}}</td>
                <td>{{round($purchase->price / $purchase->count, 4)}}</td>
                <td>{{$purchase->price + 0}}</td>
                <td>{{substr($purchase->date, 0, 10)}}</td>
                <td>
                    <a href="/purchases/edit/{{$purchase->id}}" class="btn btn-warning btn-sm m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="/purchases/arhivate" class="btn btn-danger ms-3">Архівувати</a>

@endsection


