@extends('navbar/main')
@section('title', 'Рух')
@section('action', 'Переміщення')
@section('content')

<form action="/movement" method="GET" class="pb-3">
    <!-- <div class="col-1"> -->
        
        <div class="input-group">
            <h5>Період</h5>
        </div>
    <!-- </div> -->

    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div class="col-md-auto">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        {{--<div class="col">
            <button type="submit" class="btn btn-success btn-sm">Порахувати</button>
        </div>--}}
    </div>
</form>

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