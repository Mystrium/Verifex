@extends('nav')
@section('title', 'Закуп')
@section('action', ($act=='add'?'Додати':'Змінити') . ' закуп')
@section('content')

<form action="/purchases/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="input-group">
        <div class="input-group">
            <span class="input-group-text">Одиниця</span>
            <select class="search-drop input-group-text" style="height:40px;" onchange="hasColor(this)" name="item">
                @foreach($items as $tp)
                    <option value="{{$tp->id}}|{{$tp->hascolor}}" {{isset($edit)?($tp->id==$edit->item_id?'selected':''):''}}>
                        {{$tp->title}} ({{$tp->unit}})
                    </option>
                @endforeach
            </select>
            <div>
                <div class="input-group" id="color_sel" {{isset($edit) ? (empty($edit->color_id) ? 'hidden' : '') :'' }}>
                    <span class="input-group-text">Колір</span>
                    <select class="search-drop input-group-text" style="height:40px;" name="color">
                        @foreach($colors as $tp)
                            <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->color_id?'selected':''):''}}>
                                {{$tp->title}}
                            </option>
                        @endforeach
                    </select>
                    <p class="ps-1 pe-1">Не знайшли колір ?</p><a href="/colors" target="_blank">Створіть новий</a>
                </div>
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-text">Кількість</span>
            <input type="number" class="form-control" min="0.001" max=10000 required value="{{$edit->count??''}}" step="0.001" name="count">
        </div>
        <div class="input-group">
            <span class="input-group-text">Ціна закупу</span>
            <select class="input-group-text" style="height:40px;" name="currency">
                <option value="grn">₴</option>
                <option value="usd">$</option>
                <option value="eur">€</option>
            </select>
            <input type="number" class="form-control" min="0.01" max=10000 required step="0.01" value="{{$edit->price??''}}" name="price" placeholder="за одиницю">
        </div>
        <div class="input-group">
            <span class="input-group-text">Дата</span>
            <input type="date" class="form-control" value="{{date('Y-m-d', strtotime($edit->date??$nowdate))}}" required name="date">
        </div>
    </div>
    <button type="submit" class="btn btn-primary m-2">{{$act=='add'?'Додати':'Змінити'}} </button>
</form>
<a href="/purchases/materials" class="btn btn-warning m-2">Змінити склад призначення</a>
<script>
    window.hasColor = function(sel){
        if(sel.options[sel.selectedIndex].value.split("|")[1] == 1)
            document.getElementById('color_sel').hidden = false;
        else
            document.getElementById('color_sel').hidden = true;
    }
</script>
@endsection