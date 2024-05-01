@extends('navbar/main')
@section('title', 'Виробіток')
@section('content')

<form action="/production" method="GET" class="pb-3">
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
        <div>
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
    </div>
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: flex-end; flex-wrap: wrap" class="pb-3">
        <div class="pe-4">
            <h5>Групування</h5>
        </div>    
        <div class="pe-4">
            <span>Робітники</span>
            <br>
            <label class="switch">
                <input type="checkbox" name="byworker" {{isset($group['worker'])?'checked':''}} onchange="this.form.submit()"/>
                <span class="slider round"></span>
            </label>
        </div>
        <div>
            <span>Кольори</span>
            <br>
            <label class="switch">
                <input type="checkbox" name="bycolor"  {{isset($group['color']) ?'checked':''}} onchange="this.form.submit()"/>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</form>

@if(count($moves) == 0)
    <div class="text-center">
        <h5 class="fw-bold">За цей період нічого не виробили :(</h5>
    </div>
@else
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @php($uniq = '')
        @foreach($moves as $prods)
            @if($uniq != $prods->ceh_id)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{$loop->index == 0 ? 'active' : ''}}" id="home-tab" data-bs-toggle="tab" data-bs-target="#w{{$prods->ceh_id}}" type="button" role="tab">
                        {{$prods->type}} {{$prods->ceh}}
                    </button>
                </li>
            @endif
            @php($uniq = $prods->ceh_id)
        @endforeach
    </ul>
@endif

@php($uniq = '')
<div class="tab-content pt-1">
    @foreach($moves as $prods)
        @if($uniq != $prods->ceh_id)
            @if($loop->index > 0)
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="tab-pane show {{$loop->index == 0 ? 'active' : ''}}" id="w{{$prods->ceh_id}}" role="tabpanel">
                <table class="table table-striped table-success">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            @if(!empty($group['worker']))
                                <th scope="col">Робітник</th>
                            @endif
                            <th scope="col">Виріб</th>
                            @if(!empty($group['color']))
                                <th scope="col">Колір</th>
                            @endif
                            <th scope="col">Кількість</th>
                        </tr>
                    </thead>
                    <tbody>
        @endif
        <tr>
            <td>{{$loop->iteration}}</td>
            @if(!empty($group['worker']))
                <td>
                    {{$prods->pib}}
                    <a href="/workers/edit/{{$prods->worker}}" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                    </a>
                </td>
            @endif            
            <td>
                {{$prods->title}}
                <a href="/items/edit/{{$prods->item}}" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                </a>
            </td>
            @if(!empty($group['color']))
                <td>
                    <div style="background-color:#{{$prods->hex}};">
                        <span style="mix-blend-mode: difference; color:white">
                            {{$prods->color}}
                        </span>
                    </div>
                </td>
            @endif
            <td>{{$prods->count + 0}} {{$prods->unit}}</td>
        </tr>
        @php($uniq = $prods->ceh_id)
    @endforeach
</div>

@endsection