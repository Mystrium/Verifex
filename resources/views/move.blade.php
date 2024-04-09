@extends('nav')
@section('title', 'Рух')
@section('content')

<h1 class="mt-4">PYX DEBUG !!!</h1>

<table class="table table-striped table-success">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">цех</th>
            <th scope="col">хто</th>
            <th scope="col">дія</th>
            <th scope="col">komu</th>
            <th scope="col">виріб</th>
            <th scope="col">колір</th>
            <th scope="col">кількість</th>
            <th scope="col">дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($moves as $move)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$move->ceh_id}}</td>
                <td>{{$move->worker}} {{$move->pib}}</td>
                <td>
                    @if($move->type_id == 1)
                        <p class="bg-warning" style="width:40px">[  ->  ]</p>
                    @endif
                    @if($move->type_id == 2)
                        <p class="bg-info" style="width:40px">[  <-  ]</p>
                    @endif
                    @if($move->type_id == 3)
                        <p class="bg-success" style="width:30px">[  +  ]</p>
                    @endif
                    @if($move->type_id == 4)
                        <p class="bg-danger" style="width:30px">[  -  ]</p>
                    @endif
                </td>
                <td>{{$move->worker_to_id}}</td>
                <td>{{$move->title}}</td>
                <td>{{$move->color_id}}</td>
                <td>{{$move->count}}</td>
                <td>{{$move->date}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<pre>{{json_encode($anomaly, JSON_PRETTY_PRINT);}}</pre>
<br><br><br>
{{--<pre>{{json_encode($consists, JSON_PRETTY_PRINT);}}</pre>--}}

@foreach($workers as $worker => $items)
    <br>
    <h4>worker {{$worker}}</h4>
    <h5 class="ps-2">Items</h5>
    @foreach($items as $item => $colors)
        <h6 class="ps-4">{{$item}}</h6>
        @foreach($colors as $color => $count)
            <p class="ps-5">{{$color}} ==> {{$count}}</p>
        @endforeach
    @endforeach
@endforeach



@endsection