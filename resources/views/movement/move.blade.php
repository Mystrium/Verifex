@extends('navbar/main')
@section('title', 'Рух')
@section('action', 'Переміщення')
@section('content')

<form action="/movement" method="GET" class="pb-3">
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-end; flex-wrap: wrap" class="pb-3">
        <div class="pe-2">
            <h5>Період</h5>
        </div>
        <div class="pe-2">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div class="pt-1">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
    </div>
</form>

@if(count($moves) == 0)
    <div class="text-center">
        <h5 class="fw-bold">За цей період немає переміщень</h5>
    </div>
@else
    <table class="table table-striped table-success">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Звідки</th>
                <th scope="col">Хто</th>
                <th scope="col">Кому</th>
                <th scope="col">Куди</th>
                <th scope="col">Найменування</th>
                <th scope="col">Колір</th>
                <th scope="col">Кількість</th>
                <th scope="col">Дата</th>
            </tr>
        </thead>
        <tbody>
            @foreach($moves as $move)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$move->cehtype}} {{$move->ceh_title}}</td>
                    <td>
                        {{$move->pib}}
                        <a href="/workers/edit/{{$move->worker}}" style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        {{$move->to_pib}}
                        <a href="/workers/edit/{{$move->worker_to_id}}" style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </a>
                    </td>
                    <td>{{$move->cehtypeto}} {{$move->cehto_title}}</td>
                    <td>
                        {{$move->title}}
                        <a href="/items/edit/{{$move->item}}" style="text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <div style="background-color:#{{$move->hex}};">
                            <span style="mix-blend-mode: difference; color:white">
                                {{$move->color}}
                            </span>
                        </div>
                    </td>
                    <td>{{$move->count + 0}} {{$move->unit}}</td>
                    <td>{{$move->date}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection