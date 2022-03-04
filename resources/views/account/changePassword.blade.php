@extends('layouts.master')

@section('page-content')


<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('account/changePassword.change_password')}}</h1>
            <div class="box box-inbox">
            @include('flash::message')
            @php $user = auth()->user() @endphp
                    <form role="form" method="post" action="{{ route('account.update_password') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                    

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
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info">{{trans('account/EditMyProfile.update')}}</button>
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

@endpush
