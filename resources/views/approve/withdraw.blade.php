@extends('layouts.admin')

@section('page-bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/withdraw.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/withdraw.approve')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('approve/withdraw.withdraw')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{trans('approve/withdraw.withdraw')}} <small>{{trans('approve/withdraw.approve')}}</small></h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
@endsection

@section('contents')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>{{trans('approve/withdraw.approve')}} {{trans('approve/withdraw.withdraw')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content">
                    <tr>
                        <th class="text-center" width="5%"> # </th>
                        <th class="text-center"> {{trans('approve/withdraw.request_date')}}</th>
                        <th class="text-center"> {{trans('approve/withdraw.name')}} </th>
                        <th class="text-center"> {{trans('approve/withdraw.userid')}} </th>
                        <th class="text-center"> {{trans('approve/withdraw.bank_ifsc')}} </th>
                        <th class="text-center"> {{trans('approve/withdraw.bank_account')}} </th>
                        <th class="text-center"> {{trans('approve/withdraw.avail_balance')}} </th>
                        <th class="text-center"> {{trans('approve/withdraw.amount_usd')}} </th>
                        {{--<th class="text-center"> {{trans('approve/withdraw.status')}} </th>--}}
                        <th class="text-center" width="10%"> {{trans('approve/withdraw.Action')}} </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($operations as $withdraw)
                            <tr data-code="{{ $withdraw->id }}">
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td> {{ $withdraw->created_at }}</td>
                                <td> {{$withdraw->user->full_name}} </td>
                                <td> {{$withdraw->user->username}} </td>
                                <td> {{$withdraw->user->profile->ifsc_code}} </td>
                                <td> {{$withdraw->user->profile->bank_account_no}} </td>
                                <td> {{ number_format($withdraw->user->inr, 2) }} </td>
                                <td class="numeric"> {{ number_format($withdraw->destination_amount, 2) }} </td>
                                <td class="text-center" width="15%">
                                    <button name="approve" class="btn btn-success btn-sm" title="Approve">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button name="reject" class="btn btn-danger btn-sm"  title="Reject">
                                        <i class="fa fa-times"></i> 
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection
@push('js')
<script>
    $(document).ready(function(){
       $('button[name=approve]').click(function () {
           var result = window.prompt('Enter transaction reference no please!');
           if(result) {
               var code = $(this).closest('tr').data('code');
               var data = {
                   reference_no: result,
                   code: code
               };
               debugger;
               $.ajax({
                   url:'/admin/approval/withdraw/approve',
                   type:'post',
                   data:data,
                   dataType:'json',
                   success: function (result) {
                        if(result.status) {
                            alert(result.message);
                        } else {
                            alert(result.message);
                        }
                       location.href='/admin/approval/withdraw';
                   },
                   error: function (result) {
                       console.log(result);
                   }
               })
           } else {
               alert('Transaction can\'t be approved without transaction reference no');
           }
       });

        $('button[name=reject]').click(function () {

            var result = window.prompt('Enter reason of decline!');
            if(result) {
                var code = $(this).closest('tr').data('code');
                var data = {
                    reason: result,
                    code:code
                };
                $.ajax({
                    url:'/admin/approval/withdraw/reject',
                    type:'post',
                    data:data,
                    dataType:'json',
                    success: function (result) {
                        if(result.status) {
                            alert(result.message);
                        } else {
                            alert(result.message);
                        };
                        location.href='/admin/approval/withdraw';
                    }
                })
            } else {
                alert('We can\'t reject transaction without reason');
            }
        });
    });
</script>
@endpush
