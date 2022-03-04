@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('approve/deposit.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('approve/deposit.approval_deposit')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('approve/deposit.approval')}}
    <small>{{trans('approve/deposit.management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('approve/deposit.search_by')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.approval.deposit') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label> {{trans('approve/deposit.transaction_date_between')}}:</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="from_date" value="{{request()->from_date}}" autocomplete="off">
                                <span class="input-group-addon"> {{trans('approve/deposit.to')}}</span>
                                <input type="text" class="form-control" name="to_date" value="{{request()->to_date}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{trans('approve/deposit.transaction_id')}}:</label>
                            <input type="text" name="transaction_id" value="{{request()->transaction_id}}" class="form-control" placeholder="{{trans('approve/deposit.enter_user_info')}}">
                        </div>
                        <div class="col-md-3">
                            <label for="">{{trans('approve/deposit.user')}}:</label>
                            <input type="text" name="user_info" value="{{request()->user_info}}" class="form-control" placeholder="{{trans('approve/deposit.enter_user_info')}}">
                        </div>
                        <div class="col-md-2">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('approve/deposit.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('approve/deposit.user_transaction_management')}}</span>
                </div>
                {{ $transactions->links() }}           
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">{{trans('approve/deposit.date')}}</th>
                                <th class="text-center">{{trans('approve/deposit.transaction_id')}}</th>
                                <th class="text-center">{{trans('approve/deposit.email')}}</th>
                                <th class="text-center">{{trans('approve/deposit.amount')}}</th>
                                <th class="text-center">Approved Amount</th>
                                
                                <th class="text-center">Deposit Address</th>
                                <th class="text-center">User Remarks</th>
                                <th class="text-center">{{trans('approve/deposit.approval')}}</th>
                                <th class="text-center">{{trans('approve/deposit.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>
                                    <td class="text-center">{!! !empty($transaction->reference_no)? $transaction->reference_no:'<span class="text-danger">{{trans("approve/deposit.pending")}}</span>' !!} </td>
                                    <td class="text-center">{{ $transaction->user->email }}</td>
                                    <td class="text-right">{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="text-right">{{ number_format($transaction->approved_amount, 2) }}</td>
                                    
                                    <td class="text-right">
										@if($transaction->deposit_coin)
										{{ $transaction->deposit_address.' ( '.$transaction->deposit_coin.' ) ' }}
										@endif
									</td>
                                    <td class="text-right">{{ $transaction->remarks }}</td>
                                    <td class="text-right">{{ $transaction->status }}</td>
                                    <td class="text-center">
                                        @if($transaction->status=='pending')
                                            <button name="approve" data-loading-text="<i class='fa fa-spinner fa-spin '></i>" data-url="{{ route('admin.approval.deposit.approve', $transaction->id) }}" class="btn btn-icon-only green">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button name="reject" data-loading-text="<i class='fa fa-spinner fa-spin '></i>" data-url="{{ route('admin.approval.deposit.reject', $transaction->id) }}" class="btn btn-icon-only red">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @else
                                            <span class="text-danger">{{trans('approve/deposit.not_permited')}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-danger">{{trans('approve/deposit.no_transaction_exists')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script>
    $(document).ready(function(){

        $('.date-picker').datepicker({
            orientation: "bottom",
            autoclose: true
        });

        $('button[name="approve"]').click(function(){
            var url = $(this).data('url'); 
            var row = $(this).closest('tr');
            var _this = $(this);
            var result = window.prompt('{{ __("Enter Approved Amount please!") }}');
            //~ bootbox.confirm('Are you sure you want to approve this transaction reference no "'
                    //~ + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    _this.button('loading');
                    
                    var data = {
					   _token: $('meta[name=csrf-token]').attr('content'),
					   approved_amount: result,
					   
						};
               
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType:'json',
                        data:data,
                        success: function (result) {
                
                            bootbox.alert(result.message);
                            location.reload();
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            //})
        });

        $('button[name="reject"]').click(function(){
            debugger;
            var url = $(this).data('url');
            var row = $(this).closest('tr');
            var _this = $(this);
            bootbox.confirm('Are you sure you want to reject this transaction reference no "'
                    + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    _this.button('loading');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType:'json',
                        success: function (result) {
                            bootbox.alert(result.message);
                            location.reload();
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            })
        });
    });
</script>
@endpush

