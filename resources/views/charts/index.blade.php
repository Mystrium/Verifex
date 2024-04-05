@extends('nav')
@section('title', 'Вироби')
@section('content')

<h1 class="mt-4">Вироби</h1>
<form method="POST" action="{{ url('chart/worktime') }}" style="display:inline">
    @csrf
    <div class="row">
        <div class="col-1">
            <div class="input-group">
                <h5>Період</h5>
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$dates[0]??''}}">
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$dates[1]??''}}">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-sm">Знайти</button>
</form>

<div class="card chart-container">
    <canvas id="hourschart"></canvas>
</div>
{{var_dump($data)}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script>
    const ctx2 = document.getElementById("hourschart").getContext('2d');
    let rand_colors = [];
    for (let i = 0; i < {{ count($data['label']) }}; i++)
        rand_colors[i] = "hsl(" + 360 / {{ count($data['label']) }} * i +", 100%, 50%)";
    const myChart3 = new Chart(ctx2, {
        type: 'pie', data: {
            labels: @json($data['label']),
            datasets: [{
                label: 'c' ,
                data: @json($data['time']) ,
                backgroundColor: rand_colors,
            }]
        },
    });
</script>
@endsection