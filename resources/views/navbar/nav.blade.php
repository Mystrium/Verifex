<nav class="sb-topnav navbar navbar-expand navbar-secondary nav1 border-bottom border-dark border-2">
    <img src="/logo.png" style="width:30px; margin-right: -20px;" class="ms-3">
    <h2 class="m-2 text-white-50">erifex</h2>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="gray" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </button>
    @php($title = app()->view->getSections()['title'])
    <h3 class="ps-4 text-white-50">{{ app()->view->getSections()['action'] ?? $title }}</h3>
    @if(!empty(app()->view->getSections()['btnroute']))
        <a href="{{app()->view->getSections()['btnroute']}}" class="btn btn-success ms-3">{{ app()->view->getSections()['btntext'] ?? 'Створити'}}</a>
    @endif
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{auth()->user()}} </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><hr class="dropdown-divider"/></li>
                <li class="dropdown">
                    <button type="button" class="btn btn-sm">
                        lohout
                    </button>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion nav1" id="sidenavAccordion">
            <div class="sb-sidenav-menu" style="overflow-y: auto; overflow-x: hidden;">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading m-2">Core</div>
                    <ul class="nav nav-pills flex-column m-3">
                        <li>
                            <a class="dropdown-toggle nav-link collapsed text-white-50" href="#" data-bs-toggle="collapse" data-bs-target="#itemsnav" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Продукція
                            </a>
                            <div style="padding-left:20px;" class="collapse 
                                {{$title=='Вироби'|| 
                                $title=='Закуп' ||  
                                $title=='Вартість' ||
                                $title=='Категорії'
                                ?'show':''}}" 
                                id="itemsnav" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$title=='Вироби'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/items">
                                        Вироби
                                    </a>
                                    <a class="nav-link {{$title=='Вартість'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/cost">
                                        Собівартість
                                    </a>
                                </nav>
                            </div>
                        </li>

                        <hr class="nav-hr">
                        <a class="nav-link {{$title=='Закуп'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/purchases">
                            Закуп
                        </a>
                        
                        <hr class="nav-hr">
                        <li>
                            <a class="dropdown-toggle nav-link collapsed text-white-50" href="#" data-bs-toggle="collapse" data-bs-target="#cehs" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Цехи
                            </a>
                            <div style="padding-left:20px;"class="collapse {{$title=='Типи цехів'||$title=='Цехи'?'show':''}}" id="cehs" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$title=='Типи цехів'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/cehtypes">
                                        Типи
                                    </a>
                                    <div class="w-100"></div>
                                    <a class="nav-link {{$title=='Цехи'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/cehs">
                                        Цехи
                                    </a>
                                </nav>
                            </div>
                        </li>

                        <li>
                            <a class="dropdown-toggle nav-link collapsed text-white-50" href="#" data-bs-toggle="collapse" data-bs-target="#workers" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Робітники
                            </a>
                            <div style="padding-left:20px;"class="collapse {{$title=='Робітники'|| $title=='Посади' || $title=='ЗП'?'show':''}}" id="workers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$title=='Робітники'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/workers">
                                        Робітники
                                    </a>
                                    <a class="nav-link {{$title=='Посади'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/worktypes">
                                        Посади
                                    </a>
                                    <div class="w-100"></div>
                                    <a class="nav-link {{$title=='ЗП'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/pay">
                                        ЗП
                                    </a>
                                </nav>
                            </div>
                        </li>
                        <hr class="nav-hr">

                        <a class="dropdown-toggle nav-link collapsed text-white-50" href="#" data-bs-toggle="collapse" data-bs-target="#movement" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Рух
                        </a>
                        <div style="padding-left:20px;"class="collapse {{$title=='Рух'|| $title=='Залишки' || $title=='Виробіток' ? 'show' : ''}}" id="movement" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{$title=='Рух'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/movement">
                                    Переміщення
                                </a>
                                <a class="nav-link {{$title=='Залишки'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/remains">
                                    Залишки
                                </a>
                                <a class="nav-link {{$title=='Виробіток'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/production">
                                    Виробіток
                                </a>
                            </nav>
                        </div>
                        <hr class="nav-hr">
                        <li>
                            <a class="dropdown-toggle nav-link collapsed text-white-50" href="#" data-bs-toggle="collapse" data-bs-target="#units" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Одиниці
                            </a>
                            <div style="padding-left:20px;" class="collapse {{$title=='Виміри'||$title=='Кольори'||$title=='Сировина'?'show':''}}" id="units" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$title=='Виміри'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/units">
                                        Виміру
                                    </a>
                                    <a class="nav-link {{$title=='Кольори'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/colors">
                                        Кольори
                                    </a>
                                    <a class="nav-link {{$title=='Сировина'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/purchases/materials">
                                        Цех сировини
                                    </a>
                                    <a class="nav-link {{$title=='Категорії'?'text-bold text-warning':'text-white-50 link-body-emphasis'}}" href="/categoryes">
                                        Категорії
                                    </a>
                                </nav>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>