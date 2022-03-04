@php $user = auth()->user(); @endphp
@extends('layouts.master')
@section('page-title') {{trans('withdraw/usd.USD_Withdrawal')}} @endsection
@section('page-content')


<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('withdraw/usd.Withdraw')}}<small> USD ($ {{number_format(auth()->user()->usd,4)}})</small></h1>
            <div class="box box-inbox">
            @include('flash::message')
            <h3>Withdraw via CoinPayment :</h3><hr>
                @php $withdraw = session('withdraw')?session('withdraw'):null @endphp
                @if($withdraw)
                    <div class="col-md-12">
                        <p><strong>{{trans('withdraw/usd.Address')}} : </strong>{{ $withdraw->address }}</p>
                        <p><strong>{{trans('withdraw/usd.RefID')}} : </strong>{{ $withdraw->ref_id }}</p>
                        <p><strong>{{trans('withdraw/usd.Amount')}} : </strong>{{ $withdraw->amount }}</p>
                        <p><strong>{{trans('withdraw/usd.Currency')}} : </strong>{{ $withdraw->currency }}</p>
                        <a class="btn btn-primary" onclick="javascript:window.history.go(-2);">{{trans('withdraw/usd.GoBack')}}</a>
                    </div>
                @else
                <form class="form-horizontal" name="withdraw" action="{{ route('user.withdraw.currency.make', 'usd') }}" method="post">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('payable_currency')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/usd.Select_coin_of_withdrawal')}}:</label>
                            <select name="payable_currency" class="form-control">
                                <option value="USD" @if(old('payable_currency') == 'USD') selected @endif>USD</option>
                                <option value="BTC" @if(old('payable_currency') == 'BTC') selected @endif>{{trans('withdraw/usd.Bitcoin')}}</option>
                                <option value="BCH" @if(old('payable_currency') == 'BCH') selected @endif>{{trans('withdraw/usd.Bitcoin_Cash')}}</option>
                                <option value="LTC" @if(old('payable_currency') == 'LTC') selected @endif>{{trans('withdraw/usd.Litecoin')}}</option>
                                <option value="XMR" @if(old('payable_currency') == 'XMR') selected @endif>{{trans('withdraw/usd.Monereo')}}</option>
                                <option value="LTCT" @if(old('payable_currency') == 'LTCT') selected @endif>{{trans('withdraw/usd.Litecoin_Testnet')}}</option>
                            </select>
                            <span class="help-block text-danger">{{$errors->first('payable_currency') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('address')?' has-error':' has-feedback' }}">
                            <label>{{trans('withdraw/usd.Address')}}:</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            <span class="help-block text-danger">{{$errors->first('address') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group{{ $errors->has('amount')?' has-error':' has-feedback' }}">
                            <label>USD {{trans('withdraw/usd.Amount')}}:</label>
                            <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                            <span class="help-block text-danger">{{$errors->first('amount') }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-info" type="submit">{{trans('withdraw/usd.Proceed')}}</button>
                </div>
                </form>
                @endif
            </div>
		</div>
	</section>
</main> 


@endsection
