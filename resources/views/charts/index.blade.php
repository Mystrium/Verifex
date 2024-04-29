@extends('navbar/main')
@section('title', 'Вироби')
@section('content')

<h1 class="mt-4">Вироби</h1>
<form method="GET" action="{{ url('worktime') }}" style="display:inline">
    <div class="row">
        <div class="col-1">
            <div class="input-group">
                <h5>Період</h5>
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}">
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-sm">Знайти</button>
</form>

<div class="card chart-container">
    <canvas id="hourschart"></canvas>
</div>
{{--
{{json_encode($data,JSON_PRETTY_PRINT )}}
<br>
{"datasets":[{"data":[{"x":1625443200,"y":11.74},{"x":1626048,"y":12.43},{"x":1626652800,"y":34.18}],"label":"Hike","hidden":true},{"data":[{"x":1624233600,"y":5.27},{"x":1630281600,"y":7.32}],"label":"Kayaking","hidden":true}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script>
    const ctx2 = document.getElementById("hourschart").getContext('2d');
    let rand_colors = [];
    for (let i = 0; i < {{ count($data[0]) }}; i++)
        rand_colors[i] = "hsl(" + 360 / {{ count($data[0]) }} * i +", 100%, 50%)";
    const myChart3 = new Chart(ctx2, {
        type: 'line', 
        data: {
            labels: @json($data['label']),
            datasets: [{
                label: 'c' ,
                data: @json($data['time']) ,
                backgroundColor: rand_colors,
            }]
        },
    });
</script>--}}
@endsection