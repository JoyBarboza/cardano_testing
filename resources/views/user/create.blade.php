@extends('template.dialog')
@section('dialogTitle') Create User @endsection
@section('dialogContent')
<div class="modal-body" style="overflow:hidden">
    <form id='create-user'>
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">{{trans('user/create.first_name')}}:</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="last_name">{{trans('user/create.last_name')}}:</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="country">{{trans('user/create.middle_name')}}:</label>
                <input type="text" class="form-control" id="country" name="middle_name">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="phone">{{trans('user/create.username')}}:</label>
                <input type="text" class="form-control" id="username" name="username">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="short_name">{{trans('user/create.email')}}:</label>
                <input type="text" class="form-control" id="email" name="email">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">{{trans('user/create.password')}}:</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="help-block"></p>
            </div>
<!--
            <div class="form-group">
                <label>Role:</label>
                <div class="mt-radio-inline">
                    @if(auth()->user()->hasRole('super'))
                    <label class="mt-radio">
                        <input type="radio" name="role" value="admin"> {{trans('user/create.admin')}}
                        <span></span>
                    </label>
                    @endif
                    <label class="mt-radio">
                        <input type="radio" name="role" value="subscriber" checked> {{trans('user/create.subscriber')}}
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
-->
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password_confirmation">{{trans('user/create.confirm_password')}}:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="status" value="active" checked> {{trans('user/create.active')}}
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="status" value="deactive"> {{trans('user/create.deactive')}}
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
        </div>               
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('user/create.close')}}</button>
    <button type="button" class="btn green saveuser" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Creating user..." onclick="saveUser('admin/user', $('form[id=create-user]'))">{{trans('user/create.save_changes')}}</button>
</div>
@stop    
