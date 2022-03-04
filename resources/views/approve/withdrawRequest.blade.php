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
            <span>{{trans('approve/withdraw_request.withdraw_request')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('approve/withdraw_request.withdraw')}}
    <small> {{trans('approve/withdraw_request.Request')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">{{trans('approve/withdraw_request.withdraw')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
					@include('flash::message')
                    <form name="search" method="get" action="{{route('admin.approval.withdraw')}}">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<label class="control-label">{{trans('approve/withdraw_request.withdraw_request_between')}}</label>
						<div class="input-group">
							<input type="date" class="form-control" name="from_date" value="{{request()->from_date}}">
							<span class="input-group-addon">{{trans('approve/withdraw_request.to')}}</span>
							<input type="date" class="form-control" name="to_date" value="{{request()->to_date}}">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<label class="control-label">{{trans('approve/withdraw_request.withdraw_approve_between')}}</label>
						<div class="input-group">
							<input type="date" class="form-control" name="from_approve_date" value="{{ request()->from_approve_date}}">
							<span class="input-group-addon">{{trans('approve/withdraw_request.to')}}</span>
							<input type="date" class="form-control" name="to_approve_date" value="{{ request()->to_approve_date }}">
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<label for="user" class="control-label">{{trans('approve/withdraw_request.email')}}</label>
						<input type="text" name="user" value="{{ request()->user }}" class="form-control"/>
					</div>
					
					
					<div class="col-md-4 col-sm-4 form-group">
						<label class="control-label">{{trans('approve/withdraw_request.status')}}</label>
						<select name="status" id="status" class="form-control">
							<option value="">{{trans('approve/withdraw_request.all')}}</option>
							<option value="0" @if (old('status') == "0" || (request()->status) == "0") selected="selected" @endif >{{ __('Pending') }}</option>
							<option value="1" @if (old('status') == "1" || (request()->status) == "1") selected="selected" @endif  >{{ __('Approved') }}</option>
							<option value="2" @if (old('status') == "2" || (request()->status) == "2") selected="selected" @endif  >{{ __('Declined') }}</option>
						</select>
					</div>
					
					<div class="col-md-4 col-sm-4 form-group">
						<label class="control-label" for="">{{trans('approve/withdraw_request.Payment_method')}}</label>
						<select name="currency" class="form-control">
							<option value="">{{trans('approve/withdraw_request.all')}}</option>
							 @forelse($currencies as $currency) 
							 <option value={{ $currency->id }} @if (old('currency') == $currency->id || (request()->currency) == $currency->id) selected="selected" @endif>{{ $currency->description }}</option>
							 @empty
							 
							 @endforelse  
							
						</select>
						
					</div>
					
					<div class="col-md-4 col-sm-4 form-group">
						<label class="control-label">&nbsp;</label>
						<button type="submit" class="btn btn-block btn-warning btn-flat " name="search" value="true">{{trans('approve/withdraw_request.Search')}}</button>
					</div>
				</div>
			</form>				
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('approve/withdraw_request.withdraw_request')}}</span>
                    </div>
             
                </div>
                <div class="portlet-body">
					<span class="export pull-right text-danger" style="cursor:pointer;"> {{ __('Export in Excel') }}</span>
		
                    <div class="table-scrollable">
                        @php
					$status = [0=>'pending',1=>'approved',2=>'declined'];
				@endphp

			<table class="table row-border info-data-table table-hover dataTable no-footer table-responsive">
				<thead>
					<tr>
						<th> # </th>
						<th> {{trans('approve/withdraw_request.req_date')}}</th>
						<th> {{trans('approve/withdraw_request.email')}}</th>
						<th>{{trans('approve/withdraw_request.Amount')}} ({{env('TOKEN_NAME')}})</th>
						<th>{{trans('approve/withdraw_request.Fees')}} ({{env('TOKEN_NAME')}})</th>
						<th>{{trans('approve/withdraw_request.Net_amount')}} ({{env('TOKEN_NAME')}})</th>
						<th> {{trans('approve/withdraw_request.Method')}} </th>
						<th class="text-center"> {{trans('approve/withdraw_request.Address')}} </th>
						<th class="text-center"> {{trans('approve/withdraw_request.T_hash')}} </th>
						<th> {{trans('approve/withdraw_request.status')}} </th>
						<th class="text-center"> {{trans('approve/withdraw_request.Action')}}</th>
					</tr>
				</thead>
				<tbody>
						@forelse($withdraws as $withdraw)
						<tr data-code="{{ $withdraw->transaction_id }}">
							<td>{{ $loop->iteration }}</td>
							<td> {{ $withdraw->created_at }}</td>
							<td> {{$withdraw->email}} </td>
							<td>{{$withdraw->amount}}</td>
							<td>{{$withdraw->fees}}</td>
							<td>{{$withdraw->net_amount}}</td>
							<td>{{ $withdraw->coin_description}} </td>
							<td class="text-center">{{ $withdraw->address }}</td>
							<td>{{ $withdraw->t_hash }}	</td>
							
							<td> {{ $status[$withdraw->status] }} </td>
							<td>
								@if(!in_array($withdraw->status, [1,2]))
									<button name="approve" class="btn btn-success btn-sm" title="Approve(Manual)">
										<i class="fa fa-check"></i>
									</button>
									<!--<button name="approve_automatic" class="btn btn-warning btn-sm" title="Approve(Automatic)">
										<i class="fa fa-check"></i>
									</button>-->
									<button name="reject" class="btn btn-danger btn-sm"  title="Reject">
										<i class="fa fa-ban"></i>
									</button>
								@else
									{{trans('approve/withdraw_request.done_at')}} - {{ $withdraw->updated_at }}
								@endif
							</td>
						</tr>
					@empty
                            <tr>
                                <td colspan="11" class="text-center">{{trans('approve/index.no_verification_pending')}}</td>
                            </tr>
					@endforelse
					@if($withdraws->count() > 0)
						<tr>
							<td colspan="11">
								{{ __('Showing') }} {{ $withdraws->firstItem() }} to {{ $withdraws->lastItem() }} of {{ $withdraws->total() }} records <span style="float:right">{{ $withdraws->links() }}</span>
							</td>                    
						</tr>
					@endif
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
<script type="text/javascript">
    $(document).ready(function(){
		var url = $('base').attr('href'); 
		
		$('button[name=approve]').click(function () { 
           var result = window.prompt('{{ __("Enter transaction id please!") }}');
           if(result) {
               var code = $(this).closest('tr').data('code');
               var data = {
                   _token: $('meta[name=csrf-token]').attr('content'),
                   transactionHash: result,
                   code: code
               };
			   $.ajax({
                   url: url + '/admin/approval/withdraw/approve',
                   type:'post',
                   data:data,
                   success: function (result) {
					    res = JSON.parse(result);
                        if(res.status) {
                            alert(res.message);
                        } else {
                            alert(res.message);
                        }
                       location.reload();
                   },
                   error: function (result) { 
                       alert('{{ __("some error occoured!") }}');
                   }
               })
           } else {
               alert('{{ __("Transaction can not be approved without transaction hash") }}');
           }
       });

        $('button[name=reject]').click(function () {

            var result = window.prompt('{{ __("Enter reason of decline!") }}');
            if(result) {
                var code = $(this).closest('tr').data('code');
                var data = {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    reason: result,
                    code:code
                };
				$.ajax({
                    url:url + '/admin/approval/withdraw/reject',
                    type:'post',
                    data:data,
                    success: function (result) {
						res = JSON.parse(result);
                        if(res.status) {
                            alert(res.message);
                        } else {
                            alert(res.message);
                        };
                        location.reload();
                    }
                })
            } else {
                alert('{{ __("We can not reject transaction without reason!") }}');
            }
        });


        
       
    });
    
    var url = baseURL;
    $(document).ready(function(){
		$('span.export').click(function() {

            var formData = $('form[name=search]').serialize(); 
            var file_path = url + 'admin/approval/withdraw?' + formData + '&export=true';  
            var a = document.createElement('A');
            a.href = file_path; 

            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

        });
        
        
    });
</script>
</script>

@endpush
