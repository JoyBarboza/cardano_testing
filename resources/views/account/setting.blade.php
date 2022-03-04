@extends('layouts.master')

@section('page-content')
    <div class="col-md-9 col-sm-8"> 
    <h2>{{trans('account/setting.settings')}}</h2>
    <hr />    
    <p>{{trans('account/setting.page_under_construction')}}</p> </div>
    <div class="col-md-9 col-sm-8" style="display:none">
        <div class="profile_section">
            
            <div class="send_request_background on_off_btn">
                <strong>{{trans('account/setting.blacklist_your_email')}}</strong>
                <hr>
                <form>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.including_news_letters')}}:</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('news-letter') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="news-letter">
                        </div>
                    </div>
                </form>
            </div>
            <div class="send_request_background on_off_btn">
                <strong>{{trans('account/setting.email_notifications')}}</strong>
                <hr>
                <form>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.sending_btc')}} :</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('send-btc') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="send-btc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.receiving_btc')}} :</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('recieve-btc') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="recieve-btc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.buying_btc')}} :</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('buy-btc') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="buy-btc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.selling_btc')}} :</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('sell-btc') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="sell-btc">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >{{trans('account/setting.otp')}} :</label>
                        <div class="col-sm-4">
                            <input {{ ($user->getMeta('send-otp') == 'true')?'checked':'' }} data-toggle="toggle" type="checkbox" name="send-otp">
                        </div>
                    </div>
                </form>
            </div>
            <!--<div class="send_request_background">
                <strong>Logout From All Devices</strong>
                <hr>
                <p>Click the button below to logout from all devices and Merchant POS.</p>
                <button class="account_btn">Logout Everywhere Else</button>
            </div>-->
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type=checkbox]').change(function () {
                var name = $(this).attr('name');
                var value = $(this).prop('checked');

                $.ajax({
                 url:'/account/setting/notification',
                 method:'POST',
                 data:{ key: name, value:value},
                 dataType:'json'
                });
            });
        });
    </script>
@endpush
