@extends('navbar/main')
@section('title', $pagetitle)
@section('content')

<form method="GET" action="/charts/{{$route}}" style="display:inline">
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-end; flex-wrap: wrap" class="pb-3">
        <div class="pe-2">
            <h5>Період</h5>
        </div>
        <div class="pe-2">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div class="pt-1">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
    </div>
</form>

@if(isset($data['val']))
    <div class="card chart-container w-25">
        <canvas id="chart"></canvas>
    </div>
@else
    <p>Немає що показувати за цей період</p>
@endif

{{--<pre>{{jso_encode($test, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)}}</pre>--}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script>
    const ctx2 = document.getElementById("chart").getContext('2d');
    let colors = [];
    for (let i = 0; i < {{ count($data['val']??[]) }}; i++)
        colors[i] = "hsl(" + 360 / {{ count($data['val']??[]) }} * i +", 80%, 50%)";

    new Chart(ctx2, {
        type: @json($chart),
        data: {
            labels: @json($data['label']??[]),
            datasets: [{
                backgroundColor: colors,
                data: @json($data['val']??[])
            }]
        }
    });
</script>

@endsection