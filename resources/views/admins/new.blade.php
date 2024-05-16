@extends('navbar/main')
@section('title', 'Користувачі')
@section('action', ($act=='add'?'Додати':'Змінити') . ' користувача')
@section('content')

<form action="/admins/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">ПІБ</span><span class="text-danger"> *</span>
            <br>
            <input type="text" class="form-control" minlength=8 maxlength=70 required name="pib" value="{{$edit->pib??''}}" placeholder="Іваненко В...">
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Телефон</span><span class="text-danger"> *</span>
            <br>
            <input type="number" class="form-control" name="phone" min="100000000" max="380999999999" required value="{{$edit->phone??''}}" placeholder="+380...">
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Посада</span><span class="text-danger"> *</span>
            <br>
            <select class="search-drop input-group-text" style="width:200px" name="role" id="role_select" {{isset($edit)?(auth()->user()->id==$edit->id?'disabled':''):''}}>
                @foreach($roles as $role)
                    <option value="{{$role->id}}" {{isset($edit)?($role->id==$edit->role_id?'selected':''):''}}>{{$role->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if(isset($edit) && auth()->user()->id != $edit->id)
        <div class="md-auto  mb-4">
            <span class="fw-bold">Статус</span>
            <label class="switch">
                <input type="checkbox" name="allowed" {{$edit->allowed==1?'checked':''}}>
                <span class="slider round"></span>
            </label>
        </div>
    @endif
    <div class="md-auto  mb-4">
        <span class="fw-bold">{{$act=='add'?'П':'Новий п'}}ароль</span>
        <br>
        <input type="text" style="width:120px" class="form-control" minlength=4 maxlength=10 {{$act=='add'?'required':''}} name="password">
    </div>
    <button type="submit" class="btn btn-success m-2">{{$act=='add'?'Додати':'Змінити'}} </button>
</form>
@endsection