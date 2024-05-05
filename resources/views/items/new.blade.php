@extends('navbar/main')
@section('title', 'Вироби')
@section('action', ($act=='add'?'Додати':'Змінити') . ' виріб')
@section('content')

<form action="/items/{{$act}}/{{$edit->id??''}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col">
            <div class="row pt-2 pb-3 mb-2 mx-1 border rounded">
                <div class="col">
                    <span class="fw-bold">Назва</span><span class="text-danger"> *</span>
                    <input type="text" class="form-control" minlength=4 maxlength=70 required name="title" value="{{$edit->title??''}}" placeholder="Тканина...">
                </div>
                <div class="col-md-auto">
                    <span class="fw-bold">Категорія</span><span class="text-danger"> *</span>
                    <br>
                    <select class="search-drop" name="category">
                        <option value="">-</option>
                        @foreach($categoryes as $tp)
                            <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->category_id?'selected':''):''}}>{{$tp->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row pt-2 pb-3 mb-2 mx-1 border rounded">
                <div class="col-md-auto">
                    <span class="fw-bold">Має колір</span>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="hascolor" {{isset($edit)?($edit->hascolor==1?'checked':''):''}}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="col-md-auto">
                    <span class="fw-bold">Одиниця</span><span class="text-danger"> *</span>
                    <br>
                    <select class="search-drop" name="unit">
                        @foreach($units as $tp)
                            <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->unit_id?'selected':''):''}}>{{$tp->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col" id="payment" {{isset($edit->price) ? ($edit->price == 0 ? 'hidden' : '') : 'hidden'}}>
                    <span class="fw-bold">Оплата</span>
                    <br>
                    <input type="number" style="width:140px" class="form-control" max="9999" step="0.01" name="price" value="{{$edit->price??''}}" placeholder="за одиницю">
                </div>
            </div>

            <div class="row pt-2 pb-3 mb-2 mx-1 border rounded">
                <div class="col">
                    <span class="fw-bold">Опис</span>
                    <br>
                    <input type="text" class="form-control" maxlength=200 name="description" value="{{$edit->description??''}}" placeholder="Розкрієчний...">
                </div>
                <div class="col">
                    <span class="fw-bold">Інструкція</span>
                    <br>
                    <input type="url" class="form-control" maxlength=150 name="instruction" value="{{$edit->url_instruction??''}}" placeholder="URL...">
                </div>
            </div>
        </div>
        <div class="col-4">
            <span class="fw-bold">Фото</span><span class="text-danger"> *</span>
            <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
                <div class="col-auto">
                    <span class="fw-bold">Завантажити</span><span class="text-danger"></span>
                    <br>
                    <label class="switch">
                        <input type="checkbox" onchange="photoupload(this)">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col">
                    <span id="uploadtext" class="fw-bold">Посилання</span>
                    <br>
                    <input id="image" type="url" class="form-control" maxlength=150 required name="image" value="{{$edit->url_photo??''}}" placeholder="URL...">
                </div>
            </div>
            @if(isset($edit->url_photo))
                <div class="text-center">
                    <img src="{{$edit->url_photo}}" style="max-width:200px; max-height:200px">
                </div>
            @endif
        </div>
    </div>

    <span class="fw-bold">Тех. карта</span>
    <table class="table table-striped table-success">
        <thead>
            <tr>
                <th scope="col">Складник</th>
                <th scope="col">Кількість</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id='consist_table'>
            @foreach(isset($consists)?$consists:[] as $cons)
                @foreach($items as $item)
                    @if($item->id == $cons->have_id)
                        <tr id="t{{$item->id}}">
                            <td>
                                <input name="consists[]" type="hidden" value="{{$item->id}}">
                                <a href="/items/edit/{{$item->id}}" style="text-decoration:none" class="pe-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                </a>
                                {{$item->title}}
                            </td>
                            <td style="display: flex">
                                <input style="width:110px; margin-right:10px" type="number" max="999" required name="counts[]" class="form-control" step="0.001" value="{{$cons->count + 0}}">
                                @foreach($units as $unit)
                                    @if($unit->id == $item->unit_id)
                                        {{$unit->title}}
                                        @break
                                    @endif
                                @endforeach
                            </td>
                            <td><button class="input-group-text text-danger" type="button" onclick="dellTag('t{{$item->id}}')">X</button></td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr>
                <td>Додати
                    <select class="search-drop input-group-text" style="height:40px;" name="consist" onchange="addTag(this, 'consist_table')">
                        <option>-</option>
                        @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-success">{{$act=='add'?'Додати':'Змінити'}}</button>
</form>

<script>
    var units = @json($units);
    var items = @json($items);
    
    window.addTag = function(sel, after_name){
        if(sel.value != '-') {
            var unit = '';
            items.forEach((itm) => {
                if(itm.id == sel.value){
                    units.forEach((unt) => {
                        if(itm.unit_id == unt.id){
                            unit = unt.title;
                        }
                    });
                }
            });

            var table = document.getElementById(after_name);
            var newRow = table.insertRow(table.rows.length - 1);
            newRow.id = 't' + sel.value;
            newRow.innerHTML = 
                '<td>'
                    +'<input name="consists[]" type="hidden" value="'+sel.value+'">'
                    +'<a href="/items/edit/' + sel.value + '" style="text-decoration:none" class="pe-1">'
                        +'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">'
                            +'<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>'
                            +'<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>'
                        +'</svg>'
                    +'</a>'
                    + sel.options[sel.selectedIndex].text
                +'</td>'
                +'<td style="display: flex">'
                    +'<input type="number" style="width:110px; margin-right:10px" max="999" required name="counts[]" class="form-control" step="0.001" value="1">'
                    + unit
                +'</td>'
                +'<td><button class="input-group-text text-danger" type="button" onclick="dellTag(`t'+sel.value+'`)">X</button></td>';
        }
        sel.selectedIndex = 0;
        
        document.getElementById('payment').hidden = false;
    }

    window.dellTag = function(name){ 
        document.getElementById(name).remove();
        console.log(document.getElementById('consist_table').rows.length)
        if(document.getElementById('consist_table').rows.length == 1)
            document.getElementById('payment').hidden = true;
    }

    window.photoupload = function(check){
        if(check.checked){
            document.getElementById('image').type = "file";
            document.getElementById('uploadtext').innerHTML='Фото';
        } else {
            document.getElementById('image').type = "url";
            document.getElementById('uploadtext').innerHTML='Посилання';
        }
    }
</script>
@endsection