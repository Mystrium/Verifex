@extends('navbar/main')
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
                <th scope="col">Опис</th>
                <th scope="col">За роботу</th>
                <th scope="col">Кількість</th>
                <th scope="col">Сума</th>
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
            <tr type="button" onclick="hiderows('a{{$item->id}}')">
                <th>Операції</th>
                <th colspan=6 id="1a{{$item->id}}">[ + ]</th>
            </tr>
            <tr name="a{{$item->id}}" hidden>
                <th scope="col">#</th>
                <th scope="col">Назва</th>
                <th scope="col">Фото</th>
                <th scope="col">Опис</th>
                <th scope="col">За роботу</th>
                <th scope="col">Кількість</th>
                <th scope="col">Сума</th>
            </tr>
            @php($total = 0)
            @foreach($item->work as $sub)
                <tr name="a{{$item->id}}" hidden>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$sub->title}}</td>
                    <td>
                        <a href="/items/edit/{{$sub->have_id}}">    
                            <img src="{{$sub->url_photo}}" style="max-width:100px; max-height:100px">
                        </a>
                    </td>
                    <td>{{$sub->description}}</td>
                    <td>{{round($sub->price, 2)}}₴</td>
                    <td>{{$sub->count + 0}}</td>
                    <td>{{round($sub->count * $sub->price, 2)}}₴</td>
                </tr>
                @php($total += $sub->count * $sub->price)
            @endforeach
            <tr type="button" onclick="hiderows('b{{$item->id}}')">
                <th>Матеріали</th>
                <th colspan=6 id="1b{{$item->id}}">[ + ]</th>
            </tr>
            <tr name="b{{$item->id}}" hidden>
                <th scope="col">#</th>
                <th scope="col">Назва</th>
                <th scope="col">Фото</th>
                <th scope="col">Опис</th>
                <th scope="col">Ціна</th>
                <th scope="col">Кількість</th>
                <th scope="col">Сума</th>
            </tr>
            @foreach($item->subitems as $sub)
                <tr name="b{{$item->id}}" hidden>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$sub->title}}</td>
                    <td>
                        <a href="/items/edit/{{$sub->have_id}}">    
                            <img src="{{$sub->url_photo}}" style="max-width:100px; max-height:100px">
                        </a>
                    </td>
                    <td>{{$sub->description}}</td>
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
                <td class="fw-bold">Всього</td>
                <td class="fw-bold">{{round($total, 2)}}₴</td>
            </tr>
        </tbody>
    </table>
@endforeach
<script>
    function hiderows(id) {
        var a = document.getElementsByName(id);
        var text = document.getElementById('1' + id)
        if(a[0].hidden == false) {
            a.forEach(element => {
                element.hidden = true
            });
            text.innerHTML = "[ + ]"
        } else {
            a.forEach(element => {
                element.hidden = false
            });
            text.innerHTML = "[ - ]"
        }
    }
</script>
@endsection