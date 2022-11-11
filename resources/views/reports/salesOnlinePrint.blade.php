<style>
    table,
    tr,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

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

@if($request->print)
    <script>
        window.print();
    </script>
@endif