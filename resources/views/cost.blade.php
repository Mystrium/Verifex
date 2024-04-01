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
            <th scope="col">Одиниця</th>
            <th scope="col">Ціна $</th>
            <th scope="col">Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$item->title}}</td>
                <td><img src="{{$item->url_photo}}" style="max-width:100px; max-height:100px"></td>
                <td>{{$item->unit}}</td>
                <td>1</td>
                <td>1</td>
            </tr>
            @foreach($item->subitems as $sub)
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$sub->title}}</td>
                    <td><img src="{{$sub->url_photo}}" style="max-width:100px; max-height:100px"></td>
                    <td>{{$sub->cnt}}</td>
                    <td>{{$sub->unit}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>



@endsection


