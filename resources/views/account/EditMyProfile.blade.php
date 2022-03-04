@extends('layouts.master')

@section('page-content')

<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('account/EditMyProfile.edit_profile')}}</h1>
            <div class="box box-inbox">
            @include('flash::message')
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @php $user = auth()->user() @endphp
                    <form role="form" class="onSubmitdisableButton" method="post" action="{{ route('account.updateMyProfile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">
									<p>{{trans('account/EditMyProfile.acc_type')}} : {{ $user->profile->account_type }} </p><hr>
                                {{--
									<p>{{trans('account/EditMyProfile.tax_id')}} : {{ $user->username }} </p><hr>
                                --}}
                                    <div class="form-group">
                                        <label for="usr">{{ ($user->profile->account_type=='company')?trans("account/EditMyProfile.company"):trans("account/EditMyProfile.name") }}:</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name')?:$user->first_name }}">
                                    </div>
                                    
									<div class="form-group">
										<label for="usr">{{trans('account/EditMyProfile.phone_number')}} :</label>
										<input type="text" class="form-control" name="phone_no" value="{{ old('phone_no')?:$user->phone_no }}">
									</div>
									{{--
									<div class="form-group">
										<label for="usr">{{trans('account/EditMyProfile.email')}}:</label>
										<input type="text" class="form-control" name="email" value="{{ old('email')?:$user->email }}">
									</div>
									--}}
									<div class="form-group">
										<label for="usr">{{trans('account/EditMyProfile.photo')}}:</label>
										<input type="file"  name="profile_image" style="border: none;">
									</div>
									
                                    <div class="form-group">
										<label class="form__label">{{trans('account/EditMyProfile.Address')}}:</label>
										<input type="text" name="address" class="form-control" value="{{ old('address')?:$user->profile->address }}">
									</div>

									
									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.Pincode')}}:</label>
										<input type="text" name="pin_code" class="form-control" value="{{ old('pin_code')?:$user->profile->pin_code }}" autocomplete="off">
									</div>

									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.City')}}:</label>
										<input type="text" name="city" class="form-control" value="{{ old('city')?:$user->profile->city }}">
									</div>

									
									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.State')}}:</label>
										<input type="text" name="state" class="form-control" value="{{ old('state')?:$user->profile->state }}">
									</div>
									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.Country')}}:</label>
										<select name="country_id" class="form-control">
											<option value="">- {{trans('account/EditMyProfile.Select')}} -</option>
											@foreach ($countries as $country)
											<option value="{{$country->id}}" {{ ($user->profile->country_id==($country->id))?"selected":"" }} >{{$country->name}}</option>
											@endforeach
										</select>
									</div>
									
									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.Document_type')}}:</label>
										<select name="doc_type" class="form-control">
											<option value='id_proof' >{{trans('account/EditMyProfile.id_proof')}}</option>
										</select>
									</div>
									<div class="form-group input-wrap">
										<label class="form__label">{{trans('account/EditMyProfile.Document_no')}}:</label>
										<input type="text" class="form-control" name="ide_no" value="{{ old('ide_no')?:$user->profile->ide_no }}">
									</div>
									<div class="form-group">
										<label class="form__label">{{trans('account/EditMyProfile.Document_image')}}:</label>
										<input type="file"  name="doc_image" style="border: none;">
									</div>

<!--
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="usr">{{trans('account/EditMyProfile.old_password')}}:</label>
                                                <input name="old_password" class="form-control" type="password" >
                                                @if($errors->has('old_password'))
                                                    <span class="help-text" style="color:red">{{ $errors->first('old_password') }}</span>
                                                @endif
                                            </div>
                                        </div>
    
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="usr">{{trans('account/EditMyProfile.new_password')}}:</label>
                                               
                                                <input name="password" class="form-control" type="password" >
                                                @if($errors->has('password'))
                                                    <span class="help-text" style="color:red">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="usr">{{trans('account/EditMyProfile.confirm_password')}}:</label>
                                                
                                                <input name="password_confirmation" class="form-control" type="password" >
                                               
                                            </div>
                                        </div>
    
                                    </div>
-->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info submitButton">{{trans('account/EditMyProfile.update')}}</button>
                                </div>
                                    
                                
                            </div>

                            

                           

                         
                        </div>
                    </form>


            </div>
		</div>
	</section>
</main> 


@endsection
@push('js')
<script>
	$(document).on('submit', '.onSubmitdisableButton', function(e) {	
		  if (confirm("Are You Sure ?") == true) {
			$('.submitButton').attr('disabled',true);
			return true;
		  } else {
			return false;
		  }
	});
</script>
@endpush
