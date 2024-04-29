@extends('navbar/main')
@section('title', 'Виробіток')
@section('content')

<form action="/production" method="GET" class="pb-3">
    <div class="row">
        <div class="col-1">
            <div class="input-group">
                <h5>Період</h5>
            </div>
        </div>
        <div class="col-md-auto">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div class="col-md-auto">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
    </div>
    <div>
        <span class="fw-bold">Робітники</span>
        <br>
        <label class="switch">
            <input type="checkbox" name="byworker" {{isset($group['worker'])?'checked':''}} onchange="this.form.submit()"/>
            <span class="slider round"></span>
        </label>
    </div>
    <div>
        <span class="fw-bold">Кольори</span>
        <br>
        <label class="switch">
            <input type="checkbox" name="bycolor"  {{isset($group['color']) ?'checked':''}} onchange="this.form.submit()"/>
            <span class="slider round"></span>
        </label>
    </div>
</form>

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
                <td>{{$prods->pib}}</td>
            @endif            
            <td>{{$prods->title}}</td>
            @if(!empty($group['color']))
                <td><div style="background-color:#{{$prods->hex}};">{{$prods->color}}</div></td>
            @endif
            <td>{{$prods->count + 0}}</td>
        </tr>
        @php($uniq = $prods->ceh_id)
    @endforeach
</div>

@endsection