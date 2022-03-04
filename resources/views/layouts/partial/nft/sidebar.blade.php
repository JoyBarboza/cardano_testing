<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->

           <!--  <li class="nav-item{{request()->is('*/admin/dashboard')?' start active':''}}">
                <a href="{{ route('admin.index') }}" class="nav-link nav-toggle">
                    <i class="icon-speedometer"></i>
                    <span class="title">{{trans('nft.dashboard')}}</span>
                    @if(request()->is('*/admin/dashboard'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->

            <li class="nav-item{{request()->is('*/nft/nft_collection')?' active open':''}}">
                <a href="{{ route('nft.nft_collection') }}" class="nav-link nav-toggle">
                    <i class="icon-list"></i>
                    <span class="title">{{trans('nft.nft_collection')}}</span>
                    @if(request()->is('*/admin/user'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
            
            <!-- <li class="nav-item{{request()->is('*/nft/ft_collection')?' active open':''}} || {{request()->is('*/nft/ft')?' active open':''}}">
                <a href="{{ route('nft.ft_collection') }}" class="nav-link nav-toggle">
                    <i class="icon-list"></i>
                    <span class="title">FT Collection</span>
                    @if(request()->is('*/admin/user'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->
            
           <!--  <li class="nav-item{{request()->is('*/nft/wallet/*')?' active open':''}}">
				<a href="{{ route('nft.wallet') }}" class="nav-link">
					<i class="icon-list"></i>
					<span class="title">{{trans('nft.wallet')}}</span>
					@if(request()->is('*/admin/cloud_mining/*'))
						<span class="selected"></span>
					@endif
				</a>
			</li> -->
			
			<li class="nav-item{{request()->is('*/nft/setting')?' active open':''}}">
				<a href="{{ route('nft.setting') }}" class="nav-link">
					<i class="icon-list"></i>
					<span class="title">{{trans('nft.setting')}}</span>
					@if(request()->is('*/admin/cloud_mining_subscription'))
						<span class="selected"></span>
					@endif
				</a>
			</li>
            
           <!--  <li class="nav-item{{request()->is('*/nft/mint')?' active open':''}} ">
                <a href="{{ route('nft.mint') }}" class="nav-link">
                    <i class="icon-list"></i>
                    <span class="title">{{trans('nft.mint_item')}}</span>
                    @if(request()->is('*/admin/cloud_mining_subscription'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->

            <li class="nav-item{{request()->is('*/nft/hash')?' active open':''}}">
                <a href="{{ route('nft.hash') }}" class="nav-link">
                    <i class="icon-list"></i>
                    <span class="title">{{trans('nft.hash')}}</span>
                    @if(request()->is('*/admin/cloud_mining_subscription'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            

             <li class="nav-item{{request()->is('*/nft/timeblockchain_explore')?' active open':''}}">
                <!-- <a href="https://testnet.bscscan.com/address/0xb079120b0eb13f204752887a50f7327d51c15d5f" class="nav-link" target="_blank"> -->
                <a href="https://testnet.bscscan.com/address/0xb079120b0eb13f204752887a50f7327d51c15d5f" class="nav-link" target="_blank">
                    <i class="icon-list"></i>
                    <span class="title">View CSM BscScan</span>
                    @if(request()->is('*/admin/cloud_mining_subscription'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

           <!--  <li class="nav-item{{request()->is('*/nft/timeblockchain_explore')?' active open':''}}">
                <a href="{{ route('nft.timeblockchain_explore') }}" class="nav-link" target="_blank">
                    <i class="icon-list"></i>
                    <span class="title">{{trans('nft.timeblockchain_explore')}}</span>
                    @if(request()->is('*/admin/cloud_mining_subscription'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->

            <li class="nav-item{{request()->is('*/nft/timeblockchain_explore')?' active open':''}}">
                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                             <i class="icon-key"></i>
                                  {{trans('layouts/partial/admin/top_nav.logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    
</div>
<!-- END SIDEBAR -->
