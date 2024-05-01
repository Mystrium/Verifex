@extends('navbar/main')
@section('title', 'Типи цехів')
@section('content')

<form action="{{ url('/cehtypes/add') }}" method="POST">
    @csrf
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-end; flex-wrap: wrap" class="pb-3">
        <div class="pe-2">
            <span class="fw-bold">Назва</span>
            <br>
            <input type="text" class="form-control" minlength=5 maxlength=30 required name="title" placeholder="Розкрієчний...">
        </div>
        <div class="pt-1">
            <button type="submit" class="btn btn-success">Додати</button>
        </div>
    </div>
</form>

<table class="table table-striped table-success">
    <thead>
        <tr>
            <form action="{{ url('/cehtypes') }}" method="GET">
                <th></th>
                <td><input type="text" class="form-control" maxlength=20 name="search" value="{{$search??''}}"></td>
                <td>
                    <button type="submit" class="btn btn-info btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </td>
            </form>
        </tr>
        @if(count($types) == 0)
            <tr>
                <td></td>
                <td>Нічого не знайдено...</td>
                <td></td>
            </tr>
        @else
            <tr>
                <th scope="col">#</th>
                <th scope="col">Назва</th>
                <th scope="col">Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $opr)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <form action="{{ url('/cehtypes/update/' . $opr->id) }}" method="POST">
                        @csrf
                        <td><input type="text" class="form-control" maxlength=20 oninput="toedit(this,'{{$opr->title}}','edt{{$opr->id}}')" name="title" value="{{$opr->title}}"></td>
                        <td>
                        <button disabled id="edt{{$opr->id}}" type="submit" class="btn btn-warning btn-sm m-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </button>
                    </form>
                    <form method="GET" action="{{ url('/cehtypes/delete/' . $opr->id) }}" style="display:inline">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити {{$opr->title}} цех ?&quot;)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </button>
                    </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if(session('msg') == 23000)
    <div class="alert alert-danger" role="alert" style="position: fixed; top: 18%; left:40%; z-index: 1100;">
        З таким типом є цех, спочатку видаліть цех
    </div>
@endif
@endsection