<!-- deposite_menu -->
<div class="deposite_menu" style="display:none;">
<div class="container">
    <ul>
        <li><a href="{{ route('home') }}"><div class="icon_wallet w_icon01"></div><span>{{trans('layouts/partial/user/user_balance.wallets')}}</span></a></li>
        <li><a href="{{ route('user.deposit') }}"><div class="icon_wallet w_icon03"></div><span>{{trans('layouts/partial/user/user_balance.deposit')}}</span></a></li>
        <li><a href="{{ route('user.withdraw') }}"><div class="icon_wallet w_icon04"></div><span>{{trans('layouts/partial/user/user_balance.withdraw')}}</span></a></li>
        <li><a href="{{ route('user.transaction.all') }}"><div class="icon_wallet w_icon04"></div><span>{{trans('layouts/partial/user/user_balance.transaction')}}</span></a></li>
<!--
        <li><a href="{{ route('exchange') }}"><div class="icon_wallet w_icon02"></div><span>{{trans('layouts/partial/user/user_balance.exchange')}}</span></a></li>
-->
        <li><a href="{{ route('user.deposit.currency', 'jpc') }}"><div class="icon_wallet w_icon02"></div><span>{{trans('layouts/partial/user/user_balance.presale')}}</span></a></li>
    </ul>
</div>
</div>
<!-- deposite_menu -->
