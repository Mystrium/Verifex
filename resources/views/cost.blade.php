@extends('nav')
@section('title', 'Вартість')
@section('action', 'Собівартість виробів')
@section('content')

@foreach($items as $item)
    <table class="table table-striped table-success">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Назва</th>
                <th scope="col">Фото</th>
                <th scope="col">-</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$item->title}}</td>
                <td>
                    <a href="/items/edit/{{$item->id}}">
                        <img src="{{$item->url_photo}}" style="max-width:100px; max-height:100px">
                    </a>
                </td>
                <td>-</td>
                <td>-</td>
                <td>{{$item->unit}}</td>
                <td>-</td>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Операції</th>
                <th scope="col">Опис</th>
                <th scope="col">Фото</th>
                <th scope="col">За роботу</th>
                <th scope="col">Кількість</th>
                <th scope="col">Сума</th>
            </tr>
            @php($total = 0)
            @foreach($item->work as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$sub->title}}</td>
                    <td>{{$sub->description}}</td>
                    <td>
                        <a href="/items/edit/{{$sub->have_id}}">    
                            <img src="{{$sub->url_photo}}" style="max-width:100px; max-height:100px">
                        </a>
                    </td>
                    <td>{{round($sub->price, 2)}}₴</td>
                    <td>{{$sub->count + 0}}</td>
                    <td>{{round($sub->count * $sub->price, 2)}}₴</td>
                </tr>
                @php($total += $sub->count * $sub->price)
            @endforeach
            <tr>
                <th scope="col">#</th>
                <th scope="col">Матеріали</th>
                <th scope="col">Опис</th>
                <th scope="col">Фото</th>
                <th scope="col">Ціна</th>
                <th scope="col">Кількість</th>
                <th scope="col">Сума</th>
            </tr>
            @foreach($item->subitems as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$sub->title}}</td>
                    <td>{{$sub->description}}</td>
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
                <td></td>
                <td></td>
                <td>Всього</td>
                <td>{{round($total, 2)}}₴</td>
            </tr>
        </tbody>
    </table>
@endforeach
@endsection