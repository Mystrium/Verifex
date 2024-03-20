@extends('nav')
@section('title', 'Типи')
@section('content')

<h1 class="mt-4">Типи операцій</h1>
<form action="{{ url('/workers/add') }}" method="POST">
    @csrf
    <div class="input-group">
        <span class="input-group-text">ПІБ</span>
        <input type="text" class="form-control" maxlength=20 name="pib" placeholder="Швея...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Цех</span>
        <select class="search-drop input-group-text" style="height:40px;" name="ceh">
            @foreach($cehs as $tp)
                <option value="{{$tp->id}}">{{$tp->ctitle}} {{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Посада</span>
        <select class="search-drop input-group-text" style="height:40px;" name="type">
            @foreach($types as $tp)
                <option value="{{$tp->id}}">{{$tp->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Телефон</span>
        <input type="number" class="form-control" name="phone" placeholder="+380...">
    </div>
    <div class="input-group">
        <span class="input-group-text">Паспорт</span>
        <input type="text" class="form-control" name="passport" placeholder="AR3245322">
    </div>
    <div class="input-group">
        <span class="input-group-text">Пароль</span>
        <input type="text" class="form-control" name="password">
    </div>
    <button type="submit" class="btn btn-primary m-2">Додати</button>
</form>
<table class="table table-striped table-success">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ПІБ</th>
            <th scope="col">Цех</th>
            <th scope="col">Посада</th>
            <th scope="col">Телефон</th>
            <th scope="col">Паспорт</th>
            <th scope="col">Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workers as $worker)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <form action="{{ url('/workers/update/' . $worker->id) }}" method="POST">
                @csrf
                <td><input type="text" class="form-control" maxlength=20 name="title" value="{{$worker->pib}}"></td>
                <td>
                    <select class="search-drop" name="cehtypes">
                        @foreach($cehs as $tp)
                            <option value="{{$tp->id}}" {{$tp->id==$worker->ceh_id?'selected':''}}>{{$tp->ctitle}} {{$tp->title}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="search-drop" name="cehtypes">
                        @foreach($types as $tp)
                            <option value="{{$tp->id}}" {{$tp->id==$worker->role_id?'selected':''}}>{{$tp->title}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" maxlength=20 name="title" value="{{$worker->phone}}"></td>
                <td><input type="text" class="form-control" maxlength=20 name="title" value="{{$worker->passport}}"></td>
                <td>
                <button type="submit" class="btn btn-warning btn-sm m-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                    </svg>
                </button>
            </form>
            <form method="GET" action="{{ url('/workers/delete/' . $worker->id) }}" style="display:inline">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити {{$worker->pib}} цех ?&quot;)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                </button>
            </form>
            </td>
        <tr>
        @endforeach
    </tbody>
</table>
@endsection