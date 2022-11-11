@extends('layouts.admin')
@section('page-title')
    {{__('Sales online')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Report')}}</li>
    <li class="breadcrumb-item">{{__('Sales online')}}</li>
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@push('script-page')
    {{--    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>
    {{--    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>--}}
    {{--    <script type="text/javascript" src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>--}}

    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();

        }



    </script>
@endpush

@section('action-btn')
    <div class="float-end">
        <a target="_blank" href="?status={{$request->status}}&print=1" class="btn btn-info btn-sm">
            <i class="fa fa-print"></i>
            Imprimir
        </a>

        <a target="_blank" href="?status={{$request->status}}&export=pdf" class="btn btn-danger btn-sm">
            <i class="fa fa-file-pdf"></i>
            PDF
        </a>

        <a target="_blank" href="?status={{$request->status}}&export=excel" class="btn btn-success btn-sm">
            <i class="fa fa-file-excel"></i>
            Excel
        </a>
    </div>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('reports.salesOnline'),'method'=>'get')) }}
                            <div class="row align-items-center">
                                <div class="col-xl-1">
                                    <div class="row">
                                        <label for="status">{{__('Status')}}</label>
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="row">
                                        {{ Form::select('status', ['' => '', 'Abierto' => 'Abierto', 'Aceptado' => 'Aceptado', 'Entregado' => 'Entregado', 'Finalizado' => 'Finalizado'], $request->status, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-xl-2 m-2">
                                    <div class="row">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Order')}}</th>
                                <th>{{__('Customer')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Status')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{$sale->pos_date}}</td>
                                    <td>{{$sale->pos_id}}</td>
                                    <td>{{$sale->customer->name}}</td>
                                    <td>{{$sale->posPayment->amount}}</td>
                                    <td>{{$sale->order_status}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
