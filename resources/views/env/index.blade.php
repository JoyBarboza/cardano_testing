@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('env/index.Dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('env/index.Env')}}
    <small>{{trans('env/index.Settings')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('env/index.Apply_Settings')}}</span>
                        <p>{{trans('env/index.Env_file')}} {{ $data['file_permission'] }}</p>
                    </div>
                </div>
                <div class="portlet-body">
                    <form role="form" action="{{ route('admin.env.get') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-body">
                                
                                <div class="form-group{{ $errors->has('app_name')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_NAME')}}:</label>
                                    <input name="app_name" value="{{ old('app_name')?:(isset($data['app_name'])?$data['app_name']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_NAME')}}">
                                    <p class="help-block">{{ $errors->first('app_name') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('app_env')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_ENV')}}:</label>
                                    <input name="app_env" value="{{ old('app_env')?:(isset($data['app_env'])?$data['app_env']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_ENV')}}">
                                    <p class="help-block">{{ $errors->first('app_env') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('app_key')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_KEY')}}:</label>
                                    <input name="app_key" value="{{ old('app_key')?:(isset($data['app_key'])?$data['app_key']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_KEY')}}">
                                    <p class="help-block">{{ $errors->first('app_key') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('app_debug')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_DEBUG')}}:</label>
                                    <input name="app_debug" value="{{ old('app_debug')?:(isset($data['app_debug'])?$data['app_debug']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_DEBUG')}}">
                                    <p class="help-block">{{ $errors->first('app_debug') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('app_log_level')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_LOG_LEVEL')}}:</label>
                                    <input name="app_log_level" value="{{ old('app_log_level')?:(isset($data['app_log_level'])?$data['app_log_level']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_LOG_LEVEL')}}">
                                    <p class="help-block">{{ $errors->first('app_log_level') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('app_url')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.APP_URL')}}:</label>
                                    <input name="app_url" value="{{ old('app_url')?:(isset($data['app_url'])?$data['app_url']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_APP_URL')}}">
                                    <p class="help-block">{{ $errors->first('app_url') }}</p>
                                </div>

                                <div class="form-group{{ $errors->has('log_channel')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.LOG_CHANNEL')}}:</label>
                                    <input name="log_channel" value="{{ old('log_channel')?:(isset($data['log_channel'])?$data['log_channel']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_LOG_CHANNEL')}}">
                                    <p class="help-block">{{ $errors->first('log_channel') }}</p>
                                </div>
                                
                                
                                <div class="form-group{{ $errors->has('db_connection')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_CONNECTION')}}:</label>
                                    <input name="db_connection" value="{{ old('db_connection')?:(isset($data['db_connection'])?$data['db_connection']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_CONNECTION')}}">
                                    <p class="help-block">{{ $errors->first('db_connection') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_host')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_HOST')}}:</label>
                                    <input name="db_host" value="{{ old('db_host')?:(isset($data['db_host'])?$data['db_host']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_HOST')}}">
                                    <p class="help-block">{{ $errors->first('db_host') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_port')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_PORT')}}:</label>
                                    <input name="db_port" value="{{ old('db_port')?:(isset($data['db_port'])?$data['db_port']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_PORT')}}">
                                    <p class="help-block">{{ $errors->first('db_port') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_database')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_DATABASE_LIVE')}}:</label>
                                    <input name="db_database" value="{{ old('db_database')?:(isset($data['db_database'])?$data['db_database']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_DATABASE_LIVE')}}">
                                    <p class="help-block">{{ $errors->first('db_database') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_username')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_USERNAME_LIVE')}}:</label>
                                    <input name="db_username" value="{{ old('db_username')?:(isset($data['db_username'])?$data['db_username']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_USERNAME_LIVE')}}">
                                    <p class="help-block">{{ $errors->first('db_username') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_password')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_PASSWORD_LIVE')}}:</label>
                                    <input name="db_password" value="{{ old('db_password')?:(isset($data['db_password'])?$data['db_password']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_PASSWORD_LIVE')}}">
                                    <p class="help-block">{{ $errors->first('db_password') }}</p>
                                </div>
                                
                                
                                <!-- <div class="form-group{{ $errors->has('db_demo_connection')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_CONNECTION_DEMO')}}:</label>
                                    <input name="db_demo_connection" value="{{ old('db_demo_connection')?:(isset($data['db_demo_connection'])?$data['db_demo_connection']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_CONNECTION_DEMO')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_connection') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_demo_host')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_HOST_DEMO')}}:</label>
                                    <input name="db_demo_host" value="{{ old('db_demo_host')?:(isset($data['db_demo_host'])?$data['db_demo_host']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_HOST_DEMO')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_host') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_demo_port')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_PORT')}}:</label>
                                    <input name="db_demo_port" value="{{ old('db_demo_port')?:(isset($data['db_demo_port'])?$data['db_demo_port']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_PORT')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_port') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_demo_database')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_DATABASE_DEMO')}}:</label>
                                    <input name="db_demo_database" value="{{ old('db_demo_database')?:(isset($data['db_demo_database'])?$data['db_demo_database']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_DATABASE_DEMO')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_database') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_demo_username')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_USERNAME_DEMO')}}:</label>
                                    <input name="db_demo_username" value="{{ old('db_demo_username')?:(isset($data['db_demo_username'])?$data['db_demo_username']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_USERNAME_DEMO')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_username') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('db_demo_password')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.DB_PASSWORD_DEMO')}}:</label>
                                    <input name="db_demo_password" value="{{ old('db_demo_password')?:(isset($data['db_demo_password'])?$data['db_demo_password']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_DB_PASSWORD_DEMO')}}">
                                    <p class="help-block">{{ $errors->first('db_demo_password') }}</p>
                                </div> -->


                                <div class="form-group{{ $errors->has('broadcast_driver')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.BROADCAST_DRIVER')}}:</label>
                                    <input name="broadcast_driver" value="{{ old('broadcast_driver')?:(isset($data['broadcast_driver'])?$data['broadcast_driver']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_BROADCAST_DRIVER')}}">
                                    <p class="help-block">{{ $errors->first('broadcast_driver') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('cache_driver')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.CACHE_DRIVER')}}:</label>
                                    <input name="cache_driver" value="{{ old('cache_driver')?:(isset($data['cache_driver'])?$data['cache_driver']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_CACHE_DRIVER')}}">
                                    <p class="help-block">{{ $errors->first('cache_driver') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('session_driver')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.SESSION_DRIVER')}}:</label>
                                    <input name="session_driver" value="{{ old('session_driver')?:(isset($data['session_driver'])?$data['session_driver']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_SESSION_DRIVER')}}">
                                    <p class="help-block">{{ $errors->first('session_driver') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('session_lifetime')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.SESSION_LIFETIME')}}:</label>
                                    <input name="session_lifetime" value="{{ old('session_lifetime')?:(isset($data['session_lifetime'])?$data['session_lifetime']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_SESSION_LIFETIME')}}">
                                    <p class="help-block">{{ $errors->first('session_lifetime') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('queue_driver')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.QUEUE_DRIVER')}}:</label>
                                    <input name="queue_driver" value="{{ old('queue_driver')?:(isset($data['queue_driver'])?$data['queue_driver']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_QUEUE_DRIVER')}}">
                                    <p class="help-block">{{ $errors->first('queue_driver') }}</p>
                                </div>

                                <!-- <div class="form-group{{ $errors->has('session_lifetime')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.SESSION_LIFETIME')}}:</label>
                                    <input name="session_lifetime" value="{{ old('session_lifetime')?:(isset($data['session_lifetime'])?$data['session_lifetime']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_SESSION_LIFETIME')}}">
                                    <p class="help-block">{{ $errors->first('session_lifetime') }}</p>
                                </div> -->

                                <div class="form-group{{ $errors->has('redis_host')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.REDIS_HOST')}}:</label>
                                    <input name="redis_host" value="{{ old('redis_host')?:(isset($data['redis_host'])?$data['redis_host']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_REDIS_HOST')}}">
                                    <p class="help-block">{{ $errors->first('redis_host') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('redis_password')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.REDIS_PASSWORD')}}:</label>
                                    <input name="redis_password" value="{{ old('redis_password')?:(isset($data['redis_password'])?$data['redis_password']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_REDIS_PASSWORD')}}">
                                    <p class="help-block">{{ $errors->first('redis_password') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('redis_port')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.REDIS_PORT')}}:</label>
                                    <input name="redis_port" value="{{ old('redis_port')?:(isset($data['redis_port'])?$data['redis_port']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_REDIS_PORT')}}">
                                    <p class="help-block">{{ $errors->first('redis_port') }}</p>
                                </div>

                                <div class="form-group{{ $errors->has('mail_driver')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_DRIVER')}}:</label>
                                    <input name="mail_driver" value="{{ old('mail_driver')?:(isset($data['mail_driver'])?$data['mail_driver']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_DRIVER')}}">
                                    <p class="help-block">{{ $errors->first('mail_driver') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('mail_host')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_HOST')}}:</label>
                                    <input name="mail_host" value="{{ old('mail_host')?:(isset($data['mail_host'])?$data['mail_host']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_HOST')}}">
                                    <p class="help-block">{{ $errors->first('mail_host') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('mail_port')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_PORT')}}:</label>
                                    <input name="mail_port" value="{{ old('mail_port')?:(isset($data['mail_port'])?$data['mail_port']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_PORT')}}">
                                    <p class="help-block">{{ $errors->first('mail_port') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('mail_username')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_USERNAME')}}:</label>
                                    <input name="mail_username" value="{{ old('mail_username')?:(isset($data['mail_username'])?$data['mail_username']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_USERNAME')}}">
                                    <p class="help-block">{{ $errors->first('mail_username') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('mail_password')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_PASSWORD')}}:</label>
                                    <input name="mail_password" value="{{ old('mail_password')?:(isset($data['mail_password'])?$data['mail_password']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_PASSWORD')}}">
                                    <p class="help-block">{{ $errors->first('mail_password') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('mail_encryption')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.MAIL_ENCRYPTION')}}:</label>
                                    <input name="mail_encryption" value="{{ old('mail_encryption')?:(isset($data['mail_encryption'])?$data['mail_encryption']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_MAIL_ENCRYPTION')}}">
                                    <p class="help-block">{{ $errors->first('mail_encryption') }}</p>
                                </div>


                                <div class="form-group{{ $errors->has('pusher_app_id')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PUSHER_APP_ID')}}:</label>
                                    <input name="pusher_app_id" value="{{ old('pusher_app_id')?:(isset($data['pusher_app_id'])?$data['pusher_app_id']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PUSHER_APP_ID')}}">
                                    <p class="help-block">{{ $errors->first('pusher_app_id') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('pusher_app_key')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PUSHER_APP_KEY')}}:</label>
                                    <input name="pusher_app_key" value="{{ old('pusher_app_key')?:(isset($data['pusher_app_key'])?$data['pusher_app_key']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PUSHER_APP_KEY')}}">
                                    <p class="help-block">{{ $errors->first('pusher_app_key') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('pusher_app_secret')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PUSHER_APP_SECRET')}}:</label>
                                    <input name="pusher_app_secret" value="{{ old('pusher_app_secret')?:(isset($data['pusher_app_secret'])?$data['pusher_app_secret']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PUSHER_APP_SECRET')}}">
                                    <p class="help-block">{{ $errors->first('pusher_app_secret') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('pusher_app_cluster')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PUSHER_APP_CLUSTER')}}:</label>
                                    <input name="pusher_app_cluster" value="{{ old('pusher_app_cluster')?:(isset($data['pusher_app_cluster'])?$data['pusher_app_cluster']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PUSHER_APP_CLUSTER')}}">
                                    <p class="help-block">{{ $errors->first('pusher_app_cluster') }}</p>
                                </div>


                                <div class="form-group{{ $errors->has('coinpayments_db_prefix')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_DB_PREFIX')}}:</label>
                                    <input name="coinpayments_db_prefix" value="{{ old('coinpayments_db_prefix')?:(isset($data['coinpayments_db_prefix'])?$data['coinpayments_db_prefix']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_DB_PREFIX')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_db_prefix') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_merchant_id')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_MERCHANT_ID')}}:</label>
                                    <input name="coinpayments_merchant_id" value="{{ old('coinpayments_merchant_id')?:(isset($data['coinpayments_merchant_id'])?$data['coinpayments_merchant_id']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_MERCHANT_ID')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_merchant_id') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_public_key')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_PUBLIC_KEY')}}:</label>
                                    <input name="coinpayments_public_key" value="{{ old('coinpayments_public_key')?:(isset($data['coinpayments_public_key'])?$data['coinpayments_public_key']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_PUBLIC_KEY')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_public_key') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_private_key')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_PRIVATE_KEY')}}:</label>
                                    <input name="coinpayments_private_key" value="{{ old('coinpayments_private_key')?:(isset($data['coinpayments_private_key'])?$data['coinpayments_private_key']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_PRIVATE_KEY')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_private_key') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_ipn_secret')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_IPN_SECRET')}}:</label>
                                    <input name="coinpayments_ipn_secret" value="{{ old('coinpayments_ipn_secret')?:(isset($data['coinpayments_ipn_secret'])?$data['coinpayments_ipn_secret']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_IPN_SECRET')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_ipn_secret') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_ipn_url')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_IPN_URL')}}:</label>
                                    <input name="coinpayments_ipn_url" value="{{ old('coinpayments_ipn_url')?:(isset($data['coinpayments_ipn_url'])?$data['coinpayments_ipn_url']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_IPN_URL')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_ipn_url') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('coinpayments_api_format')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.COINPAYMENTS_API_FORMAT')}}:</label>
                                    <input name="coinpayments_api_format" value="{{ old('coinpayments_api_format')?:(isset($data['coinpayments_api_format'])?$data['coinpayments_api_format']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_COINPAYMENTS_API_FORMAT')}}">
                                    <p class="help-block">{{ $errors->first('coinpayments_api_format') }}</p>
                                </div>


                                <div class="form-group{{ $errors->has('paypal_mode')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PAYPAL_MODE')}}:</label>
                                    <input name="paypal_mode" value="{{ old('paypal_mode')?:(isset($data['paypal_mode'])?$data['paypal_mode']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PAYPAL_MODE')}}">
                                    <p class="help-blockpaypal_mode $errors->first('paypal_mode') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('paypal_client_sendbox')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PAYPAL_CLIENT_SENDBOX')}}:</label>
                                    <input name="paypal_client_sendbox" value="{{ old('paypal_client_sendbox')?:(isset($data['paypal_client_sendbox'])?$data['paypal_client_sendbox']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PAYPAL_CLIENT_SENDBOX')}}">
                                    <p class="help-block">{{ $errors->first('paypal_client_sendbox') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('paypal_client_production')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.PAYPAL_CLIENT_PRODUCTION')}}:</label>
                                    <input name="paypal_client_production" value="{{ old('paypal_client_production')?:(isset($data['paypal_client_production'])?$data['paypal_client_production']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_PAYPAL_CLIENT_PRODUCTION')}}">
                                    <p class="help-block">{{ $errors->first('paypal_client_production') }}</p>
                                </div>

                                <div class="form-group{{ $errors->has('token_name')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.TOKEN_NAME')}}:</label>
                                    <input name="token_name" value="{{ old('token_name')?:(isset($data['token_name'])?$data['token_name']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_TOKEN_NAME')}}">
                                    <p class="help-block">{{ $errors->first('token_name') }}</p>
                                </div>

                                <div class="form-group{{ $errors->has('token_symbol')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.TOKEN_SYMBOL')}}:</label>
                                    <input name="token_symbol" value="{{ old('token_symbol')?:(isset($data['token_symbol'])?$data['token_symbol']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_TOKEN_SYMBOL')}}">
                                    <p class="help-block">{{ $errors->first('token_symbol') }}</p>
                                </div>

                                <!-- <div class="form-group{{ $errors->has('aws_access_key_id')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.AWS_ACCESS_KEY_ID')}}:</label>
                                    <input name="aws_access_key_id" value="{{ old('aws_access_key_id')?:(isset($data['aws_access_key_id'])?$data['aws_access_key_id']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_AWS_ACCESS_KEY_ID')}}">
                                    <p class="help-block">{{ $errors->first('aws_access_key_id') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('aws_secret_access_key')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.AWS_SECRET_ACCESS_KEY')}}:</label>
                                    <input name="aws_secret_access_key" value="{{ old('aws_secret_access_key')?:(isset($data['aws_secret_access_key'])?$data['aws_secret_access_key']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_AWS_SECRET_ACCESS_KEY')}}">
                                    <p class="help-block">{{ $errors->first('aws_secret_access_key') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('aws_region')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.AWS_REGION')}}:</label>
                                    <input name="aws_region" value="{{ old('aws_region')?:(isset($data['aws_region'])?$data['app_name']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_AWS_REGION')}}">
                                    <p class="help-block">{{ $errors->first('aws_region') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('captcha_sitekey')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.CAPTCHA_SITEKEY')}}:</label>
                                    <input name="captcha_sitekey" value="{{ old('captcha_sitekey')?:(isset($data['captcha_sitekey'])?$data['captcha_sitekey']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_CAPTCHA_SITEKEY')}}">
                                    <p class="help-block">{{ $errors->first('captcha_sitekey') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('captcha_secret')?' has-error':' has-feedback' }}">
                                    <label>{{trans('env/index.CAPTCHA_SECRET')}}:</label>
                                    <input name="captcha_secret" value="{{ old('captcha_secret')?:(isset($data['captcha_secret'])?$data['captcha_secret']:'') }}" type="text" class="form-control" placeholder="{{trans('env/index.Enter_CAPTCHA_SECRET')}}">
                                    <p class="help-block">{{ $errors->first('captcha_secret') }}</p>
                                </div> -->

                        </div>        
                        <div class="form-actions text-right">
                            <button type="submit" class="btn blue">{{trans('env/index.Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('js')

@endpush
