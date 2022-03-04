@extends('layouts.master')

@section('page-content')
    <div class="col-md-8 col-sm-9">
        <h1 class="main_heading">
            <a href="{{ route('user.deposit') }}"><span class="pull-left"><i class="fa fa-backward"></i> {{trans('deposit/currency.Back')}}</span></a>
           {{trans('deposit/currency.Deposit_Bitcoin')}}
            <a href="{{ route('user.transaction', 'btc') }}"><span> <i class="fa fa-history"></i> {{trans('deposit/currency.History')}}</span></a>
        </h1>
        <div class="deposite_bitcoin">
            <h4>{{trans('deposit/currency.Deposit_account')}}</h4>
            <h3>BTC ({{ number_format(auth()->user()->btc, 8) }} BTC)</h3>
            <h4> {{trans('deposit/currency.Bitcoin_address')}}</h4>
            <p style="text-align:center">{!! QrCode::size(200)->generate($coinAddress->address) !!}</p>
            <p id="btc_addr">{{ $coinAddress->address }} <span><i class="fa fa-repeat"></i></span></p>
            <button class="ui-button"  onclick="copyAddr('#btc_addr'); ">
                <span>{{trans('deposit/currency.Copy')}}</span>
                <i class="fa fa-files-o"></i>
            </button>
            <p id="copy_response"></p>
        </div>
    </div>
@endsection

@push('js')
<script>
    function copyAddr(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $('#copy_response').text('Address Copied!!');
    }
</script>
@endpush
