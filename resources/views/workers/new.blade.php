@extends('navbar/main')
@section('title', 'Робітники')
@section('action', ($act=='add'?'Додати':'Змінити') . ' робітника')
@section('content')

<form action="/workers/{{$act}}/{{$edit->id??''}}" method="POST">
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
    </div>
    <div class="row pt-2 pb-3 my-2 mx-1 border rounded">
        <div class="col-md-auto">
            <span class="fw-bold">Цех</span><span class="text-danger"> *</span>
            <br>
            <select class="search-drop input-group-text" style="height:40px;" name="ceh" id="ceh_select" onchange="updateOptions(this.value);">
                @foreach($cehs as $tp)
                    <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->ceh_id?'selected':''):''}}>{{$tp->ctitle}} {{$tp->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto">
            <span class="fw-bold">Посада</span><span class="text-danger"> *</span>
            <br>
            <select class="search-drop input-group-text" style="width:200px" name="role" id="role_select">
                @foreach($types as $tp)
                    <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->role_id?'selected':''):''}}>{{$tp->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="md-auto mb-4">
        <span class="fw-bold">Паспорт</span><span class="text-danger"> *</span>
        <br>
        <input type="text" style="width:120px" class="form-control" name="passport" minlength=9 maxlength=9 required value="{{$edit->passport??''}}" placeholder="AR3245322">
    </div>
    @if(isset($edit))
        <div class="md-auto  mb-4">
            <span class="fw-bold">Статус</span>
            <label class="switch">
                <input type="checkbox" name="checked" {{$edit->checked==1?'checked':''}}>
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

<script>
    var optionsMap = @json($posistionmap)
    
    var secondDropdown = document.getElementById("role_select");

    updateOptions(document.getElementById("ceh_select").value);
    
    function updateOptions(selectedValue) {
        secondDropdown.innerHTML = "";

        optionsMap.forEach(function(option) {
            if (option.cehid == selectedValue) {
                var optionElement = document.createElement("option");
                optionElement.value = option.id;
                optionElement.text = option.title;
                secondDropdown.add(optionElement);
            }
        });
    }
</script>

@endsection