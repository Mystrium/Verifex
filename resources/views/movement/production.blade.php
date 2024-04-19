@extends('nav')
@section('title', 'Виробіток')
@section('content')

<h1 class="mt-4">Виробіток</h1>

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
            <div class="tab-pane fade show {{$loop->index == 0 ? 'active' : ''}}" id="w{{$prods->ceh_id}}" role="tabpanel">
                <table class="table table-striped table-success">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Робітник</th>
                            <th scope="col">Виріб</th>
                            <th scope="col">Колір</th>
                            <th scope="col">Кількість</th>
                        </tr>
                    </thead>
                    <tbody>
        @endif
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$prods->pib}}</td>
            <td>{{$prods->title}}</td>
            <td><div style="background-color:#{{$prods->hex}};">{{$prods->color}}</div></td>
            <td>{{$prods->count + 0}}</td>
        </tr>
        @php($uniq = $prods->ceh_id)
    @endforeach
</div>

@endsection