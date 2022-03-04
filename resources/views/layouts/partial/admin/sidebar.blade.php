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

            <li class="nav-item{{request()->is('*/admin/dashboard')?' start active':''}}">
                <a href="{{ route('admin.index') }}" class="nav-link nav-toggle">
                    <i class="icon-speedometer"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.dashboard')}}</span>
                    @if(request()->is('*/admin/dashboard'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            <li class="nav-item{{request()->is('*/admin/user')?' active open':''}}">
                <a href="{{ route('admin.user.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.members')}}</span>
                    @if(request()->is('*/admin/user'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
            
            <!-- <li class="nav-item{{request()->is('*/admin/user-account')?' active open':''}}">
                <a href="{{ route('admin.user.account') }}" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.accounts')}}</span>
                    @if(request()->is('*/admin/user-account'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->

            <li class="nav-item{{request()->is('*/admin/transaction')?' active open':''}}">
                <a href="{{ route('admin.transaction.index') }}" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.transactions')}}</span>
                    @if(request()->is('*/admin/transaction'))
                        <span class="selected"></span>
                    @endif
                </a>            
            </li>
			<li class="nav-item{{request()->is('*/admin/language')?' active open':''}}">
				<a href="{{ route('admin.language.index') }}" class="nav-link">
					<i class="icon-speech"></i>
					<span class="title">{{trans('layouts/partial/admin/sidebar.language')}}</span>
					@if(request()->is('*/admin/language'))
						<span class="selected"></span>
					@endif
				</a>
			</li>


            <!-- <li class="nav-item{{request()->is('admin/approval/*')?' active open':''}}">
                <a href="javascript:void(0)" class="nav-link nav-toggle">
                    <i class="icon-check"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.approval')}}</span>
                    <span class="arrow{{request()->is('admin/approval/*')?' open':''}}"></span>
                    @if(request()->is('admin/approval/*'))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul class="sub-menu">
                    {{--<li class="nav-item{{request()->is('admin/approval/list')?' active open':''}}">
                        <a href="{{ route('admin.approval.index') }}" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.list')}}</span>
                            @if(request()->is('admin/approval/list'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>--}}
                   {{-- <li class="nav-item{{request()->is('admin/approval/document')?' active open':''}}">
                        @php
                            $pendingDoc = App\Document::pending()->count();
                        @endphp
                        @if($pendingDoc)
                            <span class="badge badge-danger" style="position: absolute;left:10px;z-index: 2;">
                                {{ $pendingDoc }}
                            </span>
                        @endif
                        <a href="{{ route('admin.approval.document') }}" class="nav-link ">
                            <i class="icon-doc"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.document')}}</span>
                            @if(request()->is('admin/approval/document'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>--}}
                    {{--<li class="nav-item{{request()->is('admin/approval/withdraw')?' active open':''}}">
                        @php
                            $pendingWithdrawl = App\Transaction::whereHas('payment', function($query){
                                $query->where('payments.remarks', 'bankwithdrawl');
                            })->incomplete()->count();
                        @endphp
                        @if($pendingWithdrawl)
                            <span class="badge badge-danger" style="position: absolute;left:10px;z-index: 2;">
                                {{ $pendingWithdrawl }}
                            </span>
                        @endif
                        <a href="{{ route('admin.approval.withdraw') }}" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.withdrawal')}}</span>
                            @if(request()->is('admin/approval/withdraw'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>--}}

                    <li class="nav-item{{request()->is('admin/approval/deposit')?' active open':''}}">
                        @php
                            $pendingDeposit = App\Transaction::whereHas('payment', function($query){
                            $query->where('payments.remarks', 'bankdeposit');
                            })->incomplete()->count();
                        @endphp
                        @if($pendingDeposit)
                            <span class="badge badge-danger" style="position: absolute;left:10px;z-index: 2;">
                                {{ $pendingDeposit }}
                            </span>
                        @endif
                        <a href="{{ route('admin.approval.deposit') }}" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.Bank_Deposit')}}</span>
                            @if(request()->is('admin/approval/deposit'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item{{request()->is('admin/approval/withdraw')?' active open':''}}">
                        
                        
                        <a href="{{ route('admin.approval.withdraw') }}" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.withdrawal')}}</span>
                            @if(request()->is('admin/approval/withdraw'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li> -->

            {{--<li class="nav-item{{request()->is('admin/message')?' active open':''}}">
                <a href="{{ route('admin.message.inbox') }}" class="nav-link nav-toggle">
                    <i class="fa fa-envelope"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.message')}}</span>
                    @if(request()->is('admin/message'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>--}}

            <!-- <li class="nav-item{{request()->is('*/admin/presale')?' active open':''}}">
                <a href="{{ route('admin.presale.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-envelope"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.presale')}}</span>
                    @if(request()->is('*/admin/presale'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->
            <li class="nav-item{{request()->is('*/admin/announcement')?' active open':''}}">
                <a href="{{ route('admin.announcement.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-bullhorn"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.announcement')}}</span>
                    @if(request()->is('*/admin/announcement'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
            {{--<li class="nav-item{{request()->is('admin/presalelist')?' active open':''}}">
                <a href="{{ route('admin.setting.set.preSaleList') }}" class="nav-link nav-toggle">
                    <i class="fa fa-envelope"></i>
                    <span class="title">Presale List</span>
                    @if(request()->is('admin/presalelist'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>--}}

            <!-- <li class="nav-item{{request()->is('*/admin/referral')?' active open':''}}">
                <a href="{{ route('admin.user.referral') }}" class="nav-link nav-toggle">
                    <i class="fa fa-medium"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.referral')}}</span>
                    @if(request()->is('*/admin/referral'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li> -->

            <!-- <li class="nav-item{{request()->is('*/admin/setting/*')?' active open':''}}">
                <a href="#" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{trans('layouts/partial/admin/sidebar.setting')}}</span>
                    <span class="arrow{{request()->is('admin/setting/*')?' open':''}}"></span>
                    @if(request()->is('*/admin/setting/*'))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul class="sub-menu">
					{{--<li class="nav-item{{request()->is('*/admin/setting/wire_transfer')?' active open':''}}">
                        <a href="{{ route('admin.setting.wire.transfer') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.Wire_Transfer')}}</span>
                            @if(request()->is('*/admin/setting/wire_transfer'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>--}}
                    <li class="nav-item{{request()->is('*/admin/setting/env')?' active open':''}}">
                        <a href="{{ route('admin.env.get') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.Env_settings')}}</span>
                            @if(request()->is('*/admin/setting/env'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item{{request()->is('*/admin/depositaddress/index')?' active open':''}}">
                        <a href="{{ route('admin.depositaddress.index') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">Deposit Address</span>
                            @if(request()->is('*/admin/depositaddress/index'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>
                   {{-- <li class="nav-item{{request()->is('*/admin/setting/banner')?' active open':''}}">
                        <a href="{{ route('admin.setting.banner.panel') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.banner')}}</span>
                            @if(request()->is('*/admin/setting/banner'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item{{request()->is('*/admin/setting/limit')?' active open':''}}">
                        <a href="{{ route('admin.setting.limit.panel') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.limits')}}</span>
                            @if(request()->is('*/admin/setting/limit'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item{{request()->is('*/admin/setting/charges')?' active open':''}}">
                        <a href="{{ route('admin.setting.charges.panel') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.charges')}}</span>
                            @if(request()->is('*/admin/setting/charges'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>

                   <li class="nav-item{{request()->is('*/admin/setting/wtc-price')?' active open':''}}">
                        <a href="{{ route('admin.setting.wtc.price') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.jpc_tricker_price')}}</span>
                            @if(request()->is('*/admin/setting/wtc-price'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item{{request()->is('*/admin/setting/btc-price')?' active open':''}}">
                        <a href="{{ route('admin.setting.btc.price') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title"> {{trans('layouts/partial/admin/sidebar.btc_tricker_price')}}</span>
                            @if(request()->is('*/admin/setting/btc-price'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item{{request()->is('*/admin/setting/wtc-deposit')?' active open':''}}">
                        <a href="{{ route('admin.setting.wtc.deposit') }}" class="nav-link">
                            <i class="icon-graph"></i>
                            <span class="title">{{trans('layouts/partial/admin/sidebar.jpc_deposit')}}</span>
                            @if(request()->is('*/admin/setting/wtc-deposit'))
                                <span class="selected"></span>
                            @endif
                        </a>
                    </li>--}}
               </ul>
            </li> -->
            
            <!-- <li class="nav-item{{request()->is('*/admin/cloud_mining/*')?' active open':''}}">
				<a href="{{ route('admin.cloudmining.index') }}" class="nav-link">
					<i class="icon-list"></i>
					<span class="title">{{trans('layouts/partial/admin/sidebar.cloud_mining')}}</span>
					@if(request()->is('*/admin/cloud_mining/*'))
						<span class="selected"></span>
					@endif
				</a>
			</li> -->
			
			<!-- <li class="nav-item{{request()->is('*/admin/cloud_mining_subscription')?' active open':''}}">
				<a href="{{ route('admin.cloudmining.subscription') }}" class="nav-link">
					<i class="icon-info"></i>
					<span class="title">{{trans('layouts/partial/admin/sidebar.cloud_mining_subscription')}}</span>
					@if(request()->is('*/admin/cloud_mining_subscription'))
						<span class="selected"></span>
					@endif
				</a>
			</li> -->

            <li class="nav-item{{request()->is('*/admin/bnb_csm')?' active open':''}}">
                <a href="{{ route('admin.bnb_csm') }}" class="nav-link">
                    <i class="icon-info"></i>
                    <span class="title">BNB To CSM</span>
                    @if(request()->is('*/admin/bnb_csm'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            <li class="nav-item{{request()->is('*/admin/reward')?' active open':''}}">
                <a href="{{ route('admin.reward') }}" class="nav-link">
                    <i class="icon-info"></i>
                    <span class="title">Reward</span>
                    @if(request()->is('*/admin/reward'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>

            <li class="nav-item{{request()->is('*/admin/active_user')?' active open':''}}">
                <a href="{{ route('admin.active_user') }}" class="nav-link">
                    <i class="icon-info"></i>
                    <span class="title">Active User</span>
                    @if(request()->is('*/admin/active_user'))
                        <span class="selected"></span>
                    @endif
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    
</div>
<!-- END SIDEBAR -->
