@extends('nav')
@section('title', 'Робітники')
@section('content')

<h1 class="mt-4">Робітники</h1>
<a href="workers/new" class="btn btn-success m-2">Створити</a>
<table class="table table-striped table-success" id="jsTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ПІБ</th>
            <th scope="col">Цех</th>
            <th scope="col">Посада</th>
            <th scope="col">Телефон</th>
            <th scope="col">Паспорт</th>
            <th scope="col">Перевірений</th>
            <th scope="col">Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workers as $worker)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$worker->pib}}</td>
                <td>{{$worker->ctitle}} {{$worker->title}}</td>
                <td>{{$worker->role}}</td>
                <td>{{$worker->phone}}</td>
                <td>{{$worker->passport}}</td>
                <td>
                    <form action="/workers/check/{{$worker->id}}" method="POST">
                        @csrf
                        <input type="checkbox" name="status" {{$worker->checked==1?'checked':''}} onchange="this.form.submit()"/>
                    </form>
                </td>
                <td>
                    <a href="/workers/edit/{{$worker->id}}" class="btn btn-warning btn-sm m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </a>
                    <a href="/workers/delete/{{$worker->id}}" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити {{$worker->pib}} ?&quot;)">
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

@if(session('msg') == 23000)
    <div class="alert alert-danger" role="alert" style="position: fixed; top: 15%; left:30%; z-index: 1100;">
        Ви не можете видалити цього користувача, тому що його записи використовуються в переміщеннях
    </div>
@endif

@endsection