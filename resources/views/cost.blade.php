@extends('nav')
@section('title', 'Вартість')
@section('content')

<h1 class="mt-4">Собівартість продуктів</h1>
<table class="table table-striped table-success">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Назва</th>
            <th scope="col">Фото</th>
            <th scope="col">-</th>
            <th scope="col">Ціна</th>
            <th scope="col">Кількість</th>
            <th scope="col">Сума</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$item->title}}</td>
                <td>
                    <a href="/items/edit/{{$item->id}}">
                        <img src="{{$item->url_photo}}" style="max-width:100px; max-height:100px">
                    </a>
                </td>
                <td>-</td>
                <td>{{$item->work_cost + 0}}₴</td>
                <td>{{$item->unit}}</td>
                <td>-</td>
            </tr>
            @php($total = $item->work_cost)
            @foreach($item->subitems as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td></td>
                    <td>{{$sub->title}}</td>
                    <td>
                        <a href="/items/edit/{{$sub->have_id}}">    
                            <img src="{{$sub->url_photo}}" style="max-width:100px; max-height:100px">
                        </a>
                    </td>
                    <td>{{$sub->price ? round($sub->price, 2) . '₴' : 'He закупленo'}}</td>
                    <td>{{$sub->cnt + 0}} {{$sub->unit}}</td>
                    <td>{{round($sub->cnt * $sub->price, 2)}}₴</td>
                </tr>
                @php($total += $sub->cnt * $sub->price)
            @endforeach
            <tr>
                <th></th>
                <td></td>
                <td></td>
                <td>Всього</td>
                <td>{{round($total, 2)}}₴</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection