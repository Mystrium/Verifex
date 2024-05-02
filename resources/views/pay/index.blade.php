@extends('navbar/main')
@section('title', 'ЗП')
@section('action', 'Заробітня плата робітників')
@section('content')

<form method="GET" action="/pay">
    <div style="display: flex; flex-direction: row; justify-content: row; align-items: center">
        <div class="pe-2">
            <h5>Період</h5>
        </div>    
        <div class="pe-2">
            <div class="input-group">
                <span class="input-group-text">Від</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[0]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div class="pe-2">
            <div class="input-group">
                <span class="input-group-text">До</span>    
                <input type="date" class="form-control" name="period[]" value="{{$period[1]??''}}" onchange="this.form.submit()">
            </div>
        </div>
        <div>
            @if(empty(Request()->period))
                <h5>(за минулий тиждень)</h5>
            @endif
        </div>
    </div>
</form>
<hr>
<table class="table table-striped table-success" name="jsTable">
    <thead>
        <tr>
            <th scope="col" class="text-start">#</th>
            <th scope="col">Робітник</th>
            <th scope="col">Оплата ₴</th>
            <th scope="col">за</th>
            <th scope="col">Дата</th>
            <th scope="col" class="col-md-1 text-center">Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pays as $pay)
            <tr>
                <th scope="row" class="text-start">{{ $loop->iteration }}</th>
                <td>
                    {{$pay->pib}}
                    <a href="/workers/edit/{{$pay->id}}" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                    </a>
                </td>
                <td>
                    @if($pay->sum > $pay->min_pay)
                        {{$pay->sum + 0}}
                        </td>
                        <td>
                            Виробіток
                    @else
                        {{$pay->min_pay + 0}}
                        </td>
                        <td>
                            Мінімальна ЗП
                    @endif
                </td>
                <td>{{$pay->date}}</td>
                <td class="text-center">
                    <a href="/pay/{{$pay->id}}{{explode('pay', url()->full())[1] ?? ''}}" class="btn btn-info btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection


