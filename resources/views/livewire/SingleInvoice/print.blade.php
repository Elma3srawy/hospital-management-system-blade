@extends('Dashboard.layouts.master')
@section('title')
    طباعه الفواتير
@stop
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعه الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتوره خدمه مفرده</h1>
                            <div class="billed-from">
                                <h6>فاتوره خدمه مفرده</h6>
                                <p>201 المهندسين<br>
                                    Tel No: 0111111111<br>
                                    Email: Admin@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">

                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتوره</label>
                                <p class="invoice-info-row"><span>اسم الخدمه</span> <span>{{$single_invoice->service_name}}</span></p>
                                <p class="invoice-info-row"><span>اسم المريض</span> <span>{{$single_invoice->patient_name}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الفاتوره</span> <span>{{ $single_invoice->invoice_date }}</span></p>
                                <p class="invoice-info-row"><span>الدكتور</span> <span></span>{{ $single_invoice->doctor_name }}</p>
                                <p class="invoice-info-row"><span>القسم</span> <span></span>{{ $single_invoice->section_name}}</p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">اسم الخدمه</th>
                                    <th class="tx-center">سعر الخدمه</th>
                                    <th class="tx-right">نوع الفاتوره</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">{{ $single_invoice->service_name }}</td>
                                    <td class="tx-center">{{ $single_invoice->price }}</td>
                                    <td class="tx-right">{{$single_invoice->type == 1 ? 'نقدي' : 'اجل'}}</td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13"></label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">الاجمالي</td>
                                    <td class="tx-right" colspan="2"> {{number_format($single_invoice->price, 2)}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">قيمة الخصم</td>
                                    <td class="tx-right" colspan="2">{{$single_invoice->discount_value}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">نسبة الضريبة</td>
                                    <td class="tx-right" colspan="2">% {{$single_invoice->tax_rate}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبه</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{number_format($single_invoice->total_with_tax, 2)}}</h4>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i>طباعه
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('Admin/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
