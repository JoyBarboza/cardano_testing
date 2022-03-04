@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('dashboard.dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
     {{trans('dashboard.dashboard')}}
    
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="6">0</span>
                    </div>
                    <div class="desc"> USD {{trans('dashboard.BALANCE')}} </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green-soft" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="6">0</span>
                    </div>
                    <div class="desc">USD {{trans('dashboard.DEPOSIT')}} </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue-dark" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="549">0</span>
                    </div>
                    <div class="desc"> USD {{trans('dashboard.WITHDRAW')}}  </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="6">0</span>
                    </div>
                    <div class="desc"> {{env('TOKEN_NAME')}} {{trans('dashboard.DEPOSIT')}} </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-money"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="6">0</span>
                    </div>
                    <div class="desc">{{env('TOKEN_NAME')}} {{trans('dashboard.WITHDRAW')}} </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:void(0)" style="cursor: default">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup">0</span>
                    </div>
                    <div class="desc"> {{trans('dashboard.JOINED_TOTAL')}}</div>
                </div>
            </a>
        </div>
        
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('dashboard.transaction')}}</span>
                        <span class="caption-helper">{{trans('dashboard.daily_stats')}}...</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="chart_2" class="chart"> </div>
                </div>
            </div>
        </div>
    
	
					<div class="col-md-12 col-sm-12">
					 <h3>{{ __('Refer a friend & Earn Money') }}</h3><hr>
		 
						 <form method="post" action="#" />
						 {{ csrf_field() }}
							 <div class="card-widget white">
							 <div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="card-widget white">
										@php $user=auth()->user(); @endphp
										<div class="row margin-top-20">
											<div class="col-md-8">
												<h6 style="display: inline-block;" id="left-code">{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}</h6>
												<a title="{{ __('Copy Link') }}" href="javascript:;" class="mt-clipboard" data-clipboard-action="copy" data-clipboard-target="#left-code">
													<img style="width: 30px; margin-left: 30px;" src="{{ asset('images/link-copy.png') }}" alt="" /> </a> 
												</a>
											</div>
											<div class="col-md-4">
											 <a href="javascript:;" id="leftLink"><img style="width: 30px; margin-right: 10px;" src="https://caesiumlab.com/images/share-link.png" alt="">Share Link</a>
											 <div class="addthis_responsive_sharing" id="leftShare" style="display:none;padding-top:5px;" 
												data-url="{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}"
												data-title="Super Cool Article">
												<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
												<a class="addthis_counter addthis_pill_style"></a>
												
												</div>								
											 </div>
										</div>
										<div class="row margin-top-20">
											<div class="col-md-7">
												<input type="email" name="left" class="form-control" placeholder="{{ __('Beneficiary Email Address') }}" required/>
											</div>
											<div class="col-md-5"><button type="button" class="btn btn-block btn-primary">{{ __('Send Invitation') }}</button></div>
										</div>
										
									 </div>
								</div>
							   
							
							 </div>
							 </div>
						 </form>
		 
					</div>
					
					
				@php 
					$user=auth()->user();
					$getReferralUsers=App\User::where('referred_by',$user->id)->orderBy('id','DESC')->paginate(10);
				@endphp	
					@if(count($getReferralUsers) > 0)
				<div class="col-md-12 col-sm-12">
					<hr><h3 style="margin:10px;">{{ __('Referral List') }}</h3><hr>
							
								<table class="table">
									<thead>
										<tr>
											<th>Joining date</th>
											<th>Name</th>
											<th>Email</th>
										   
										</tr>
									</thead>
									<tbody>
									@forelse($getReferralUsers as $referral)
										<tr>
											<td>{{ $referral->created_at->toDayDateTimeString() }}</td>
											<td>{{ $referral->first_name }}</td>
											<td>{{ $referral->email }}</td>
										 </tr>
									@empty
										<tr>
											<td colspan="3" class="text-center text-danger">No Data Exist</td>
										</tr>
									@endforelse
									</tbody>
									
								</table>
								<div class="col-md-12 col-sm-12">
										<span>{{ __('Showing') }} {{ $getReferralUsers->firstItem() }} {{ __('to') }} {{ $getReferralUsers->lastItem() }} of {{ $getReferralUsers->total() }} {{ __('records') }}</span>
										<span style="float:right;">{{ $getReferralUsers->links() }}</span>
									</div>
					
					</div>
				@endif
				
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
	$('#leftLink').click(function(){
		addthis.update('share', 'url', "{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}");
		addthis.url = "{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}";   
		$(this).hide();
		$('#leftShare').show();     
		          
	});	

							
</script>
<script>
    $(document).ready(function () {
        $('.mt-clipboard').click(function () {
            Command: toastr["success"]("The url is copied to your clipboard.", "Copied");

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });

        $('button.btn-block').click(function () {

            var element = $(this).closest('div.row').find('input');
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(element.val())) {
                Command: toastr["error"]("Email url is not valid", "Mail Sent");
                element.focus;
                return false;
            }

            var data = {
                email: element.val(),
                wing: element.attr('name'),
                _token:element.closest('form').find('input[name=_token]').val()
            }; 
            var route = '{!! route('referral.send') !!}';
            $.ajax({
                url:route,
                type:'post',
                data:data,
                dataType:'json',
                success:function(result) {
                    if(result.status){
                        Command: toastr["success"](result.message, "Mail Sent");
                    } else {
                        Command: toastr["error"]("Email Sending failed", "Mail Sent");
                    }
                },
                error: function (result) {
                    if(result.status){
                        Command: toastr["error"](result.message, "Mail Sent");
                    }
                }
            });
        })
    });
    
   
</script>
@endpush
