@extends('frontend.layouts.master')

@section('page_title')
    Cart | nDolish
@endsection

@section('main-content')
    <h1> Customer Cart Page !</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
@endsection
