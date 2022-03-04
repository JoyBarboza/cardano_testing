@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('transaction/index.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('transaction/index.transaction')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('transaction/index.transaction')}}
    <small>{{trans('transaction/index.management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
           <!--  <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">{{trans('transaction/index.search_by')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
                    <form role="form" method="get" action="{{ route('admin.transaction.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{trans('transaction/index.transaction_date_between')}}:</label>
                                <div class="input-group date-picker input-daterange">
                                    <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                    <span class="input-group-addon">{{trans('transaction/index.to')}}</span>
                                    <input type="text" class="form-control" name="to_date" value="{{ request()->to_date }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('transaction/index.transaction_id')}}:</label>
                                <input type="text" name="transaction_id" value="{{ request()->transaction_id }}" class="form-control" placeholder="{{trans('transaction/index.enter_user_info')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('transaction/index.user')}}:</label>
                                <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('transaction/index.enter_user_info')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('transaction/index.currency')}}:</label>
                                <select name="currency" class="form-control">
                                    <option value="">-- {{trans('transaction/index.select_currency')}} --</option>
                                    @foreach($currencies as $key => $value)
                                        <option value={{ $key }} {{ (request()->currency == $key)?'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('transaction/index.transaction_type')}}:</label>
                                <select name="type" class="form-control">
                                    <option value="">-- {{trans('transaction/index.select_type')}} --</option>
                                    <option value="Debit" {{ (request()->type == 'Debit')?'selected':'' }}>{{trans('transaction/index.debit')}}</option>
                                    <option value="Credit" {{ (request()->type == 'Credit')?'selected':'' }}>{{trans('transaction/index.credit')}}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('transaction/index.search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> -->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('transaction/index.user_mransaction_management')}}</span>
                  
                    </div>
                    {{ $bnb_transaction->links() }}
                </div>
                <div class="portlet-body">
					<!-- <span class="export pull-right text-danger" style="cursor:pointer;"> {{ __('Export in Excel') }}</span> -->
		
					<!-- <p>
						Total Deposit Amount : {{ $total_deposit_amount }} USD <br>
						Deposit Amount : {{ $approve_deposit_amount }} USD <br>
						
						Buy {{ env('TOKEN_SYMBOL') }} Amount : {{ $buy_time_amount }} {{ env('TOKEN_SYMBOL') }} <br>
						Debit USD Amount ( Buy {{ env('TOKEN_SYMBOL') }} ) : {{ $debit_for_buy_time_amount }} USD <br>
						Total Withdraw Amount : {{ $total_withdraw_amount }} {{ env('TOKEN_SYMBOL') }} <br>
						Approved Withdraw Amount : {{ $approved_withdraw_amount }} {{ env('TOKEN_SYMBOL') }} <br>
						
					</p> -->
                    <div class="table-scrollable table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th>{{trans('transaction/index.date')}}</th>
                                    <th>{{trans('transaction/index.transaction_id')}}</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">{{trans('transaction/index.coin')}}</th>
                                    <th class="text-center">{{trans('transaction/index.type')}}</th>
                                    <th class="text-center">{{trans('transaction/index.amount')}}</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Status</th> -->
                                    <th>S.No</th>
                                    <th>Txn Hash</th>
                                    <th >Type</th>
                                    <th >CSM Token</th>
                                    <th >BNB Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @forelse($bnb_transaction as $transaction)
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td>

                                        @if($transaction->type == 'buy')
                                            @php echo "Buy"; @endphp
                                        @elseif($transaction->type == 'buy_nft')
                                            @php echo "Buy NFT"; @endphp
                                        @elseif($transaction->type == 'resell_nft')
                                            @php echo "Resell NFT"; @endphp
                                        @elseif($transaction->type == 'stake_amount')
                                            @php echo "Stake Amount"; @endphp
                                        @elseif($transaction->type == 'unstake_amount')
                                            @php echo "Ustake amount"; @endphp
                                        @endif
                                    </td>
                                    <td>{{ $transaction->csm_amount }}</td>
                                    <td>{{ $transaction->eth_amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d h:i:s')}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger">{{trans('transaction/index.no_transaction_exists')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dialog" class="modal" role="dialog"></div>
@endsection
@push('css')
<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script>
    $('.date-picker').datepicker({
        orientation: "bottom",
        autoclose: true
    });

    $(document).ready(function(){

        $('.getdetails').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/transactionDetails/'+id,
                dataType:'html',
                beforeSend: function () {
                    // $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {

                }
            });
        });
    });
    
    var url = baseURL;
    $(document).ready(function(){
		$('span.export').click(function() {

            var formData = $('form[name=search]').serialize(); 
            var file_path = url + 'admin/transaction?' + formData + '&export=true';  
            var a = document.createElement('A');
            a.href = file_path; 

            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

        });
        
        
    });
</script>
@endpush
