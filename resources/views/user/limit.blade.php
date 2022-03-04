@php $user = auth()->user(); @endphp
@extends('template.dialog')
@section('dialogTitle') {{trans('user/limit.set_limit')}} @endsection
@section('dialogContent')
<div class="modal-body" style="overflow:hidden">
    <form id='create-user'>
        @foreach(App\Currency::all() as $currency)
            @if($currency->name != 'INR')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="short_name">{{ $currency->name }} {{trans('user/limit.buy_limit')}}:</label>
                        <input type="text" class="form-control" name="{{$currency->name}}_BUY_LIMIT" value="{{ $user->getMeta($currency->name.'_BUY_LIMIT') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="short_name">{{ $currency->name }} {{trans('user/limit.sell_limit')}}:</label>
                        <input type="text" class="form-control" name="{{$currency->name}}_SELL_LIMIT" value="{{ $user->getMeta($currency->name.'_SELL_LIMIT') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            @endif
        @endforeach
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('user/limit.close')}}</button>
    <button type="button" class="btn green updateLimit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Updating Limit..." onclick="setLimit('admin/user/{{ auth()->id() }}/limit', $('form[id=create-user]'))">{{trans('user/limit.save_changes')}}</button>
</div>
@stop    
