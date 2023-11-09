@extends('frontend.layouts.userMaster')

@section('page_title')
    Shipping Address | nDolish
@endsection

@section('main-content')
    <h1> Welcome ! Shipping Address Page</h1>
    <div class="row">
        <div class="col-12">
            <div class="box_main">
                <form action="{{ route('add.shipping') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="phone-number">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>
                    <div class="form-group">
                        <label for="address">City/Division</label>
                        <input type="text" class="form-control" name="city">
                    </div>
                    <div class="form-group">
                        <label for="address">Street/Address</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="form-group">
                        <label for="postal-code">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code">
                    </div>

                    <input type="submit" value="next" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection