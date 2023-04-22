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
    الحركات المالية
@endsection
@section('bage-header')
    الحركات المالية
@endsection
@section('content')
    @include('layouts.sessions')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">القائم بالعملية</th>
                                                <th class="border-bottom-0">نوع العملية</th>
                                                <th class="border-bottom-0">الي</th>
                                                <th class="border-bottom-0">قيمة العملية</th>
                                                <th class="border-bottom-0">قيمة الصندوق قبل العملية</th>
                                                <th class="border-bottom-0">قيمة الصندوق بعد العملية</th>
                                                <th class="border-bottom-0">الاعدادات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Transaction::all() as $move)
                                                <tr>
                                                    <td>{{ $move->from }}</td>
                                                    <td>
                                                        @if ($move->new_budget < $move->old_budget)
                                                            <span class="badge bg-danger text-light">عملية دفع</span>
                                                        @else
                                                            <span class="badge bg-success text-light">عملية تحصيل</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $move->to }}</td>

                                                    <td>{{ $move->old_budget - $move->new_budget }}</td>
                                                    <td>{{ $move->old_budget }}</td>
                                                    <td>{{ $move->new_budget }}</td>
                                                    <td>{{ $move->details }}</td>
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
