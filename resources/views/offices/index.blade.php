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
    مكاتب شركتنا
@endsection
@section('bage-header')
    مكاتب شركتنا
@endsection
@section('content')
    @include('layouts.sessions')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('offices.create') }}" class="btn btn-primary">أضافة مكتب جديد</a>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">المكتب</th>
                                                <th class="border-bottom-0">رقم الهاتف</th>
                                                <th class="border-bottom-0">الصندوق</th>
                                                <th class="border-bottom-0">عدد الموظفين بالمكتب</th>
                                                <th class="border-bottom-0">الاعدادات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Office::all() as $office)
                                                <tr>
                                                    <td>{{ $office->office_name }}</td>
                                                    <td>{{ $office->office_phone }}</td>
                                                    <td>{{ $office->budget }}</td>
                                                    <td>{{ $office->employees->count() }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary" type="button"
                                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                {{-- <li><a class="dropdown-item text-success"
                                                                        href="{{ route('offices.show', $office->id) }}">Show</a>
                                                                </li> --}}
                                                                <li><a class="dropdown-item text-primary"
                                                                        href="{{ route('offices.edit', $office->id) }}">Edit</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
