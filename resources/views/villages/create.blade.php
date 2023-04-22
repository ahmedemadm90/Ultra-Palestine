@extends('layouts.app')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('footer')
    @include('layouts.footer')
@endsection
@section('title')
    New Village
@endsection
@section('bage-header')
    New Village
@endsection

@section('content')
    @include('layouts.errors')
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('villages.index') }}" class="btn btn-primary">Back</a>
                </div>
                <form method="POST" action="{{ route('villages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div id="">
                            <div class="row ">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Area: <span class="tx-danger">*</span></label>
                                    <select name="area_id" id="area"
                                        class="form-control select2-single text-capitalize" required>
                                        <option selected hidden disabled>Choose Area</option>
                                        @foreach (App\Models\Area::all() as $area)
                                            <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                                            <hr>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Village Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="village" name="village_name"
                                        placeholder="Enter Village Name" required="" type="text">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Delivery Cost: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="delivery_cost" name="delivery_cost"
                                        placeholder="Enter Deliver Cost" required="" type="number">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md col-lg text-center">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!--/Row-->
@endsection
