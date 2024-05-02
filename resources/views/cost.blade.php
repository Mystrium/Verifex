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
                <td>{{$item->title}}
                    <a href="/items/edit/{{$item->id}}" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                    </a>
                </td>
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
                <th id="1a{{$item->id}}">[ + ]</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
                    <td>{{$sub->title}}
                        <a href="/items/edit/{{$sub->have_id}}" style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </a>
                    </td>
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
                <th id="1b{{$item->id}}">[ + ]</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
                    <td>{{$sub->title}}
                        <a href="/items/edit/{{$sub->have_id}}" style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </a>
                    </td>
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