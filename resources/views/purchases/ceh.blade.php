@extends('navbar/main')
@section('title', 'Сировина')
@section('action', 'Цех сировини')
@section('content')

<form action="/purchases/materials/update" method="POST">
    @csrf
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-end; flex-wrap: wrap" class="pb-3">
        <div class="pe-2">
            <span class="fw-bold">Цех</span>
            <br>
            <select class="search-drop input-group-text" style="height:40px;" name="initceh" id="ceh_select" onchange="updateOptions(this.value);">
                @foreach($cehs as $tp)
                    <option value="{{$tp->id}}" {{isset($save[0])?($tp->id==$save[0]?'selected':''):''}}>{{$tp->type}} {{$tp->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="pe-2">
            <span class="fw-bold">Посада</span>
            <br>
            <select class="search-drop input-group-text" style="width:200px" name="initworker" id="role_select">
                @foreach($workers as $tp)
                    <option value="{{$tp->id}}" {{isset($save[1])?($tp->id==$save[1]?'selected':''):''}}>{{$tp->pib}} {{$tp->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="pt-1">
            <button type="submit" class="btn btn-warning">Змінити</button>
        </div>
    </div>
</form>

<script>
    var optionsMap = @json($workers)
    
    var secondDropdown = document.getElementById("role_select");

    updateOptions(document.getElementById("ceh_select").value);
    
    function updateOptions(selectedValue) {
        secondDropdown.innerHTML = "";

        optionsMap.forEach(function(option) {
            if (option.ceh_id == selectedValue) {
                var optionElement = document.createElement("option");
                optionElement.value = option.id;
                optionElement.text = option.pib + " " + option.title;
                secondDropdown.add(optionElement);
            }
        });
    }
</script>

@endsection