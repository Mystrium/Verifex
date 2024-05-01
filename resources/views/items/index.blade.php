@extends('navbar/main')
@section('title', 'Вироби')
@section('btnroute', 'items/new')
@section('content')

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#titems" type="button" role="tab" aria-controls="home" aria-selected="true">
            Вироби
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#toperations" type="button" role="tab" aria-controls="home" aria-selected="true">
            Півфабрикати/Операції
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#tmaterials" type="button" role="tab" aria-controls="home" aria-selected="true">
            Матеріали
        </button>
    </li>
</ul>

<div class="tab-content pt-1">
    <div class="tab-pane active show" id="titems" role="tabpanel">
        <table name="jsTable" class="table table-success w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Фото</th>
                    <th scope="col">Назва</th>
                    <th scope="col">Одиниця</th>
                    <th scope="col">Оплата ₴</th>
                    <th scope="col">Кольоровий</th>
                    <th scope="col">Опис</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-center"><img src="{{$item->url_photo}}" style="max-width:100px;max-height:100px"></td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->unit}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->hascolor==1?'Так':'Ні'}}</td>
                        <td>{{substr($item->description, 0, 50)}}</td>
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
    <div class="tab-pane" id="toperations" role="tabpanel">
        <table name="jsTable" class="table table-success w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Фото</th>
                    <th scope="col">Назва</th>
                    <th scope="col">Одиниця</th>
                    <th scope="col">Оплата ₴</th>
                    <th scope="col">Кольоровий</th>
                    <th scope="col">Опис</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($operations as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-center"><img src="{{$item->url_photo}}" style="max-width:100px;max-height:100px"></td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->unit}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->hascolor==1?'Так':'Ні'}}</td>
                        <td>{{$item->description}}</td>
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

    <div class="tab-pane" id="tmaterials" role="tabpanel">
        <table name="jsTable" class="table table-success w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">Фото</th>
                    <th scope="col">Назва</th>
                    <th scope="col">Одиниця</th>
                    <th scope="col">Кольоровий</th>
                    <th scope="col">Опис</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-center"><img src="{{$item->url_photo}}" style="max-width:100px;max-height:100px"></td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->unit}}</td>
                        <td>{{$item->hascolor==1?'Так':'Ні'}}</td>
                        <td>{{$item->description}}</td>
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
</div>
@if(session('msg') == 23000)
    <div class="alert alert-danger" role="alert" style="position: fixed; top: 15%; left:30%; z-index: 1100;">
        Ви не можете видалити виріб, він використовується в переміщеннях, закупах (а може і є складником якогось виробу)
    </div>
@endif
@endsection