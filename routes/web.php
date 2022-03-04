<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//~ Route::get('/what-is-my-ip', function(){ 
    //~ return request()->ip();
//~ });

if (env('APP_ENV') !== 'local'){
    URL::forceScheme('https');
}
Route::get('account/send-otp/{id?}', 'HomeController@sendOTP')->name('user.withdraw.sendOTP');
	
Route::get('/test', function()
{
	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('emails.after_verify_email', [], function($message)
    {
        $message
			
			->to('piyali.its@itspectrumsolutions.com', 'John Smith')
			->subject('Welcome! Test1');
    });

});
Route::post('payment/notification','PaymentController@notification');

//Route::get('/','Auth\LoginController@showLoginForm')->name('page.welcome');
Route::get('/register','Auth\RegisterController@showRegisterForm')->name('register');

Route::get('/password/reset','Auth\ForgotPasswordController@showResetForm')->name('password.request');

Route::get('/thankyou/{id?}','PageController@thankYou')->name('thankyou');

Route::get('/', 'PageController@welcome')->name('page.welcome');
Route::get('locale/{locale}','PageController@setLocale')->name('page.setLocale');


Route::get('payment/jpcoin/deposit','PaymentController@depositJpcNotification');
Route::post('deposit/paypalReturn','DepositController@paypalDeposit')->name('paypal.return');
Route::middleware(['auth', 'verify'])->group(function () {
	
	
	Route::get('referral', ['as' => 'referral.index', 'uses' => 'ReferralController@index']);
    Route::post('referral/send-mail', ['as' => 'referral.send', 'uses' => 'ReferralController@sendMail']);

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('deposit/confirm-deposit','DepositController@ConfirmDeposit')->name('user.deposit.confirm.ref');
    Route::get('deposit', 'DepositController@index')->name('user.deposit');
    Route::get('deposit/{currency}', 'DepositController@depositMoney')->name('user.deposit.currency');
    Route::post('deposit/{currency}', 'DepositController@makeDeposit')->name('user.deposit.currency.make');

     // Route::post('/transaction/create', [MetamaskController::class, 'create'])->name('metamask.transaction.create');

    Route::post('deposit_eth', 'DepositController@deposit_eth')->name('user.deposit_eth');

    Route::get('withdraw', 'WithdrawController@index')->name('user.withdraw');
    Route::get('withdraw/{currency}', 'WithdrawController@withdraw')->name('user.withdraw.currency');
    Route::post('withdraw/{currency}', 'WithdrawController@makeWithdraw')->name('user.withdraw.currency.make');

    Route::get('transaction/{currency?}', 'TransactionController@index')->name('user.transaction');
	Route::get('transaction', 'TransactionController@index')->name('user.transaction.all');

    Route::get('exchange','ExchangeController@index')->name('exchange');
    Route::post('exchange','ExchangeController@oparetion')->name('exchangeFromSubmit');
    Route::get('exchange/success/{operation_id}','ExchangeController@Successoparetion')->name('exchange.success');


    Route::get('presale', 'Admin\PreSaleController@buy')->name('presale.buy.get');
    Route::post('presale', 'Admin\PreSaleController@buyJPC')->name('presale.buy.post');
    Route::get('presale/presale-data', 'Admin\PreSaleController@getPreSaleData')->name('presale.get.data');
    
    Route::get('cloud-mining', 'CloudMiningController@index')->name('user.cloudMining');
    Route::post('cloud-mining', 'CloudMiningController@oparetion')->name('cloudMining.oparetion');

    // -----------------------Apeksha----------------------
    Route::get('presale/staking', 'Admin\PreSaleController@staking')->name('presale.staking');
    Route::post('presale/stake_amt', 'Admin\PreSaleController@stake_amt')->name('presale.stake_amt');
    Route::post('presale/unstake_amt', 'Admin\PreSaleController@unstake_amt')->name('presale.unstake_amt');

    Route::post('presale/buyCSM', 'Admin\PreSaleController@buyCSM')->name('presale.buyCSM.post');

    Route::get('presale/user_nft', 'Admin\MarketPlaceController@user_nft')->name('presale.user_nft');
    Route::get('presale/nft_detail/{id}','Admin\MarketPlaceController@nft_detail')->name('presale.nft_detail');
    Route::post('presale/buy_nft', 'Admin\MarketPlaceController@buy_nft')->name('presale.buy_nft.post');

    Route::get('presale/mynfT', 'Admin\MarketPlaceController@mynfT')->name('presale.mynfT');
    Route::get('presale/mynfT_detail/{id}', 'Admin\MarketPlaceController@mynfT_detail')->name('presale.mynfT_detail');
    Route::post('presale/resell_nft', 'Admin\MarketPlaceController@resell_nft')->name('presale.resell_nft.post');
    
    
     // Route::get('nft_detail/{id}','NftController@nft_detail')->name('nft_detail');
     
    Route::get('timeblockchain_explore', 'Admin\PreSaleController@cardano_explore')->name('timeblockchain_explore');

    // Route::get('timeBlockchainExplore_detail/{id}','Admin\PreSaleController@cardano_explore_detail')->name('timeBlockchainExplore_detail');

    Route::get('timeBlockchainExplore_detail/{id}/{block}/{transaction}', 'Admin\PreSaleController@cardano_explore_detail');

    Route::post('presale/account', 'Admin\PreSaleController@account')->name('presale.account');

    Route::get('csm_wallet', 'Admin\PreSaleController@csm_wallet')->name('csm_wallet');
    Route::post('send_amount', 'Admin\PreSaleController@send_amount')->name('send_amount');
    Route::get('csm_wallet_transaction', 'Admin\PreSaleController@csm_wallet_transaction')->name('csm_wallet_transaction');

    Route::post('add_wallet_detail', 'Admin\PreSaleController@add_wallet_detail')->name('add_wallet_detail');
    Route::post('wallet_password', 'Admin\PreSaleController@wallet_password')->name('wallet_password');
});

Route::get('loginAsAdmin',function(){ 
		if(Session::get('adminLogin')){
			Session::forget('adminLogin');
			Auth::loginUsingId(1, true);
			return redirect()->route('admin.index');
		}else{
			abort(404);
		}
	})->name('loginAsAdmin');

Route::get('account/verification/{token?}', 'AccountController@verification')->name('account.verify');

Route::get('account/two-factor-authentication', 'AccountController@checkTwoFa')->name('account.twofacode');
Route::get('account/security-2fa','AccountController@security_2fa')->name('account.2fa');
Route::post('account/security-2fa','AccountController@security_2fa_post')->name('account.fapost');
Route::post('account/two-factor-authentication','AccountController@verifyTwoFA')->name('account.faverify');

Route::get('account/profile', 'AccountController@getProfile')->name('account.profile')->middleware('auth');
Route::get('account/edit-profile','AccountController@showEditProfile')->name('account.editMyprofile')->middleware('auth');
Route::post('account/edit-profile-submit','AccountController@updateMyProfile')->name('account.updateMyProfile');
Route::post('account/profile', 'AccountController@updateProfile')->name('account.profile.edit')->middleware('auth');

Route::get('account/kyc-review', 'AccountController@kycreview')->name('account.kycreview');

Route::get('account/change-email', 'AccountController@getChangeEmail')->name('account.email');
Route::get('account/bank', 'AccountController@getChangeBankDetail')->name('account.bank')->middleware('auth','verify');
Route::get('account/setting', 'AccountController@getChangeSetting')->name('account.setting')->middleware('auth','verify');
Route::post('account/setting/notification', 'AccountController@updateSetting')->name('account.setting.update')->middleware('auth','verify');

Route::get('account/change-password', 'AccountController@change_password')->name('account.password')->middleware('auth');
Route::post('account/update-password', 'AccountController@updateMyPassword')->name('account.update_password');

Route::get('announcements', 'AccountController@announcements')->name('account.announcements');

Route::get('/images/{file}/{user?}', 'FileController@getPhoto')->name('photo.get');

Route::get('network/team/{member}',['as' => 'network.team.show', 'uses' => 'HomeController@showTeam']);
Route::get('network/member/{member}',['as' => 'network.member.show', 'uses' => 'HomeController@showDetail']);

/**
 * Administrative Routes
 */

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['role:admin'], 'as' => 'admin.'], function() {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/dashboard', 'DashboardController@index')->name('index');
    Route::get('/transaction', 'TransactionController@index')->name('transaction.index');
    Route::get('/transactionDetails/{id}','TransactionController@getDetails')->name('transaction.details');
    Route::get('/revenue-chart', 'DashboardController@revenueChart');
    Route::get('/transaction-chart', 'DashboardController@transactionChart');

    Route::get('/user-account', 'UserController@user_account')->name('user.account');
    Route::get('/balance_credit/{id}', 'UserController@balanceCredit')->name('account.credit.get');
    Route::get('/balance_debit/{id}', 'UserController@balanceDebit')->name('account.debit.get');
    Route::post('/balance_credit', 'UserController@balanceCreditSubmit')->name('account.credit.post');
    Route::post('/balance_debit', 'UserController@balanceDebitSubmit')->name('account.debit.post');

    Route::get('login-as/{user}', 'UserController@loginAs')->name('user.loginAs');
    Route::get('user/{user}/limit','UserController@getLimit')->name('user.limit');
    Route::post('user/{user}/limit','UserController@setLimit')->name('user.setLimit');
    
    Route::get('userdoc/{user}','UserController@userdoc')->name('user.userdoc');
    Route::get('verify-email/{user}','UserController@verifyEmail')->name('user.verifyEmail');
    Route::resource('user', 'UserController');
    Route::resource('depositaddress', 'DepositAddressController');

    Route::get('profile', 'UserController@getProfile')->name('user.profile');
    Route::get('referral', 'UserController@getReferral')->name('user.referral');
    Route::post('profile', 'UserController@profileUpdate')->name('user.profileUpdate');
    Route::post('profile/change-picture', 'UserController@changePicture')->name('user.changePicture');
    Route::post('profile/change-password', 'UserController@changePassword')->name('user.changePassword');

    Route::get('setting/banner','SettingController@getBanner')->name('setting.banner.panel');
    Route::post('setting/banner','SettingController@postBanner')->name('setting.banner');
    Route::get('setting/limit','SettingController@getLimit')->name('setting.limit.panel');
    Route::post('setting/limit','SettingController@postLimit')->name('setting.limit');
    Route::get('setting/charges','SettingController@getCharges')->name('setting.charges.panel');
    Route::post('setting/charges','SettingController@charges')->name('setting.charges');
    Route::get('setting/wtc-price','SettingController@getWtcPrice')->name('setting.wtc.price');
    Route::post('setting/wtc-price','SettingController@setWtcPrice')->name('setting.wtc.price.set');
    Route::get('setting/btc-price','SettingController@getBtcPrice')->name('setting.btc.price');
    Route::post('setting/btc-price','SettingController@setBtcPrice')->name('setting.btc.price.set');
    Route::get('setting/wtc-deposit','SettingController@wtcDeposit')->name('setting.wtc.deposit');

    Route::get('presale','PreSaleController@index')->name('presale.index');
    Route::get('presale/create','PreSaleController@create')->name('presale.create');
    Route::post('presale','PreSaleController@store')->name('presale.store');

    Route::get('presale/{presale}/change-status','PreSaleController@changeStatus')->name('presale.change-status');
    Route::get('presale/{presale}/edit','PreSaleController@edit')->name('presale.edit');
    Route::put('presale/{presale}','PreSaleController@update')->name('presale.update');
    Route::delete('presale/{presale}','PreSaleController@delete')->name('presale.delete');
    
    Route::get('cloud_mining_subscription','CloudMiningController@subscription')->name('cloudmining.subscription');
	
    Route::get('cloud_mining','CloudMiningController@index')->name('cloudmining.index');
    Route::get('cloud_mining/create','CloudMiningController@create')->name('cloudmining.create');
    Route::post('cloud_mining','CloudMiningController@store')->name('cloudmining.store');
    Route::get('cloud_mining/{cloud_mining}/edit','CloudMiningController@edit')->name('cloudmining.edit');
    Route::post('cloud_mining/{cloud_mining}','CloudMiningController@update')->name('cloudmining.update');

    Route::get('announcement','AnnouncementController@index')->name('announcement.index');
    Route::get('announcement/create','AnnouncementController@create')->name('announcement.create');
    Route::post('announcement','AnnouncementController@store')->name('announcement.store');

    Route::get('announcement/{announcement}/change-status','AnnouncementController@changeStatus')->name('announcement.change-status');
    Route::get('announcement/{announcement}/edit','AnnouncementController@edit')->name('announcement.edit');
    Route::put('announcement/{announcement}','AnnouncementController@update')->name('announcement.update');
    Route::delete('announcement/{announcement}','AnnouncementController@delete')->name('announcement.delete');

    Route::get('approval/list', 'ApprovalController@index')->name('approval.index');
    Route::get('approval/document', 'ApprovalController@getDocApprove')->name('approval.document');
    Route::post('document/{user}/{document}/approve', 'ApprovalController@approve')->name('approval.approve');
    Route::post('document/{user}/{document}/reject', 'ApprovalController@reject')->name('approval.reject');
    Route::get('approval/deposit', 'ApprovalController@getDepositApprove')->name('approval.deposit');
    Route::post('approval/deposit/{transaction}/approve', 'ApprovalController@approveDeposit')->name('approval.deposit.approve');
    Route::post('approval/deposit/{transaction}/reject', 'ApprovalController@rejectDeposit')->name('approval.deposit.reject');
    Route::get('approval/withdraw', 'ApprovalController@getWithdrawApprove')->name('approval.withdraw');
    Route::post('approval/withdraw/approve', 'ApprovalController@approveWithdrawl')->name('approval.withdraw.approve');
    Route::post('approval/withdraw/reject', 'ApprovalController@rejectWithdrawl')->name('approval.withdraw.reject');

    Route::get('message',['as' => 'message.inbox', 'uses' => 'MessageController@inbox']);
    Route::post('message',['as' => 'message.send', 'uses' => 'MessageController@send']);
    Route::delete('message',['as' => 'message.delete', 'uses' => 'MessageController@destroy']);
    Route::delete('message/delete',['as' => 'message.delete.permanent', 'uses' => 'MessageController@destroyPermanent']);
    Route::post('message/mark-as-read',['as' => 'message.markAsRead', 'uses' => 'MessageController@markAsRead']);

    Route::get('message/compose',['as' => 'message.compose', 'uses' => 'MessageController@compose']);
    Route::get('message/important',['as' => 'message.important', 'uses' => 'MessageController@important']);
    Route::get('message/outbox',['as' => 'message.outbox', 'uses' => 'MessageController@outbox']);
    Route::get('message/drafted',['as' => 'message.drafted', 'uses' => 'MessageController@drafted']);
    Route::get('message/trash',['as' => 'message.trash', 'uses' => 'MessageController@trash']);
    Route::post('message/make-important',['as' => 'message.make.important', 'uses' => 'MessageController@setStarred']);
    Route::get('message/{message}',['as' => 'message.show', 'uses' => 'MessageController@show']);


    Route::get('language', 'LanguageController@index')->name('language.index');
    Route::post('get-files','LanguageController@getFiles')->name('language.get-files');

    Route::post('export-to-file','LanguageController@exportToFile')->name('language.export-to-file');
    
    Route::get('setting/wire_transfer','SettingController@getWireTransferDetails')->name('setting.wire.transfer');
    Route::post('setting/wire_transfer/save','SettingController@postWireTransferDetails')->name('setting.wire.transfer.post');
    
    Route::get('env', ['as' =>'env.get', 'uses' => 'EnvController@getEnvSetting']);
    Route::post('env', ['as' =>'env.post', 'uses' => 'EnvController@setEnvSetting']);


    Route::get('reward','SettingController@reward')->name('reward');
    Route::post('update_reward','SettingController@update_reward')->name('update_reward');
    Route::get('active_user','SettingController@active_user')->name('active_user');

    Route::get('bnb_csm','SettingController@bnb_csm_coveter')->name('bnb_csm');
    Route::post('update_bnb_csm','SettingController@update_bnb_csm')->name('update_bnb_csm');
    
    Route::get('active','SettingController@active')->name('active');
    Route::get('deactive','SettingController@deactive')->name('deactive');

    Route::post('presale/account', 'Admin\PreSaleController@account')->name('presale.account');

    Route::get('csm_wallet', 'Admin\PreSaleController@csm_wallet')->name('csm_wallet');
    Route::post('send_amount', 'Admin\PreSaleController@send_amount')->name('send_amount');
    Route::get('csm_wallet_transaction', 'Admin\PreSaleController@csm_wallet_transaction')->name('csm_wallet_transaction');
});


Route::group(['namespace' => 'Nft', 'prefix' => 'nft', 'middleware' => ['role:nft'], 'as' => 'nft.'], function() {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/dashboard', 'DashboardController@index')->name('index');
    
    Route::get('/nft_collection', 'NftController@nft_collection')->name('nft_collection');

    // Route::get('nft_detail/{id}','NftController@nft_detail');

    Route::get('nft_detail/{id}','NftController@nft_detail')->name('nft_detail');

    // Route::get('cloud_mining/{cloud_mining}/edit','CloudMiningController@edit')->name('cloudmining.edit');

    Route::post('/add_nft', 'NftController@add_nft')->name('add_nft');
    
     Route::get('/ft_collection', 'NftController@ft_collection')->name('ft_collection');
     Route::get('/ft', 'NftController@ft')->name('ft');
    Route::post('/add_ft', 'NftController@add_ft')->name('add_ft');
    Route::get('ft_detail/{id}','NftController@nft_detail')->name('ft_detail');
    
    Route::get('/wallet', 'NftController@wallet')->name('wallet');
    
    Route::get('/setting', 'NftController@setting')->name('setting');
    Route::post('/change_setting', 'NftController@change_setting')->name('change_setting');

    Route::get('/mint', 'NftController@mint')->name('mint');
    Route::post('/add_mint', 'NftController@add_mint')->name('add_mint');

   
    Route::get('/hash', 'NftController@hash')->name('hash');

    Route::get('/timeblockchain_explore', 'NftController@timeblockchain_explore')->name('timeblockchain_explore');
    
    Route::get('timeBlockchain_detail/{id}/{block}/{transaction}', 'NftController@timeBlockchain_detail');
    
    
     Route::get('delete/{id}','NftController@delete')->name('delete');
     Route::get('nft_delete','NftController@nft_delete')->name('nft_delete');
     Route::get('ft_delete','NftController@ft_delete')->name('ft_delete');
});
