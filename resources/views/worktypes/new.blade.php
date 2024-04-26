@extends('nav')
@section('title', 'Посади')
@section('action', ($act=='add'?'Додати':'Змінити') . ' посаду')
@section('content')

<form action="/worktypes/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">Посада</span>
        <input type="text" class="form-control" minlength=5 maxlength=40 required name="title" value="{{$edit->title??''}}" placeholder="Швея...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Тип цеху</span>
        <select class="search-drop input-group-text" name="type">
            @foreach($cehtypes as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->cehtype_id?'selected':''):''}}>{{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Мінімальна плата</span>
        <input type="number" class="form-control" maxlength=4 maxlength=7 name="minpay" required value="{{$edit->min_pay??''}}" placeholder="3000">
    </div>
    <div class="input-group" id="tagsSel">
        <span class="input-group-text">Доступні вироби</span>
        <select class="multiple-search input-group-text" id="itm" style="height:300px;" multiple="multiple" name="items[]">
            @foreach($items as $item)
                <option value="{{$item->id}}" {{ (isset($workitems) && in_array($item->id, $workitems)) ? 'selected' : '' }}>
                    {{$item->title}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="input-group" id="tagsSel1">
        <span class="input-group-text">Дозволи</span>
        <select class="multiple-search input-group-text" id="opr" style="height:300px;" multiple="multiple" name="operations[]">
            @foreach($permisions as $item)
                <option value="{{$item->id}}" {{ (isset($edit) && in_array($item->id, explode(',', $edit->operations))) ? 'selected' : '' }}>
                    {{$item->title}}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary m-2">{{$act=='add'?'Додати':'Змінити'}}</button>
</form>
<script>
    $("#itm").select2({placeholder: "Оберіть вироби"});
    $("#opr").select2({placeholder: "Оберіть дозволи"});
</script>
@endsection