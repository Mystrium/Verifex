<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>@charset "UTF-8";
        .fixed-top, .sb-nav-fixed #layoutSidenav #layoutSidenav_nav, .sb-nav-fixed .sb-topnav {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 30;
        }

        #layoutSidenav #layoutSidenav_nav {
            flex-basis: 180px;
            flex-shrink: 0;
            transition: transform 0.15s ease-in-out;
            z-index: 1038;
            transform: translateX(-180px);
        }

        #layoutSidenav #layoutSidenav_content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            flex-grow: 1;
            margin-left: -180px;
        }

        @media (min-width: 992px) {
            #layoutSidenav #layoutSidenav_nav { transform: translateX(0); }
            #layoutSidenav #layoutSidenav_content {
                margin-left: 0;
                transition: margin 0.15s ease-in-out;
            }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {transform: translateX(-180px); }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content { margin-left: -180px; }
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content:before {display: none; }
        }

        .sb-nav-fixed .sb-topnav {  z-index: 1039; }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
            width: 180px;
            height: 100vh;
            z-index: 1038;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 195px;
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

        .nav1 { background-color: #3d3f45 }
        .nav2 { background-color: #2b2b2b }

        .nav-hr {
            color: rgba(255, 255, 255, .5);
            width: 180px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input { opacity: 0; }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider { background-color: #2196F3; }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        .slider.round { border-radius: 34px; }

        .slider.round:before { border-radius: 50%; }

        .nav-tabs .nav-item .nav-link.active { color: orange; }
        .nav-tabs .nav-item .nav-link { 
            color: black;  
            border-top: 1px solid darkgray;
            border-left: 0.5px solid darkgray;
            border-right: 0.5px solid darkgray;
        }
        .nav-tabs .nav-item .nav-link:not(.active){ 
            color: black;  
            border-top: 1px solid lightgray;
            border-left: 0.5px solid lightgray;
            border-right: 0.5px solid lightgray;
        }
        .nav-tabs { border-bottom: 2px solid darkgray; }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>