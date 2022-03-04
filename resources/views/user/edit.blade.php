@extends('template.dialog')
@section('dialogTitle') {{trans('user/edit.Modify_user')}} @endsection
@section('dialogContent')
    <div class="modal-body" style="overflow:hidden">
        <form id='modify-user'>
			<div class="col-md-12"><p class="error_form"></p>
			<div class="form-group">
				<label for="first_name">{{trans('user/edit.acc_type')}}:</label>
				<select name="account_type" class="form-control account_type">
					<option value="individual" {{ ($user->profile->account_type=="individual")?"selected":"" }}>{{trans('user/edit.Individual')}}</option>
					<option value="company" {{ ($user->profile->account_type=="company")?"selected":"" }}>{{trans('user/edit.Company')}}</option>
				</select>
			   <p class="help-block"></p>
			</div>
			</div>
			 @php 
				if($user->profile->account_type=='company'){
					 $name_div="Company_Name";
					
				}else{
					$name_div="Name";
						
				}
			  @endphp
                  
            <div class="col-md-12">
                <div class="form-group">
                    <label for="first_name" id="name_label">{{ trans('user/edit.'.$name_div)  }}:</label>
                    <input type="text" class="form-control" id="first_name" name="name" value="{{ ucfirst($user->first_name) }}">
                    <p class="help-block"></p>
                </div>
               
            </div>
            <div class="col-md-12">
                
                <div class="form-group">
                    <label for="phone">{{trans('user/edit.Tax_Id')}}:</label> 
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short_name">{{trans('user/edit.email')}}:</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="short_name">{{trans('user/edit.Phone')}}:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone_no }}">
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
					<label class="short_name">{{trans('user/edit.Street_address')}}:</label>
					<input type="text" class="form-control" name="address" value="{{ old('address')?:$user->profile->address }}">
				</div>
				<div class="form-group">
					<label class="short_name">{{trans('user/edit.PinCode')}}:</label>
					<input type="text" class="form-control" name="pin_code" value="{{ old('pin_code')?:$user->profile->pin_code }}" autocomplete="off">
				</div>

				<div class="form-group">
					<label class="short_name">{{trans('user/edit.City')}} :</label>
					<input type="text" class="form-control" name="city" value="{{ old('city')?:$user->profile->city }}">
				</div>
				<div class="form-group">
					<label class="short_name">{{trans('user/edit.State')}}:</label>
					<input type="text" class="form-control" name="state" value="{{ old('state')?:$user->profile->state }}">
				</div>
				<div class="form-group">
					<label class="short_name">{{trans('user/edit.Country')}}:</label>
					<select name="country_id" class="form-control country_id">
						<option value="">- {{trans('user/edit.Select')}} -</option>
						@foreach ($countries as $country)
						<option value="{{$country->id}}" {{ ($user->profile->country_id==($country->id))?"selected":"" }} >{{$country->name}}</option>
						@endforeach
					</select>
				</div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">{{trans('user/edit.password')}}:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <p class="help-block"></p>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password_confirmation">{{trans('user/edit.confirm_password')}}:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    <p class="help-block"></p>
                </div>
            </div>
             <div class="col-md-12">
                <div class="form-group">
                    <label>{{trans('user/edit.Status')}}:</label>
                    <div class="mt-radio-inline">
                        <label class="mt-radio">
                            <input type="radio" name="status" value="active" {{ $user->status?'checked':'' }}> {{trans('user/edit.active')}}
                            <span></span>
                        </label>
                        <label class="mt-radio">
                            <input type="radio" name="status" value="deactive" {{ !$user->status?'checked':'' }}> {{trans('user/edit.deactive')}}
                            <span></span>
                        </label>
                    </div>
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
					<label class="short_name">{{trans('user/edit.Document_number')}}:</label>
					<input type="text" class="form-control" name="ide_no" value="{{ old('ide_no')?:$user->profile->ide_no }}">
				</div>
				
				<div class="form-group">
					<label class="">{{trans('user/edit.KYC_verify')}}:</label>
					<select name="kyc_verified" class="form-control kyc_verified">
						<option value=1 {{ $user->profile->kyc_verified?'selected':'' }}>{{trans('user/edit.Yes')}}</option>
						<option value=0 {{ ($user->profile->kyc_verified==0)?'selected':'' }} >{{trans('user/edit.No')}}</option>
					</select>
				</div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('user/edit.close')}}</button>
        <button type="button" class="btn green saveuser" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Updating user..." onclick="saveUser('admin/user/{{ $user->id }}', $('form[id=modify-user]'), true)">{{trans('user/edit.save_changes')}}</button>
    </div>
@stop
