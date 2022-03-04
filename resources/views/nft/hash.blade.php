@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('nft.hash')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="rows">
        <h1 class="main_heading">{{trans('transaction/user-list.Transaction')}}</h1>
        @include('flash::message')
            <div class="box box-inbox">
            <div class="panel">
                    <div class="panel-body">
                        <div class="table-responsive table-scrollable">
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                    <th>S.No</th>
                                    <th>Txn Hash</th>
                                    <th >Type</th>
                                    <th >CSM Token</th>
                                    <th >BNB Amount</th>
                                    <th>Date</th>
                                    <!-- <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @forelse($mint as $transaction)
                                <tr>
                                    <!-- <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>  2021-12-07 5:52:11 -->
                                    <td>{{ $i++}}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td>{{ $transaction->csm_amount }}</td>
                                    <td>{{ $transaction->eth_amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d h:i:s')}}</td>
                                    <!-- <td><span class="text-success">Success</span></td> -->
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No Transaction</td>
                                </tr>
                            @endforelse
                            </tbody>
                            
                        </table>
                        <div class="portlet-footer">
                                <span class="text-right">{{ $mint->links() }}</span>
                            </div>
                    </div>
                    
                        
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.stack.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.crosshair.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.axislabels.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.time.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ asset('assets/pages/scripts/charts-flotcharts.js') }}?v={{time()}}" type="text/javascript"></script> 
    <!-- END PAGE LEVEL SCRIPTS -->
    
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<script type="text/javascript">
				
</script>
@endpush
