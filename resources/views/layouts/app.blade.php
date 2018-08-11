<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PKO</title>
    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">TALES OF PIRATES</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('downloads')}}">Downloads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container-fluid">
    <main class="py-4">

        <div class="row">
            <div class="col-md-3">


                @auth
                    @if(isset($user))
                        <div style="margin-bottom: 20px !important;" class="card">
                            <div class="card-header">
                                Account
                            </div>
                            <div class="card-body">
                                <ul style="margin-bottom: 10px !important;" class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$user[0]->account->act_name}}
                                    </li>
                                </ul>

                                <hr>
                                <ul style="margin-bottom: 10px !important;" class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Mall Points
                                        <span class="badge badge-primary badge-pill">{{$user[0]->account->mall_points}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Credit Points
                                        <span class="badge badge-primary badge-pill">{{$user[0]->account->credits}}</span>
                                    </li>
                                </ul>
                                <hr>
                                <ul class="list-unstyled">

                                    <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                           href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>


                                </ul>
                            </div>
                        </div>
                    @endif
                @endauth

                <div style="margin-bottom: 20px !important;" class="card">
                    <div class="card-header">
                        Quick Links
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @guest
                                <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                       href=" {{ url('/login') }}"> Login</a></li>
                                <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                       href=" {{ url('/register') }} "> Register</a></li>
                            @endguest

                            <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                   href=" {{ url('/downloads') }} "> Downloads </a></li>
                            <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                   href=" {{ url('/contactus') }} "> Contact us </a></li>

                            @auth
                                <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                       href=" {{ url('/mall') }} "> Mall</a></li>

                                    <li><a style="margin-bottom: 10px; width: 100%;" class="btn btn-outline-info"
                                           href=" {{ route('storage.index')}} "> Storage box </a></li>

                            @endauth
                        </ul>
                    </div>
                </div>
                <div style="margin-bottom: 20px !important;" class="card">
                    <div class="card-header">
                        Server Statistics
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li> Accounts : <span> {{ $statistics['accounts'] }} </span></li>
                            <li> Characters : <span> {{ $statistics['characters'] }} </span></li>
                            <li> Guilds : <span>{{ $statistics['guild'] }} </span></li>
                            <li> Current Online : <span> {{ $statistics['online'] }} </span></li>
                            <li> Online record : <span> {{ $statistics['max_online'] }} </span></li>
                        </ul>
                    </div>
                </div>
                <div style="margin-bottom: 20px !important;" class="card">
                    <div class="card-header">
                        Server Information
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li> Solo EXP Rate : <span> {{ env('SOLO_EXP') }}x </span></li>
                            <li> Party EXP Rate : <span> {{ env('PARTY_EXP') }}x </span></li>
                            <li> Drop Rate : <span> {{ env('DROP_RATE') }}x  </span></li>
                            <li> Ship EXP Rate : <span> {{ env('SHIP_EXP')}}x  </span></li>
                        </ul>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                @yield('content')
            </div>


            <div class="col-md-3">

                <div style="margin-bottom: 20px !important;" class="card">
                    <div class="card-header">Staff Online</div>

                    <div class="card-body">

                        @if(count($onlineGMChars) > 0)
                            @foreach($onlineGMChars as $char)
                                <div class="float-left"> {{ $char['name'] }} </div>
                                <div class="float-right text-{{$char['type']}}"> {{ $char['status'] }} </div> <br/>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
<!-- Bootstrap core JavaScript -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
@yield('js')
</body>
</html>
