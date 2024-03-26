@extends('nav')
@section('title', 'Типи')
@section('content')

<h1 class="mt-4">{{$act=='add'?'Додати':'Змінити'}} виріб</h1>
<form action="/items/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">Назва</span>
        <input type="text" class="form-control" minlength=5 maxlength=70 required name="title" value="{{$edit->title??''}}" placeholder="Тканина...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Одиниця</span>
        <select class="search-drop" name="unit">
            @foreach($units as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->unit_id?'selected':''):''}}>{{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Оплата</span>
        <input type="number" class="form-control" max="9999" required name="price" value="{{$edit->price??''}}" placeholder="за зроблену одиницю">
    </div>
    <div class="input-group">
        <span class="input-group-text">Фото</span>
        <input type="url" class="form-control" maxlength=150 required name="photo" value="{{$edit->url_photo??''}}" placeholder="URL...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Має колір</span>
        <input type="checkbox" name="hascolor" {{isset($edit)?($edit->hascolor==1?'checked':''):''}}>
    </div>
    <div class="input-group">
        <span class="input-group-text">Опис</span>
        <input type="text" class="form-control" maxlength=200 name="description" value="{{$edit->description??''}}" placeholder="Розкрієчний...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Інструкція</span>
        <input type="url" class="form-control" maxlength=150 name="instruction" value="{{$edit->url_instruction??''}}" placeholder="URL...">
    </div>
    <div class="input-group" id="tagsSel">
        <span class="input-group-text">Складники</span>
        <select class="search-drop input-group-text" style="height:40px;" name="consist" onchange="addTag(this, 'tagsSel')">
            <option>-</option>
            @foreach($items as $item)
                <option value="{{$item->id}}">{{$item->title}}</option>
            @endforeach
        </select>
    </div>
    @if(isset($consists))
        @foreach($consists as $cons)
            @foreach($items as $item)
                @if($item->id == $cons->have_id)
                    <div id = "t{{$item->id}}" class="input-group mb-3">
                        <input name="consists[]" type="hidden" value="{{$item->id}}">
                        <input class="form-control success" value="{{$item->title}}"readonly>
                        <input type="number" max="999" required name="counts[]" class="form-control" step="0.01" value="{{$cons->count}}">
                        <button class="input-group-text text-danger" type="button" onclick="dellTag('t{{$item->id}}')">X</button>
                    </div>
                @endif
            @endforeach
        @endforeach
    @endif
    <button type="submit" class="btn btn-primary m-2">{{$act=='add'?'Додати':'Змінити'}}</button>
</form>
<script>
    window.addTag = function(sel, after_name){
        if(sel.value!='-')
            document.getElementById(after_name).insertAdjacentHTML("afterend",
            '<div id = "t'+sel.value+'" class="input-group mb-3">'
                +'<input name="consists[]" type="hidden" value="'+sel.value+'">'
                +'<input class="form-control success" value="'+sel.options[sel.selectedIndex].text+'"readonly>'
                +'<input type="number" max="999" required name="counts[]" class="form-control" step="0.01" value="1">'
                +'<button class="input-group-text text-danger" type="button" onclick="dellTag(`t'+sel.value+'`)">X</button>'
            +'</div>')
    }
    window.dellTag = function(name){ document.getElementById(name).remove(); }
</script>
@endsection