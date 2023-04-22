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
    مكتب جديد
@endsection
@section('bage-header')
    مكتب جديد
@endsection

@section('content')
    @include('layouts.errors')
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('offices.index') }}" class="btn btn-primary">الرجوع</a>
                </div>
                <form method="POST" action="{{ route('offices.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div id="">
                            <div class="row">
                                <div class="form-floating mb-3">
                                    <input type="text" name="office_name" class="form-control" id="floatingInput"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">المكتب</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-floating">
                                    <input type="office_phone" name="office_phone" class="form-control" id="floatingPassword"
                                        placeholder="Password">
                                    <label for="floatingPassword">رقم تليفون المكتب</label>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md col-lg text-center">
                                    <button class="btn btn-success">حفظ</button>
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
