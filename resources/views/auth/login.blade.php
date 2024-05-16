<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verifex</title>
        <link rel="icon" type="image/png" sizes="16x16" href="/logo.png"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body>
        <section class="vh-100">
            <div style="height:15%"></div>
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST" action="/login">
                            @csrf
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start pb-4">
                                <p class="lead fw-normal mb-0 me-3">Вхід</p>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="number" name="phone" class="form-control form-control-lg" placeholder="+380..." required autofocus/>
                                <label class="form-label">Телефон</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"/>
                                <label class="form-label" for="form3Example4">Пароль</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" id="form2Example3"/>
                                <label class="form-check-label" for="form2Example3">
                                    Забути мене
                                </label>
                                </div>
                                <a href="#!" class="text-body">Забули пароль? Добре, допобачення !</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" type="button" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Увійти</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Не зареєстровані ? <a href="/register" class="link-danger">то зареєструйтесь</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @if(session('msg'))
            <div class="alert alert-danger" role="alert" style="position: fixed; top: 5%; left:60%; z-index: 1100;">
                {{session('msg')}}
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>$('.alert').fadeOut(7000);</script>
        @endif
    </body>
</html>
