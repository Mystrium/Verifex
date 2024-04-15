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
            <th scope="col">dell</th>
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
                <td>
                    <form method="GET" action="{{ url('/movement/delete/' . $move->trans) }}" style="display:inline">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити цех ?&quot;)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<pre>{{json_encode($anomaly, JSON_PRETTY_PRINT);}}</pre>
{{--<br>
<pre>{{json_encode($workers, JSON_PRETTY_PRINT);}}</pre>
<pre>{{json_encode($consists, JSON_PRETTY_PRINT);}}</pre>

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
@endforeach--}}

<div class="card-group">
    @foreach($workers as $worker => $items)
        <div class="col">
            <div class="card m-1" id="w{{$worker}}">
                <div class="card-header">
                    @foreach($names as $nm)
                        @if($nm->id == $worker)
                            {{$nm->pib}}
                            @if($nm->id != 1)
                                <a href="/workers/edit/{{$nm->id}}" style="text-decoration: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                </a>
                            @endif
                            @break
                        @endif
                    @endforeach
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($items as $item => $colors)
                        <li class="list-group-item">
                            @foreach($itemsnames as $itm)
                                @if($itm->id == $item)
                                    {{$itm->title}}
                                    <a href="/items/edit/{{$itm->id}}" style="text-decoration: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                        </svg>
                                    </a>
                                    </a>
                                    @php($unit = $itm->unit)
                                    @break
                                @endif
                            @endforeach
                        </li>
                        <ul>
                            @foreach($colors as $color => $count)
                                <li class="list-group-item">
                                    @foreach($colornames as $col)
                                        @if($col->id == $color)
                                            <span style="background-color:#{{$col->hex}};">
                                                <span style="mix-blend-mode: difference; color:white">
                                                    {{$col->title}}
                                                </span>
                                            </span> ==>
                                            @break
                                        @endif
                                    @endforeach
                                    {{$count}} {{$unit}}
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>

<script>

</script>

@endsection