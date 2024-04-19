@extends('nav')
@section('title', 'Рух')
@section('content')

<h1 class="mt-4">Переміщення</h1>

<table class="table table-striped table-success">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">звідки</th>
            <th scope="col">Хто</th>
            <th scope="col">Кому</th>
            <th scope="col">Куди</th>
            <th scope="col">Кількість</th>
            <th scope="col">Виріб</th>
            <th scope="col">Колір</th>
            <th scope="col">Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($moves as $move)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$move->cehtype}} {{$move->ceh_title}}</td>
                <td>{{$move->worker}} {{$move->pib}}</td>
                <td>{{$move->worker_to_id}} {{$move->to_pib}}</td>
                <td>{{$move->cehtypeto}} {{$move->cehto_title}}</td>
                <td>{{$move->count + 0}}</td>
                <td>{{$move->title}}</td>
                <td><div style="background-color:#{{$move->hex}};">{{$move->color}}</div></td>
                <td>{{$move->date}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection