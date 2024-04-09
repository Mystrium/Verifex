@extends('nav')
@section('title', 'ЗП')
@section('content')

<h1 class="mt-4">Заробітня плата робітників</h1>
<table class="table table-striped table-success" id="jsTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Робітник</th>
            <th scope="col">Оплата ₴</th>
            <th scope="col">за</th>
            <th scope="col">Дата</th>
            <th scope="col">Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pays as $pay)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td><a href="/workers/edit/{{$pay->id}}">{{$pay->pib}}</a></td>
                <td>
                    @if($pay->sum > $pay->min_pay)
                        {{$pay->sum}}
                        </td>
                        <td>
                            Виробіток
                    @else
                        {{$pay->min_pay}}
                        </td>
                        <td>
                            Мінімальна ЗП
                    @endif
                </td>
                <td>{{$pay->date}}</td>
                <td>
                    <a href="/pay/{{$pay->id}}" class="btn btn-info btn-sm">
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


