@extends('frontend.layouts.userMaster')

@section('page_title')
    Profile | nDolish
@endsection

@section('user-profile-content')
    <h1> Welcome ! {{ Auth::user()->name }}</h1>
@endsection
