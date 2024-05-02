@extends('navbar/main')
@section('title', 'Цехи')
@section('content')

<form action="{{ url('/cehs/add') }}" method="POST">
    @csrf
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-start; flex-wrap: wrap" class="pb-3">
        <div class="pe-2">
            <div class="pb-2">
                <span class="fw-bold">Тип</span>
            </div>
            <select class="search-drop" name="type">
                @foreach($types as $tp)
                    <option value="{{$tp->id}}">{{$tp->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="pe-2">
            <span class="fw-bold">Назва</span>
            <br>
            <input type="text" class="form-control" maxlength=20 name="title" placeholder="Розкрієчний...">
        </div>
        <div style="align-self: flex-end" class="pt-1">
            <button type="submit" class="btn btn-success">Додати</button>
        </div>
    </div>
</form>
<table class="table table-striped table-success">
    <thead>
        <tr>
            <form action="{{ url('/cehs') }}" method="GET">
                <th></th>
                <td>
                    <select class="search-drop input-group-text" style="height:40px;" name="search[]">
                        <option value="0">-</option>
                        @foreach($types as $tp)
                            <option value="{{$tp->id}}" {{isset($search[0])?($search[0]==$tp->id?'selected':''):''}}>{{$tp->title}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" maxlength=20 name="search[]" value="{{$search[1]??''}}"></td>
                <td>
                    <button type="submit" class="btn btn-info btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </td>
            </form>
        </tr>
        @if(count($cehs) == 0)
            <tr>
                <td></td>
                <td></td>
                <td>Нічого не знайдено...</td>
                <td></td>
            </tr>
        @else
            <tr>
                <th scope="col">#</th>
                <th scope="col">Тип</th>
                <th scope="col">Назва</th>
                <th scope="col">Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cehs as $ceh)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <form action="{{ url('/cehs/update/' . $ceh->id) }}" method="POST">
                    @csrf
                    <td>
                        <select onchange="toedit(this,'{{$tp->id}}','edt{{$ceh->id}}')" class="search-drop" name="type">
                            @foreach($types as $tp)
                                <option value="{{$tp->id}}" {{$tp->id==$ceh->type_id?'selected':''}}>{{$tp->title}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" class="form-control" oninput="toedit(this,'{{$tp->id}}','edt{{$ceh->id}}')" maxlength=20 name="title" value="{{$ceh->title}}"></td>
                    <td>
                    <button disabled id="edt{{$ceh->id}}" type="submit" class="btn btn-warning btn-sm m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                            <path d="M11 2H9v3h2z"/>
                            <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>
                    </button>
                </form>
                <form method="GET" action="{{ url('/cehs/delete/' . $ceh->id) }}" style="display:inline">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Видалити {{$ceh->title}} цех ?&quot;)">
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
        Ви не можете видалити цех, в ньому є робітники
    </div>
@endif
@endsection