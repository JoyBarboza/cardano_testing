@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('user/index.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('user/index.user')}} {{trans('user/index.management')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('user/index.user')}}
    <small>{{trans('user/index.management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">@include('flash::message')
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('user/index.search')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" name="search" method="get" action="{{ route('admin.user.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">{{trans('user/index.first_name')}}:</label>
                            <input type="text" name="first_name" value="{{ request()->first_name }}" class="form-control" placeholder="{{trans('user/index.Search_First_Name')}}">
                        </div>
                       {{-- <div class="col-md-4">
                            <label for="">{{trans('user/index.last_name')}}:</label>
                            <input type="text" name="last_name" value="{{ request()->last_name }}" class="form-control" placeholder="{{trans('user/index.Search_By_Last_Name')}}">
                        </div>--}}
                        <div class="col-md-4">
                            <label for="">{{trans('user/index.email')}}:</label>
                            <input type="email" name="email" value="{{ request()->email }}" class="form-control" placeholder="{{trans('user/index.Search_By_Email')}}">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="">{{trans('user/index.status')}}:</label>
                            <select name="status" class="form-control">
                                <option value="">-- {{trans('user/index.select_status')}} --</option>
                                <option value="active" {{ (request()->status == 'active')?'selected':'' }}>{{trans('user/index.active')}}</option>
                                <option value="deactive" {{ (request()->status == 'deactive')?'selected':'' }}>{{trans('user/index.deactive')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">KYC Verify :</label>
                            <select name="kyc_verified" class="form-control">
                                <option value="">-- {{trans('user/index.select_status')}} --</option>
                                <option value=1 {{ (request()->kyc_verified == 1)?'selected':'' }}>Verified</option>
                                <option value=2 {{ (request()->kyc_verified == 2)?'selected':'' }}>Processing</option>
                                <option value=3 {{ (request()->kyc_verified == 3)?'selected':'' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('user/index.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('user/index.user')}} {{trans('user/index.management')}}</span>
                </div>
               <!-- <div class="actions">
                    <button class="btn red btn-outline sbold" name="create"> {{trans('user/index.add_user')}} </button>
                </div>-->
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> {{trans('user/index.name')}} </th>
                                <th> {{trans('user/index.email')}} </th>
                                <th> {{trans('user/index.ID_Proof')}} </th>
                                <th> {{trans('user/index.Email_verified')}} </th>
<!--
                                <th> {{trans('user/index.role')}} </th>
-->
                                <th> {{trans('user/index.status')}} </th>
                                <th style="width:35%" class="text-center"> {{trans('user/index.action')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td> {{ $user->id }} </td>
                                    <td> {{ $user->full_name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td>  
										
										@php if($user->document()->where('name','DOC_PHOTO')->exists()){  @endphp
										
										<button name="view_doc" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-eye"></i> View Doc 
                                        </button>
                                        @php } @endphp
                                   </td>
                                   <td> 
									   
									   <a href="{{ route('admin.user.verifyEmail',$user->id) }}" title="Verify User" onclick="return confirm('Are you sure you want approve this user?');" style="cursor:pointer">
									    @if($user->verified_at)
											Yes  
										@else
											Verify Email
                                        @endif    
									   </a>
									  
                                   </td>
<!--
                                    <td> 
                                        <label class="label label-sm label-{{ $user->hasRole('admin')?'info':'warning' }}"> {{ ($user->roles()->count() > 0)? $user->roles()->pluck('name')->implode(', '):'Not Available' }} </label>
                                    </td>
-->
                                    <td>
                                        @if($user->status)
                                            <label class="label label-sm label-success"> {{trans('user/index.active')}} </label>
                                        @else
                                            <label class="label label-sm label-danger"> {{trans('user/index.deactive')}} </label>
                                        @endif                                        
                                    </td>
                                    <td style="width:20%" class="text-center">
                                        <a href="{{ route('admin.user.loginAs', $user->id) }}" class="btn btn-outline btn-circle btn-sm green">
                                            <i class="fa fa-lock"></i> Login
                                        </a>

<!--
                                        <button name="limit" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm yellow">
                                            <i class="fa fa-eye"></i> {{trans('user/index.set_limit')}}
                                        </button>
-->

                                        <button name="view" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-eye"></i> {{trans('user/index.view')}} 
                                        </button>
                                        <button name="edit" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm purple">
                                            <i class="fa fa-edit"></i> {{trans('user/index.edit')}} 
                                        </button>
                                        <a href="{{ route('admin.user.account') }}?query={{ urlencode($user->email) }}" class="btn btn-outline btn-circle btn-sm green">
                                            <i class="fa fa-bank"></i> Account
                                        </a>
                                        {{--<button name="delete" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm red">
                                            <i class="fa fa-trash"></i> {{trans('user/index.delete')}} 
                                        </button>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{trans('user/index.data_doesnot_exists')}} </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="7" class="text-right">
                                    {{ $users->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" class="modal" role="dialog"></div>

@include('template.loader')

@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).on('change', '.account_type', function(){

		var account_type= $(".account_type :selected").val();
		if(account_type=='individual'){
			$('#name_label').html("Name :");
			
		}else if(account_type=='company'){
			$('#name_label').html("Company Name :");
			
		}
	});
    $(document).ready(function(){

        $('button[name=limit]').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/'+id+'/limit',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });
        
        $('button[name=view_doc]').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/userdoc/'+id,
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name=view]').click(function () {
            var id = $(this).data('id'); 
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/'+id,
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name=create]').click(function () {
            
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/create',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name="edit"]').click(function(){
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/'+ id +'/edit',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name="delete"]').click(function(){
            var id = $(this).data('id');
            var row = $(this).closest('tr');

            var data = {_method:'DELETE'};
            
            bootbox.confirm('Are you sure you want to delete user called "'
                    + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    $.ajax({
                        url: baseURL + 'admin/user/'+ id,
                        type: 'POST',
                        data: data,
                        dataType:'json',
                        success: function (result) {
                            if(result.status){
                                row.remove();
                            }
                            bootbox.alert(result.message);
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            })
        });   
    });

function saveUser(url, form, method = false)
{
    var formData = { 
        name: form.find('input[name=name]').val(),
        username: form.find('input[name=username]').val(),
        account_type: $('.account_type option:selected').val(),
        username: form.find('input[name=username]').val(),
        email: form.find('input[name=email]').val(),
        password: form.find('input[name=password]').val(),
        password_confirmation:form.find('input[name=password_confirmation]').val(),
        //~ role: form.find('input[name=role]:checked').val(),
        status: form.find('input[name=status]:checked').val(),   
        phone: form.find('input[name=phone]').val(),
        address: form.find('input[name=address]').val(),
        pin_code: form.find('input[name=pin_code]').val(),
        city: form.find('input[name=city]').val(),
        state: form.find('input[name=state]').val(),
                           
        ide_no: form.find('input[name=ide_no]').val(), 
        kyc_verified: $('.kyc_verified option:selected').val(),                       
        country_id: $('.country_id option:selected').val(),                       
    };

    if(method) {
        formData['_method'] = 'PUT';
    }

    $('button.saveuser').button('loading');
             
    $.ajax({
        url:baseURL + url,
        type:'POST',
        data:formData,            
        dataType:'json',                
        success:function(result){ 
			alert(result['message']);
            $('div[id=basic]').modal('hide');
            location.reload(true);
        },
        error:function(result){ 
            $('button.saveuser').button('reset');
            var errors = result.responseJSON;
            alert(errors.message);
			//$('.error_form').html(errors);
			if('account_type' in errors) {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.account_type[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('name' in errors) {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.name[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            

            if('username' in errors) {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.username[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }

            if('email' in errors) {
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.email[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('phone' in errors) {
                var formGroup = form.find('div.form-group:eq(4)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.phone[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(4)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('address' in errors) {
                var formGroup = form.find('div.form-group:eq(5)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.address[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(5)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('pin_code' in errors) {
                var formGroup = form.find('div.form-group:eq(6)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.pin_code[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(6)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('city' in errors) {
                var formGroup = form.find('div.form-group:eq(7)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.city[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(7)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('state' in errors) {
                var formGroup = form.find('div.form-group:eq(8)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.state[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(8)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('country_id' in errors) {
                var formGroup = form.find('div.form-group:eq(9)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.country_id[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(9)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('password' in errors) {
                var formGroup = form.find('div.form-group:eq(10)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.password[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(10)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }  
            //~ if('role' in errors){
                //~ var formGroup = form.find('div.form-group:eq(6)');
                //~ formGroup.addClass('has-error');
                //~ formGroup.find('p').text(errors.role[0]);
            //~ } else {
                //~ var formGroup = form.find('div.form-group:eq(6)');
                //~ formGroup.removeClass('has-error');
                //~ formGroup.find('p').text('');
            //~ }          
            if('status' in errors){
                var formGroup = form.find('div.form-group:eq(12)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.status[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(12)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('ide_no' in errors){
                var formGroup = form.find('div.form-group:eq(13)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.ide_no[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(13)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('kyc_verified' in errors){
                var formGroup = form.find('div.form-group:eq(14)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.kyc_verified[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(14)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
        }
    });
}
</script>
@endpush            
