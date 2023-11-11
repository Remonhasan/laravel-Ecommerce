@extends('frontend.layouts.userMaster')

@section('page_title')
    Profile | nDolish
@endsection

@section('user-profile-content')

    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <h1> Welcome ! {{ Auth::user()->name }}</h1>
@endsection
