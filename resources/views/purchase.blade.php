@extends('nav')
@section('title', 'Закуп')
@section('content')

<h1 class="mt-4">Закупка матеріалів</h1>
<form action="{{ url('/purchases/add') }}" method="POST">
    @csrf
    <div class="input-group">
        <div class="input-group">
            <span class="input-group-text">Одиниця</span>
            <select class="search-drop input-group-text" style="height:40px;" onchange="hasColor(this)" name="item">
                @foreach($items as $tp)
                    <option value="{{$tp->id}}|{{$tp->hascolor}}">{{$tp->title}} ({{$tp->unit}})</option>
                @endforeach
            </select>
            <div>
                <div class="input-group" id="color_sel">
                    <span class="input-group-text">Колір</span>
                    <select class="search-drop input-group-text" style="height:40px;" name="color">
                        @foreach($colors as $tp)
                        <option value="{{$tp->id}}">{{$tp->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-text">Кількість</span>
            <input type="number" class="form-control" min="0.001" max=10000 required step="0.001" name="count">
        </div>
        <div class="input-group">
            <span class="input-group-text">Ціна закупу</span>
            <input type="number"  class="form-control" min="0.01" max=10000 required step="0.01" name="price" placeholder="за одиницю">
        </div>
        <div class="input-group">
            <span class="input-group-text">Дата</span>
            <input type="date" class="form-control" value="{{$nowdate}}" required name="date">
        </div>
    </div>
    <button type="submit" class="btn btn-primary m-2">Додати</button>
</form>
<table class="table table-striped table-success" id="jsTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва</th>
            <th scope="col">Колір</th>
            <th scope="col">Кількість</th>
            <th scope="col">Одиниця</th>
            <th scope="col">Ціна $</th>
            <th scope="col">Вартість $</th>
            <th scope="col">Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$purchase->title}}</td>
                <td><div style="background-color:#{{$purchase->hex}};">{{$purchase->ctitle}}</div></td>
                <td>{{$purchase->count}}</td>
                <td>{{$purchase->unit}}</td>
                <td>{{$purchase->price}}</td>
                <td>{{$purchase->count * $purchase->price}}</td>
                <td>{{substr($purchase->date, 0, 10)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    window.hasColor = function(sel){
        if(sel.options[sel.selectedIndex].value.split("|")[1] == 1)
            document.getElementById('color_sel').hidden = false;
        else
            document.getElementById('color_sel').hidden = true;
    }
</script>
@endsection


