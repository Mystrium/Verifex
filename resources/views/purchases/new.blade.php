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
        </div>
        <div class="col-md-auto">
            <span class="ps-1 pe-1">Не знайшли колір ?</span>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                Створити новий
            </button>

            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Додати колір</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="inputName" class="form-label">Назва</label>
                                    <input type="text" class="form-control" minlength=3 maxlength=20 required name="title" placeholder="Зелений...">
                                </div>
                                <div class="mb-3">
                                    <label for="inputDescription" class="form-label">Колір</label>
                                    <input type="color" class="form-control" style="height:50px" name="hex" value="#4dff00">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Зберегти зміни</button>
                        </div>
                    </div>
                </div>
            </div>

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
                <input type="checkbox" checked name="priceby"/>
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