@extends('navbar/main')
@section('title', 'Вироби')
@section('btnroute', 'items/new')
@section('content')

<ul class="nav nav-tabs justify-content-center border-botom" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#q0" type="button" role="tab" aria-controls="home" aria-selected="true">
            Вироби
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#q1" type="button" role="tab" aria-controls="home" aria-selected="true">
            Півфабрикати/Операції
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#q2" type="button" role="tab" aria-controls="home" aria-selected="true">
            Матеріали
        </button>
    </li>
</ul>

<div class="tab-content pt-1">
    @foreach($items as $cat)
        <div class="tab-pane {{$loop->index==0?'active show':''}}" id="q{{$loop->index}}" role="tabpanel">
            <table name="jsTable" class="table table-success w-100">
                <thead>
                    <tr>
                        <th scope="col" class="text-start">#</th>
                        <th scope="col" class="text-center">Фото</th>
                        <th scope="col">Назва</th>
                        <th scope="col">Категорія</th>
                        <th scope="col">Одиниця</th>
                        @if($cat[0]->price > 0)
                            <th scope="col">Оплата ₴</th>
                        @endif
                        <th scope="col">Кольоровий</th>
                        <th scope="col">Опис</th>
                        <th scope="col" class="col-md-1 text-center">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cat as $item)
                        <tr>
                            <th scope="row" class="text-start">{{ $loop->iteration }}</th>
                            <td class="text-center"><img src="{{$item->url_photo}}" style="max-width:100px;max-height:100px"></td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->category}}</td>
                            <td>{{$item->unit}}</td>
                            @if($cat[0]->price > 0)
                                <td>{{$item->price}}</td>
                            @endif
                            <td>{{$item->hascolor==1?'Так':'Ні'}}</td>
                            <td>{{strlen($item->description) > 30 ? mb_substr($item->description, 0, 30, "utf-8").'...' : $item->description}}</td>
                            <td>
                                <a href="/items/edit/{{$item->id}}" class="btn btn-warning btn-sm m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                </a>
                                <a href="/items/delete/{{$item->id}}" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити виріб {{$item->title}} ?&quot;)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

@if(session('msg') == 23000)
    <div class="alert alert-danger" role="alert" style="position: fixed; top: 15%; left:30%; z-index: 1100;">
        Ви не можете видалити виріб, він використовується в переміщеннях, закупах (а може і є складником якогось виробу)
    </div>
@endif

@endsection