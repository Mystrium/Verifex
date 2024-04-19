@extends('nav')
@section('title', 'Сировина')
@section('content')

<h1 class="mt-4">Цех сировини</h1>
<form action="/purchases/materials/update" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">Цех</span>
        <select class="search-drop input-group-text" style="height:40px;" name="initceh" id="ceh_select" onchange="updateOptions(this.value);">
            @foreach($cehs as $tp)
                <option value="{{$tp->id}}" {{$tp->id==$save[0]?'selected':''}}>{{$tp->type}} {{$tp->title}}</option>
            @endforeach
        </select>
        <span class="input-group-text">Посада</span>
        <select class="search-drop input-group-text" style="width:200px" name="initworker" id="role_select">
            @foreach($workers as $tp)
                <option value="{{$tp->id}}" {{$tp->id==$save[1]?'selected':''}}>{{$tp->pib}} {{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary m-2">Змінити</button>
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