@extends('layouts.master')
@section('page-content')


<main>
	<section>
		<div class="rows">
			<h1 class="main_heading">{{trans('deposit/index.Deposit_options')}}</h1>
			<div class="row">
			{{--
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'btc') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon010.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_Bitcoin')}}</span>
						</a>
					</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'bch') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon04.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_BITCOIN_CASH')}}</span>
						</a>
					</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'eth') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon04.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_ETHERIUM')}}</span>
						</a>
					</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'ltc') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon04.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_LITECOIN')}}</span>
						</a>
					</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'xmr') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon04.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_MONERO')}}</span>
						</a>
					</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'dash') }}">
							<div class="icon_container">
								<img src="{{ asset('images/icon05.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_DASH')}}</span>
						</a>
					</div>
					</div>
				</div>
			
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'msc') }}">
							<div class="icon_container">
								<img src="{{ asset('images/home3/dep_jpc.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_JPC')}}</span>
						</a>
					</div>
					</div>
				</div>--}}
				<div class="col-md-6 col-sm-6">
					<div class="box box-inbox">
					<div class="icon_hover">
						<a href="{{ route('user.deposit.currency', 'usd') }}">
							<div class="icon_container">
								<img src="{{ asset('images/home3/dep_usd.png') }}" alt="img">
							</div>
							<span class="deposite_heading">{{trans('deposit/index.Deposit_USD')}}</span>
						</a>
					</div>
					</div>
				</div>
			</div>
           
		</div>
	</section>
</main> 




@endsection
