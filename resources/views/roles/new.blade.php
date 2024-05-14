@extends('navbar/main')
@section('title', 'Ролі')
@section('action', ($act=='add'?'Додати':'Змінити') . ' роль')
@section('content')

<form action="/roles/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">Назва</span><span class="text-danger"> *</span>
            <br>
            <input type="text" class="form-control" minlength=4 maxlength=15 required name="title" value="{{$edit->title??''}}" placeholder="Бухгалтер...">
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Пріоритет</span><span class="text-danger"> *</span>
            <br>
            <input type="number" class="form-control" min="0" max="250" name="priority" required value="{{$edit->priority??''}}">
        </div>
        <div class="col">
            <span class="fw-bold">Дозволи</span><span class="text-danger"> *</span>
            <br>
            <select class="multiple-search input-group-text w-100" id="acc" multiple="multiple" name="accesses[]">
                @foreach($accesses as $access)
                    <option value="{{$access->id}}" {{ (isset($roleaccesses) && in_array($access->id, $roleaccesses)) ? 'selected' : '' }}>
                        {{$access->title}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-success m-2">{{$act=='add'?'Додати':'Змінити'}}</button>
</form>
<script>
    $("#acc").select2({placeholder: "Оберіть дозволи"});
</script>
@endsection