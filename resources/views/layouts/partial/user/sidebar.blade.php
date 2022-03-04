<style>
.csm_btn{color: #fff;
background: #2ec3ee;
display: block;
text-align: center;
padding: 20px 8px;
}
</style>


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
	<!-- <a class="csm_btn" href="https://tronscan.org/#/token20/TCwH5iryiwfAHwRidQVeobG148eRonPS8U" target="_blank">View CSM Tronscan</a> -->
	<!--<a class="csm_btn" href="https://rinkeby.etherscan.io/token/0x76b6dea613f1e56ccb45294ac5787c77e91c335b" target="_blank">View CZM Etherscan</a>-->
	
	<!-- <a class="csm_btn" href="{{ route('timeblockchain_explore') }}" target="_blank">Time Blockchain Explorer</a> -->
	<a class="csm_btn" href="https://testnet.bscscan.com/address/0x009e685d8d02b525815294dd3853300dbd8adee9" target="_blank">View CSM BscScan</a>
	<a class="csm_btn" href="https://testnet.bscscan.com/address/0xb079120b0eb13f204752887a50f7327d51c15d5f" target="_blank">View NFT BscScan</a>
	<!-- <a class="csm_btn" href="https://testnet.bscscan.com/token/0xd4c3c31789c05712310e345efb90fb401b71cf0c?a=0x79319a973be6c6f0cbad2206ea4f6573a9ecf223" target="_blank">View CSM BscScan</a> -->

	<ul class="sidebar-nav">
		<li class="dashboard waves-effect waves-teal {{request()->is('*/home')?' active':''}}">
			<a href="{{ route('home') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/wallets.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.wallets')}}</span>
			</a>
		</li>
		<li class="message waves-effect waves-teal {{request()->is('*/presale')?' active':''}}">
			<a href="{{ route('presale.buy.get') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/buy-now.png" alt=""> 
				</div>
				<span>{{trans('layouts/partial/user/user_balance.buy_now')}}</span>
			</a>
		</li>
		<li class="message waves-effect waves-teal {{request()->is('*/presale')?' active':''}}">
			<a href="{{ route('presale.staking') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/wallets.png" alt="">
				</div>
				<span>Staking</span>
			</a>
		</li>
		<li class="message waves-effect waves-teal {{request()->is('*/presale')?' active':''}}">
			<a href="{{ route('presale.user_nft') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/wallets.png" alt="">
				</div>
				<span>MarketPlace</span>
			</a>
		</li>

		<li class="message waves-effect waves-teal {{request()->is('*/presale')?' active':''}}">
			<a href="{{ route('presale.mynfT') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/wallets.png" alt="">
				</div>
				<span>My NFT</span>
			</a>
		</li>
		<!-- <li class="calendar waves-effect waves-teal {{request()->is('*/deposit')?' active':''}} {{request()->is('*/deposit/usd')?' active':''}}">
			<a href="{{ route('user.deposit.currency', 'usd') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/deposit.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.deposit')}}</span>
			</a>
		</li> -->
		<!-- <li class="pages waves-effect waves-teal {{request()->is('*/withdraw')?' active':''}}">
			<a href="{{ route('user.withdraw') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/withdraw.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.withdraw')}}</span>
			</a>
		</li> -->
		<!-- <li class="apps waves-effect waves-teal {{request()->is('*/transaction')?' active':''}}">
			<a href="{{ route('user.transaction.all') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/transaction.png" alt="">
				</div>
				<span>{{trans('layouts/partial/user/user_balance.transaction')}}</span>
			</a>
		</li> -->
		<!--<li class="apps waves-effect waves-teal {{request()->is('*/transaction')?' active':''}}">-->
		<!--	<a href="{{ route('user.transaction.all') }}">-->
		<!--		<div class="img-nav">-->
		<!--			<img src="{{ url('/') }}/masonicoin/img/transaction.png" alt="">-->
		<!--		</div>-->
		<!--		<span>NFT</span>-->
		<!--	</a>-->
		<!--</li>-->
		<!-- <li class="menu__item {{request()->is('*/cloud-mining')?' active open':''}}">
            <a class="menu__link" href="{{ route('user.cloudMining') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/cloud.png?fg" alt="">
				</div>
                <span class="menu__link-text">
                    {{trans('layouts/partial/user/sidebar.cloud_mining')}}
                </span>
            </a>
        </li> -->
		@if(Session::get('adminLogin'))
        <li class="menu__item {{request()->is('*/loginAsAdmin')?' active open':''}}">
            <a class="menu__link" href="{{ route('loginAsAdmin') }}">
				<div class="img-nav">
					<img src="{{ url('/') }}/masonicoin/img/back.png?fth" alt="">
				</div>
                <span class="menu__link-text">
                {{trans('layouts/partial/user/sidebar.Back_to_Admin')}}
                </span>
            </a>
        </li>
		@endif
		
	</ul>
</section>








