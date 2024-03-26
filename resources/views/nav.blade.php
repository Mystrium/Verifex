<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="icon" type="image/ico" sizes="16x16" href="/favicon.ico"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}" type="text/css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
        <style>@charset "UTF-8";

        .fixed-top, .sb-nav-fixed #layoutSidenav #layoutSidenav_nav, .sb-nav-fixed .sb-topnav {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 30;
        }

        #layoutSidenav #layoutSidenav_nav {
            flex-basis: 150px;
            flex-shrink: 0;
            transition: transform 0.15s ease-in-out;
            z-index: 1038;
            transform: translateX(-150px);
        }

        #layoutSidenav #layoutSidenav_content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            flex-grow: 1;
            margin-left: -150px;
        }

        @media (min-width: 992px) {
            #layoutSidenav #layoutSidenav_nav { transform: translateX(0); }
            #layoutSidenav #layoutSidenav_content {
                margin-left: 0;
                transition: margin 0.15s ease-in-out;
            }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {transform: translateX(-150px); }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content { margin-left: -150px; }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before {display: none; }
        }

        .sb-nav-fixed .sb-topnav {  z-index: 1039; }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
            width: 150px;
            height: 100vh;
            z-index: 1038;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 150px;
            top: 30px;
        }

        .sb-sidenav {
            display: flex;
            flex-direction: column;
            height: 100%;
            flex-wrap: nowrap;
        }

        .sb-sidenav .sb-sidenav-menu { flex-grow: 1; }

        .sb-sidenav .sb-sidenav-menu .nav .sb-sidenav-menu-heading {
            padding: 1.75rem 1rem 0.75rem;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sb-sidenav .sb-sidenav-menu .nav .nav-link {
            display: flex;
            align-items: center;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            position: relative;
        }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>    
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-secondary bg-secondary">
            <h2 class="m-2 text-body">Verifex</h2>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="green" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{auth()->user()}} </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><hr class="dropdown-divider" /></li>
                        <li class="dropdown">
                            <button type="button" class="btn btn-sm">
                                
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        @php($title = app()->view->getSections()['title'])
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion bg-secondary" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading m-2">Core</div>
                            <ul class="nav nav-pills flex-column m-3">
                                <li>
                                    <a class="dropdown-toggle nav-link collapsed text-body" href="#" data-bs-toggle="collapse" data-bs-target="#statscolapse2" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Одиниці
                                    </a>
                                    <div style="padding-left:20px;" class="collapse {{$title=='Виміри'||$title=='Кольори'?'show':''}}" id="statscolapse2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{$title=='Виміри'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/units">
                                                Виміру
                                            </a>
                                            <a class="nav-link {{$title=='Кольори'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/colors">
                                                Кольори
                                            </a>
                                        </nav>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-toggle nav-link collapsed text-body" href="#" data-bs-toggle="collapse" data-bs-target="#statscolapse4" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Вироби
                                    </a>
                                    <div style="padding-left:20px;"class="collapse {{$title=='Вироби'||$title=='Закуп'?'show':''}}" id="statscolapse4" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{$title=='Вироби'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/items">
                                                Вироби
                                            </a>
                                            <a class="nav-link {{$title=='Закуп'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/purchases">
                                                Закуп
                                            </a>
                                        </nav>
                                    </div>
                                </li>

                                <hr class="text-body">
                                <li>
                                    <a class="dropdown-toggle nav-link collapsed text-body" href="#" data-bs-toggle="collapse" data-bs-target="#statscolapse" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Цехи
                                    </a>
                                    <div style="padding-left:20px;"class="collapse {{$title=='Типи цехів'||$title=='Цехи'?'show':''}}" id="statscolapse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{$title=='Типи цехів'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/cehtypes">
                                                Типи
                                            </a>
                                            <a class="nav-link {{$title=='Цехи'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/cehs">
                                                Цехи
                                            </a>
                                        </nav>
                                    </div>
                                </li>

                                <li>
                                    <a class="dropdown-toggle nav-link collapsed text-body" href="#" data-bs-toggle="collapse" data-bs-target="#statscolapse3" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Робітники
                                    </a>
                                    <div style="padding-left:20px;"class="collapse {{$title=='Робітники'||$title=='Посади'?'show':''}}" id="statscolapse3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{$title=='Робітники'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/workers">
                                                Робітники
                                            </a>
                                            <a class="nav-link {{$title=='Посади'?'text-bold text-warning':'text-body link-body-emphasis'}}" href="/worktypes">
                                                Посади
                                            </a>
                                        </nav>
                                    </div>
                                </li>
                                <hr class="text-body">

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid p-4">
                        @yield('content')
                    </div>
                </main>
            </div>

        </div>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
        <script> new DataTable('#jsTable'); </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/navbar.js') }}"></script>
        <script>$('.search-drop').select2();</script>
        <script>
            window.toedit = function(self, val, edit_btn){
                if(self.value != val)
                    document.getElementById(edit_btn).disabled = false;
                else
                    document.getElementById(edit_btn).disabled = true;
            }
        </script>
    </body>
</html>
