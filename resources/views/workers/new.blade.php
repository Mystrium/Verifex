@extends('nav')
@section('title', 'Робітники')
@section('content')

<h1 class="mt-4">{{$act=='add'?'Додати':'Змінити'}} робітника</h1>
<form action="/workers/{{$act}}/{{$edit->id??''}}" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">ПІБ</span>
        <input type="text" class="form-control" minlength=8 maxlength=70 required name="pib" value="{{$edit->pib??''}}" placeholder="Іваненко В...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Цех</span>
        <select class="search-drop input-group-text" style="height:40px;" name="ceh" id="ceh_select" onchange="updateOptions(this.value);">
            @foreach($cehs as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->ceh_id?'selected':''):''}}>{{$tp->ctitle}} {{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Посада</span>
        <select class="search-drop input-group-text" style="width:200px" name="role" id="role_select">
            @foreach($types as $tp)
                <option value="{{$tp->id}}" {{isset($edit)?($tp->id==$edit->role_id?'selected':''):''}}>{{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Телефон</span>
        <input type="number" class="form-control" name="phone" min="100000000" max="380999999999" required value="{{$edit->phone??''}}" placeholder="+380...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Паспорт</span>
        <input type="text" class="form-control" name="passport" minlength=9 maxlength=9 required value="{{$edit->passport??''}}" placeholder="AR3245322">
    </div>
    <div class="input-group">
        <span class="input-group-text">{{$act=='add'?'П':'Новий п'}}ароль</span>
        <input type="text" class="form-control" minlength=4 maxlength=8 {{$act=='add'?'required':''}} name="password">
    </div>
    @if(isset($edit))
        <div class="input-group">
            <span class="input-group-text">Перевірений</span>
            <input type="checkbox" name="checked" {{$edit->checked==1?'checked':''}}>
        </div>
    @endif
    <button type="submit" class="btn btn-primary m-2">{{$act=='add'?'Додати':'Змінити'}} </button>
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