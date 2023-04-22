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
    New Area
@endsection
@section('bage-header')
    New Area
@endsection

@section('content')
    @include('layouts.errors')
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('areas.index') }}" class="btn btn-primary">Back</a>
                </div>
                <form method="POST" action="{{ route('areas.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div id="">
                            <div class="row">
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Area Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="firstname" name="area_name" placeholder="Enter Area Name"
                                        required="" type="text">
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

