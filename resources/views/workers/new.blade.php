@extends('nav')
@section('title', 'Типи')
@section('content')

<h1 class="mt-4">{{$act=='add'?'Додати':'Змінити'}} робітника</h1>
<form action="/workers/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">ПІБ</span>
        <input type="text" class="form-control" maxlength=20 name="pib" value="{{$edit->pib??''}}" placeholder="Іваненко В...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Цех</span>
        <select class="search-drop input-group-text" style="height:40px;" name="ceh">
            @foreach($cehs as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->ceh_id?'selected':''):''}}>{{$tp->ctitle}} {{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Посада</span>
        <select class="search-drop input-group-text" style="height:40px;" name="role">
            @foreach($types as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->role_id?'selected':''):''}}>{{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Телефон</span>
        <input type="number" class="form-control" name="phone" value="{{$edit->phone??''}}" placeholder="+380...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Паспорт</span>
        <input type="text" class="form-control" name="passport" value="{{$edit->passport??''}}" placeholder="AR3245322">
    </div>
    <div class="input-group">
        <span class="input-group-text">{{$act=='add'?'П':'Новий п'}}ароль</span>
        <input type="text" class="form-control" name="password">
    </div>
    @if(isset($edit))
        <div class="input-group">
            <span class="input-group-text">Перевірений</span>
            <input type="checkbox" name="checked" {{$edit->checked==1?'checked':''}}>
        </div>
    @endif
    <button type="submit" class="btn btn-primary m-2">{{$act=='add'?'Додати':'Змінити'}} </button>
</form>
@endsection