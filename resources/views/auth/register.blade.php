<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verifex</title>
        <link rel="icon" type="image/png" sizes="16x16" href="/logo.png"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
        <section class="vh-100">
            <div style="height:10%"></div>
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST" action="/register">
                            @csrf
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start pb-4">
                                <p class="lead fw-normal mb-0 me-3">Подати заявку</p>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" name="pib" class="form-control form-control-lg" placeholder="Іваненко П.П." required autofocus/>
                                <label class="form-label">ПІБ</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="number" name="phone" class="form-control form-control-lg" min="100000000" max="380999999999" placeholder="+380..." required/>
                                <label class="form-label">Телефон</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="password" name="password" class="form-control form-control-lg"/>
                                <label class="form-label" for="form3Example4">Пароль</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-3">
                                <select class="search-drop input-group-text" name="role" id="role_select">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" {{isset($edit)?($role->id==$edit->role_id?'selected':''):''}}>{{$role->title}}</option>
                                    @endforeach
                                </select>
                                <label class="form-label" for="form3Example4">Посада</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-body">Вашу заявку розглянуть</p>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" type="button" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Зареєструватись</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @if(session('msg'))
            <div class="alert alert-danger" role="alert" style="position: fixed; top: 15%; left:30%; z-index: 1100;">
                {{session('msg')}}
            </div>
        @endif
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>$('.alert').fadeOut(7000);</script>
    </body>
</html>
