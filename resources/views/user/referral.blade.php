@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('setting/presalelist.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('user/referral.Referral')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('user/referral.Referral')}}
    <small>{{trans('setting/presalelist.list')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">{{trans('transaction/index.search_by')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
                    <form role="form" method="get" action="{{ route('admin.user.referral') }}">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="">User Email:</label>
                                <input type="text" name="user_email" value="{{ request()->user_email }}" class="form-control" placeholder="Search by Email">
                            </div>
                            <div class="col-md-4">
                                <label for="">Sponser Email:</label>
                                <input type="text" name="sponser_email" value="{{ request()->sponser_email }}" class="form-control" placeholder="Search by Email">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('transaction/index.search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('user/referral.Manage_Referral')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{trans('user/referral.Registration_Date')}}</th>
                                <th>User Email</th>
                                <th>Sponsor Email</th>
                                <th>{{trans('user/referral.Referral_Code')}}</th>
                                <th>{{trans('user/referral.Bonus_Got')}} (TIME)</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->referredBy)?$user->referredBy->email:'' }}</td>
                                        <td>{{ $user->referral }}</td>
                                        <td>{{ number_format($user->referredBy->getReferralBonus($user->username), 8) }}</td> 
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">{{trans('setting/presalelist.no_transaction_exists')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
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

                $('a[title=Delete]').click(function(event){
                    event.preventDefault();

                    var url = $(this).attr('href');

                    bootbox.confirm('Are you sure you want to delete this sale?', function(result){
                        if(result) {
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {_method:'DELETE'},
                                success: function( result ) {
                                    if(result.status){
                                        row.remove();
                                    }
                                    bootbox.alert(result.message);
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
