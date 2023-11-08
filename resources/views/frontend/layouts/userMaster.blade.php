@extends('frontend.layouts.master')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4" style="margin-top: 100px">
                <div class="box_main">
                    <ul>
                        <li><a href="{{ route('user.profile') }}">Dashboard</a></li>
                        <li><a href="{{ route('user.pendingOrder') }}">Pending Orders</a></li>
                        <li><a href="{{ route('user.history') }}">History</a></li>
                        <li><a href="">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8" style="margin-top: 100px">
                <div class="box_main">
                    @yield('user-profile-content')
                </div>
            </div>
        </div>
    </div>
@endsection
