@extends('navbar/main')
@section('title', 'Посади')
@section('action', ($act=='add'?'Додати':'Змінити') . ' посаду')
@section('content')

<form action="/worktypes/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">Посада</span><span class="text-danger"> *</span>
            <br>
            <input type="text" class="form-control" minlength=5 maxlength=40 required name="title" value="{{$edit->title??''}}" placeholder="Швея...">
        </div>
        <div class="col-md-auto">
            <div class="pb-2">
                <span class="fw-bold">Тип цеху</span><span class="text-danger"> *</span>
            </div>
            <select class="search-drop input-group-text" name="type">
                @foreach($cehtypes as $tp)
                    <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->cehtype_id?'selected':''):''}}>{{$tp->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Мінімальна плата</span><span class="text-danger"> *</span>
            <br>
            <input type="number" class="form-control" min="100" max="99999" step="0.01" name="minpay" required value="{{$edit->min_pay??''}}" placeholder="3000">
        </div>
    </div>
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col col-lg-3">
            <span class="fw-bold">Дозволи</span><span class="text-danger"> *</span>
            <br>
            <select class="multiple-search input-group-text w-100" id="opr" multiple="multiple" name="operations[]">
                @foreach($permisions as $item)
                    <option value="{{$item->id}}" {{ (isset($edit) && in_array($item->id, explode(',', $edit->operations))) ? 'selected' : '' }}>
                        {{$item->title}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <span class="fw-bold">Доступні вироби</span><span class="text-danger"> *</span>
            <br>
            <select class="multiple-search input-group-text w-100" id="itm" multiple="multiple" name="items[]">
                @foreach($items as $item)
                    <option value="{{$item->id}}" {{ (isset($workitems) && in_array($item->id, $workitems)) ? 'selected' : '' }}>
                        {{$item->title}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-success m-2">{{$act=='add'?'Додати':'Змінити'}}</button>
</form>
<script>
    $("#itm").select2({placeholder: "Оберіть вироби"});
    $("#opr").select2({placeholder: "Оберіть дозволи"});
</script>
@endsection