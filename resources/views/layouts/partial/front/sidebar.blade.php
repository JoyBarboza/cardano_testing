
<section class="vertical-navigation left">
	<div class="user-profile">
		<div class="user-img">
			<a href="{{ route('account.profile') }}" title="Profile">
			@php $image = auth()->user()->document()->where('name','PHOTO')->first();
            $basepath = 'public'.DIRECTORY_SEPARATOR.auth()->user()->username @endphp
				<div class="img">
					@if((auth()->user()->document()->where('name','PHOTO')->exists()))
                    <img src="{{route('photo.get',[$image['location'],auth()->user()->username])}}" alt="">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" alt="">
                    @endif
					
				</div>
				<div class="status-color blue heartbit style1"></div>
			</a>
		</div>
		<ul class="user-options">
			<li class="name">{{auth()->user()->first_name.' '.auth()->user()->last_name}}</li>
		</ul>
	</div>
	<ul class="sidebar-nav">
		<li class="dashboard waves-effect waves-teal {{request()->is('*/home')?' active':''}}">
			<a href="{{ route('home') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/wallets.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.wallets')}}</span>
			</a>
		</li>
		<li class="message waves-effect waves-teal {{request()->is('*/presale')?' active':''}}">
			<a href="{{ route('presale.buy.get') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/presale.png" alt="">
				</div>
				<span>Buy Now</span>
			</a>
		</li>
		<li class="calendar waves-effect waves-teal {{request()->is('*/deposit')?' active':''}} {{request()->is('*/deposit/usd')?' active':''}}">
			<a href="{{ route('user.deposit') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/deposit.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.deposit')}}</span>
			</a>
		</li>
		<li class="pages waves-effect waves-teal {{request()->is('*/withdraw')?' active':''}}">
			<a href="{{ route('user.withdraw.currency', 'msc') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/withdraw.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.withdraw')}}</span>
			</a>
		</li>
		<li class="apps waves-effect waves-teal {{request()->is('*/transaction')?' active':''}}">
			<a href="{{ route('user.transaction.all') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/transaction.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.transaction')}}</span>
			</a>
		</li>
		<li class="menu__item {{request()->is('*/cloud-mining')?' active open':''}}">
            <a class="menu__link" href="{{ route('user.cloudMining') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/cloud.png?fg" alt="">
				</div>
                <span class="menu__link-text">
                    {{trans('layouts/partial/user/sidebar.cloud_mining')}}
                </span>
            </a>
        </li>
		@if(Session::get('adminLogin'))
        <li class="menu__item {{request()->is('*/loginAsAdmin')?' active open':''}}">
            <a class="menu__link" href="{{ route('loginAsAdmin') }}">
				<div class="img-nav">
					<img src="/masonicoin/img/back.png?fth" alt="">
				</div>
                <span class="menu__link-text">
                {{trans('layouts/partial/user/sidebar.Back_to_Admin')}}
                </span>
            </a>
        </li>
		@endif
		
	</ul>
</section>








