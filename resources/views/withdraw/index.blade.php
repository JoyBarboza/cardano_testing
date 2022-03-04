@php $exchange = new App\Repository\Exchange\ExchangeRepository(); $user = auth()->user(); @endphp
@extends('layouts.master')
@section('page-content')

<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('withdraw/index.Withdrawal_options')}}</h1>
            <div class="">
            @if(!\App\Presale::active()->exists())
                <div class="row">
                {{--
                    <div class="col-md-6 col-sm-6">
                        <div class="box box-inbox">
                            <div class="icon_hover">
                                <a href="{{ route('user.withdraw.currency', 'btc') }}">
                                    <div class="icon_container">
                                        <img src="{{ asset('images/icon010.png') }}" alt="img">
                                    </div>
                                    <span class="deposite_heading">{{trans('withdraw/index.Withdraw_bitcoins')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="box box-inbox">
                            <div class="icon_hover">
                                <a href="{{ route('user.withdraw.currency', 'jpc') }}">
                                    <div class="icon_container">
                                        <img src="{{ asset('images/home3/dep_jpc.png') }}" alt="img">
                                    </div>
                                    <span class="deposite_heading">{{trans('withdraw/index.Withdraw')}} JPC</span>
                                </a>
                            </div>
                        </div>
                    </div>
                --}}
                    <div class="col-md-6 col-sm-6">
                        <div class="box box-inbox">
                            <div class="icon_hover">
                                <a href="{{ route('user.withdraw.currency', 'usd') }}">
                                    <div class="icon_container">
                                        <img src="{{ asset('images/home3/dep_usd.png') }}" alt="img">
                                    </div>
                                    <span class="deposite_heading">{{trans('withdraw/index.Withdraw')}} USD</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    

                {{--
                    <div class="col-md-6 col-sm-6">
                        <div class="box box-inbox">
                            <div class="icon_hover">
                                <a href="{{ route('user.withdraw.currency', 'dash') }}">
                                    <div class="icon_container">
                                        <img src="{{ asset('images/icon05.png') }}" alt="img">
                                    </div>
                                    <span class="deposite_heading">{{trans('withdraw/index.Withdraw')}} DASH</span>
                                </a>
                            </div>
                        </div>
                    </div>
                --}}
                </div>
                @else
                 <div class="col-md-6 col-sm-6">
                        <div class="box box-inbox">
                            <div class="icon_hover">
                                <a href="{{ route('user.withdraw.currency', 'msc') }}">
                                    <div class="icon_container">
                                        <i class='fa fa-arrow-up fa-2x'></i>
                                    </div>
                                    <span class="deposite_heading">{{trans('withdraw/index.Withdraw')}} Token</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <div class="col-md-12 col-sm-6">
                    <div class="well text-center">{{trans('withdraw/index.Currently_PreSale_coins')}}  <span class="text-danger">{{trans('withdraw/index.disabled')}}</span></div>
                </div>
            @endif
            </div>
		</div>
	</section>
</main> 


@endsection
