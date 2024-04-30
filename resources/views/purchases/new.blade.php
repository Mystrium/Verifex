@extends('navbar/main')
@section('title', 'Закуп')
@section('action', ($act=='add'?'Додати':'Змінити') . ' закуп')
@section('btnroute', '/purchases/materials')
@section('btntext', 'Змінити склад призначення')
@section('content')


<form action="/purchases/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">Одиниця</span><span class="text-danger"> *</span>
            <br>
            <select class="search-drop input-group-text" style="height:40px;" onchange="hasColor(this)" name="item">
                @foreach($items as $tp)
                    <option value="{{$tp->id}}|{{$tp->hascolor}}" {{isset($edit)?($tp->id==$edit->item_id?'selected':''):''}}>
                        {{$tp->title}} ({{$tp->unit}})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto" id="color_sel" {{isset($edit) ? (empty($edit->color_id) ? 'hidden' : '') :'' }}>
            <span class="fw-bold">Колір</span><span class="text-danger"> *</span>
            <br>
            <select class="search-drop input-group-text" style="height:40px;" name="color">
                @foreach($colors as $tp)
                    <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->color_id?'selected':''):''}}>
                        {{$tp->title}}
                    </option>
                @endforeach
            </select>
            <span class="ps-1 pe-1">Не знайшли колір ?</span><a href="/colors" target="_blank">Створіть новий</a>
        </div>
    </div>

    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">Кількість</span><span class="text-danger"> *</span>
            <br>
            <input type="number" style="width:130px" class="form-control" min="0.001" max=99999 required value="{{$edit->count??''}}" step="0.001" name="count">
        </div>
        <div class="col-md-auto text-center">
            <span class="fw-bold">Ціна</span>
            <br>
            <span class="fw-bold">одиниці</span>
            <label class="switch">
                <input type="checkbox" name="priceby"/>
                <span class="slider round"></span>
            </label>
            <span class="fw-bold">загальна</span>
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Ціна закупу</span><span class="text-danger"> *</span>
            <br>
            <div class="input-group">
                <select class="input-group-text" style="height:40px;" name="currency">
                    <option value="grn">₴</option>
                    <option value="usd">$</option>
                    <option value="eur">€</option>
                </select>
                <input type="number" style="width:130px" class="form-control" min="0.01" max=99999 required step="0.01" value="{{$edit->price??''}}" name="price">
            </div>
        </div>
    </div>
    <div class="row pt-2 pb-3 my-2 mx-1">
        <div class="col-md-auto">
            <span class="fw-bold">Дата</span>
            <br>
            <input type="date" class="form-control" value="{{date('Y-m-d', strtotime($edit->date ?? $nowdate))}}" required name="date">
        </div>
        </div>
    <button type="submit" class="btn btn-success m-2">{{$act=='add'?'Додати':'Змінити'}} </button>
</form>
<script>
    window.hasColor = function(sel){
        if(sel.options[sel.selectedIndex].value.split("|")[1] == 1)
            document.getElementById('color_sel').hidden = false;
        else
            document.getElementById('color_sel').hidden = true;
    }
</script>
@endsection