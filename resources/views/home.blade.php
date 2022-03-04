@php $user = auth()->user(); @endphp
@extends('layouts.master')

@section('page-content')

<style>
.jstree-themeicon-custom{background-size: cover !important; border-radius: 50%;}
</style>


<main>
	<section>
		<div class="rows">
			

			<h1 class="main_heading">{{ trans('home.wallets') }}</h1>
			@php if((auth()->user()->profile->address=='') && (auth()->user()->profile->ide_no=='') && (!auth()->user()->profile->kyc_verified)){ @endphp
			<div class="alert alert-danger alert-dismissible hide" id="paypalClose">
				{{trans('home.complete_kyc')}} <a href="{{route('account.profile')}}">{{trans('home.Profile')}}</a>  {{trans('home.withdraw_MSC')}} 
			 
			</div>
			@php }else if (!auth()->user()->profile->kyc_verified){ @endphp
			<div class="alert alert-danger alert-dismissible hide" id="paypalClose">
				{{trans('home.kyc_progress')}}
			</div>
			@php } @endphp


			<div class="box box-inbox">
				<div class="row">
					<div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Account</label>
                           	<span class="showAccount"></span>
                        </div>
                    </div>
				</div>
			</div>
			
			<div class="box box-inbox">
				<div class="row">
			
					<div class="col-md-6 col-sm-6">
						<div class="external-event bg-pink">
							<div class="event-title">
								<!-- <span>{{ $symbol }}</span> -->
								<span>CSM</span>
							</div>
							<div class="event-content">
								<div class="date">
								<!-- {{ round(auth()->user()->csm,8)}} -->
								{{ round(auth()->user()->cjm_wallet,6)}}
								</div>
								<div class="time">
									<a class="view_btn" href="{{ route('user.transaction','token') }}"><i class="fa fa-eye"></i> {{trans('home.view_details')}}</a>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-6 col-sm-6">
						<div class="external-event bg-aqua">
							<div class="event-title">
								<span>ADA</span>
							</div>
							<div class="event-content">
								<div class="date">
								{{ round(auth()->user()->eth_wallet,6)}}
								</div>
								<div class="time">
									<a class="view_btn" href="{{ route('user.transaction','usd') }}"><i class="fa fa-eye"></i> {{trans('home.view_details')}}</a>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		
			<div class="box box-inbox">
				<div class="row">
					<div class="col-md-12 col-sm-12">
					 <h3>{{ __('Refer a friend & Earn Money') }}</h3><hr>
		 
						 <form method="post" action="#" />
						 {{ csrf_field() }}
							 <div class="card-widget white">
							 <div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="card-widget white">
										
										<div class="row margin-top-20">
											<div class="col-md-8" style="min-height:47px;">
												<h6 style="display: inline-block;" id="left-code">{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}</h6>
												<a title="{{ __('Copy Link') }}" href="javascript:;" class="mt-clipboard" data-clipboard-action="copy" data-clipboard-target="#left-code">
													<img style="width: 30px; margin-left: 30px; margin-right: 10px;" src="{{ asset('images/link-copy.png') }}" alt="" />{{ __('Copy Link') }} </a> 
												</a>
											</div>
											<div class="col-md-4 text-right">
											 <a href="javascript:;" id="leftLink"><img style="width: 30px; margin-right: 10px;" src="{{ asset('images/share-link.png') }}" alt="" />{{ __('Share Link') }}</a>
											 <div class="addthis_responsive_sharing" id="leftShare" style="display:none;padding-top:5px;" 
												data-url="{{ url(Config::get('app.locale').'/register?referral-code=').$user->referral }}"
												data-title="Super Cool Article">
												<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
												<a class="addthis_counter addthis_pill_style"></a>
												
												</div>								
											 </div>
											
											
										</div>
										<br>
										<div class="row margin-top-20">
											<div class="col-md-7">
												<input type="email" name="left" class="form-control" placeholder="{{ __('Beneficiary Email Address') }}" required/>
											</div>
											<div class="col-md-5"><button type="button" class="btn btn-info btn-block">{{ __('Send Invitation') }}</button></div>
										</div>
										
									 </div>
								</div>
							   
							
							 </div>
							 </div>
						 </form>
		 
					</div>
				</div>
			</div>
			{{--
			
			@if(count($getReferralUsers) > 0)
				<div class="box box-inbox">
					<div class="panel"><h3 style="margin:10px;">{{ __('Referral List') }}</h3>
							<div class="panel-body">
							<div class="table-responsive">
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
								<div class="portlet-footer">
										<span>{{ __('Showing') }} {{ $getReferralUsers->firstItem() }} {{ __('to') }} {{ $getReferralUsers->lastItem() }} of {{ $getReferralUsers->total() }} {{ __('records') }}</span>
										<span class="text-right">{{ $getReferralUsers->links() }}</span>
									</div>
							</div>
							
								
							</div>
						</div>
					</div>
				@endif
				--}}
				@if(count($getReferralUsers) > 0)
				<div class="box box-inbox">
					<div class="panel"><h3 style="margin:10px;">{{ __('Referral List') }}</h3>
					<div class="row new-user order-list">
						@include('flash::message')
					
					<div id="tree"></div>
					
				</div>
				@endif
				
		</div>
		
		
	</section>
	
</main>

<div id="myModal" class="modal fade myModal" role="dialog"></div>
<div id="myLoader" class="modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@endsection

@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{asset('jstree/css/style.min.css')}}?v={{time()}}" />

@endpush
@push('js')

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
                        Command: toastr["error"]("Email Sending failed", "Mail Not Sent");
                    }
                    element.val("");
                },
                error: function (result) {
                    if(result.status){
                        Command: toastr["error"](result.message, "Mail Not Sent");
                    }
                    
                }
            });
        })
    });
    
   
</script>

<script src="{{asset('jstree/js/jstree.min.js')}}"></script>

<script>
	var url = $('base').attr('href');
	var username = '{{$user->email}}';
	


$(function () {
    $.support.cors = true;
    $('#tree').jstree({
        "plugins": ['themes','json_data','ui'],
            'core': {
            'data': {
                'url': function (node) {
                    if(node.id === '#') {
                        return url + '/network/team/' + username;
                    }
                    else {
                        return url + '/network/team/' + node.id;
                    }
                },
                'dataType': "json"
            }
        }
    });

	$('#tree').on('activate_node.jstree', function (e,data) { 

		//~ $.ajax({
			//~ type: "GET",
			//~ url: url + '/network/member/' + data.node.id,
			//~ dataType: 'html',
			//~ beforeSend: function () {
                   //~ // $('div[id=myLoader]').modal({backdrop:false});
                //~ },
			//~ success: function (result) {
				//~ console.log(result);
				//~ $('div[id=myModal]').empty().html(result);
				//~ //$('div[id=myLoader]').modal('hide');
				//~ $('div[id=myModal]').modal();

			//~ },
			//~ error: function (request, status, error) {
				//~ console.log("ajax call went wrong:" + request.responseText);
				//~ //$('div[id=myLoader]').modal('hide');
				
			//~ }
			
		//~ });
	
 	});
});
	
</script>

@endpush
