@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-md-3">
            <div  style="margin-bottom: 20px !important;" class="card">
                <div class="card-header">
                    Quick Links
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @guest
                        <li>    <a href=" {{ url('/login') }}" > Login</a> </li>
                        <li>    <a href=" {{ url('/register') }} ">   Register</a>  </li>
                        @else

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                        @endguest

                        <li>    <a href=" {{ url('/downloads') }} "> Downloads </a> </li>
                        <li>    <a href=" {{ url('/ranking') }} "> Rankings </a> </li>
                        <li>    <a href=" {{ url('/contactus') }} "> Contact us </a> </li>
                    </ul>
                </div>
            </div>
            <div style="margin-bottom: 20px !important;" class="card">
                <div class="card-header">
                    Server Statistics
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>   Solo EXP Rate : <span> {{ env('SOLO_EXP') }}x </span> </li>
                        <li>   Party EXP Rate : <span> {{ env('PARTY_EXP') }}x </span> </li>
                        <li>   Drop Rate : <span> {{ env('DROP_RATE') }}x  </span> </li>
                        <li>   Ship EXP Rate : <span> {{ env('SHIP_EXP')}}x  </span> </li>
                    </ul>
                </div>
            </div>
            <div style="margin-bottom: 20px !important;" class="card">
                <div class="card-header">
                    Server Information
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>   Solo EXP Rate : <span> {{ env('SOLO_EXP') }}x </span> </li>
                        <li>   Party EXP Rate : <span> {{ env('PARTY_EXP') }}x </span> </li>
                        <li>   Drop Rate : <span> {{ env('DROP_RATE') }}x  </span> </li>
                        <li>   Ship EXP Rate : <span> {{ env('SHIP_EXP')}}x  </span> </li>
                    </ul>
                </div>
            </div>


        </div>
        <div  class="col-md-6">
            <div style="margin-bottom: 20px !important;" class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>


        <div class="col-md-3">

            <div style="margin-bottom: 20px !important;" class="card">
                <div class="card-header">Staff Online</div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>




@endsection
