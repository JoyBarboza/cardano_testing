@extends('layouts.front')
@section('content')


<div class="banner_bg banner-area middle_text">
        <div class="container">
            <div class="banner-content text-center">
                <img class="banner_logo" src="/time/images/logo.png?gh" alt="">
                <h1 class="title">Revolutionizing Blockchain in the Digital Gaming World </h1>

                <div class="mt-30 text-center">
                    <a class="main-btn" href="{{route('register')}}" ><i class="fal fa-arrow-right"></i> Register</a>
                </div>
            </div>
        </div>
    </div>

    <div class="security_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="image_hover">
                        <div class="image_body">
                            <h3>Digital wallet</h3>
                            <img class="team_image" src="time/images/icon/1.png" alt="img">
                         </div>
                        <div class="seoverlay">
                            <div class="text"><h3>Digital wallet</h3></div>
                            <img class="hover_image" src="time/images/icon/1.png" alt="img">
                         </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="image_hover">
                        <div class="image_body">
                            <h3>Increased security</h3>
                            <img class="team_image" src="time/images/icon/2.png" alt="img">
                        </div>
                        <div class="seoverlay">
                            <div class="text"><h3>Increased security</h3></div>
                            <img class="hover_image" src="time/images/icon/2.png" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="image_hover">
                        <div class="image_body">
                            <h3>Shared Network</h3>
                            <img class="team_image" src="time/images/icon/3.png" alt="img">
                        </div>
                        <div class="seoverlay">
                            <div class="text"><h3>Shared Network</h3></div>
                            <img class="hover_image" src="time/images/icon/3.png" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--about-->
    <section class="who-we-are-area pt-50 pb-50" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <img src="time/images/about.png?ssd" alt="">
                </div>
                <div class="col-lg-7 col-md-7 middle_text">
                    <div class="who-we-are-content">
                        <span>Blockchain network consensus</span>
                        <h3 class="title">Proof-of-Time</h3>
                        <p>Working on a network consensus mechanism, Proof-of-time used in the blockchain network is a simple way of token contribution which is dependent on the active time spent on the network helping generate rewards with more contribution.</p>
                        
                        <br>    
                    </div>
                    
                    <p>Proof-of-time used in a blockchain network is a simple way of token contribution which is dependent on the active time being spent. Rewards are generated on the active time of users, the longer a user remains active, the more rewards are generated. The algorithm executes in a way to randomly generate CAESIUM tokens as per the total time spent in the blockchain network. With the activation of the TIME blockchain, new CAESIUM tokens will be created in an automated manner allowing you to contribute more.</p>
                </div>
            </div>
           
        </div>
    </section>
     <!--about-->

     <!--ico-->
     @php 
		$totalSold=App\Presale::sum('sold_coin');
		$totalCoin=App\Presale::sum('total_coin_unit');

		$sold_coin = 0;
		$unitPrice = 0;
		$discount_percent = 0;
		$total_coin_unit = 0;
		$getPresale=App\Presale::active();
		$sold_coin=0; 
		$enddate=''; 
		$presale_id=''; 
		if($getPresale->exists()) {
			$presale=$getPresale->first();
			$presale_id = $presale->id;
			$sold_coin = $presale->sold_coin;
			$discount_percent = $presale->discount_percent;
			$unitPrice = $presale->unit_price;
			$total_coin_unit = $presale->total_coin_unit;
			$discountPrice = $presale->discount_percent;
			$enddate = $presale->end_date;
		}
	@endphp
     {{--<section class="dark_bg ico-sale-area ICO_sale_section pt-30 pb-30">
        <div class="container">
            <div class="ico-sale-item">
                <h4 class="title">ITO Pre-sale 1 End:</h4>
                <div class="ico-sale-flex d-block d-lg-flex align-items-center">
					
                    <div class="ico-sale-time">
						@if($enddate!='')
						<h4 id="presale_end_time"></h4>
						@endif
                     
                    </div>
                    <div class="ico-sale-raised">
                        <h4>Report </h4>
                        
                        <ul>
                            <li>Total Sold Coin : {{ round($totalSold,2) }} CSM / {{ $totalCoin }} CSM : {{ round(($totalSold*100/$totalCoin),2) }}%</li>
                            <li>Current running : $ {{$discount_percent}} </li>
                            <li>{{ round($sold_coin,2) }} CSM / {{ $total_coin_unit }} CSM :  {{ round(($sold_coin*100/$total_coin_unit),2) }}%</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}
     <!--ico-->

     <section class="who-we-are-area pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="who-we-are-content text-center">
                        <h3 class="title">Introducing a new genre of action-packed Blockchain-based Game – Alpha Return</h3>
                    </div>
                </div>
             </div>

             <br>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <video width="100%" controls autoplay>
                        <source src="time/video/time-video.mp4" type="video/mp4">
                    </video> 
                </div>
             </div>



        </div>
    </section>
	
    <section class="pt-50 pb-50" style="background: #292d2d;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="section-title text-center">
                        <h4 class="title" style="color:#fff">ITO Presale</h4>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" style="color:#fff;">
                   <tbody class="text-center">
                        <tr>
                            <td colspan="5">Pre -Sale ITO  </td>
                            <td>{{ round($totalSold,2) }} CSM / {{ $totalCoin }} CSM </td>
                         </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">Completed ITO Sales</td>
                        </tr>
                        <tr>
                            <td>Tier</td>
                            <td>ITO Sales</td>
                            <td>Special Rebate</td>
                            <td>Coin Price</td>
                            <td>USD</td>
                            <td>CSM</td>
                        </tr>
                        @php $presale_row1=App\Presale::where('total_coin_unit',1000000)->where('discount_percent',0.10)->first(); @endphp
                         @if($presale_row1)
                         @php 
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row1->id){
									$activeCheck=1;
								}
							}
							$coin_price=$presale_row1->discount_percent?:$presale_row1->unit_price;
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                            <td>1</td>
                            <td>{{$presale_row1->total_coin_unit}}</td>
                            <td>-</td>
                            <td>${{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row1->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row1->sold_coin}}</td>
                            @else
								@if($presale_row1->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row1->start_date}}</td>
								@else
									<td>${{ ($presale_row1->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row1->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                        
                        @php $presale_row2=App\Presale::where('total_coin_unit',55110)->where('discount_percent',0.10)->first(); @endphp
                         @if($presale_row2)
                         @php 
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row2->id){
									$activeCheck=1;
								}
							}
							$coin_price=$presale_row2->discount_percent?:$presale_row2->unit_price;
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">

                            <td rowspan="4">2</td>
                            <td rowspan="4">1000000</td>
                            <td>{{$presale_row2->total_coin_unit}}</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row2->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row2->sold_coin}}</td>
                            @else
								@if($presale_row2->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row2->start_date}}</td>
								@else
									<td>${{ ($presale_row2->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row2->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                        @php $presale_row3=App\Presale::where('total_coin_unit',110000)->where('discount_percent',0.12)->first(); @endphp
                         @if($presale_row3)
                        @php 
							$coin_price=$presale_row3->discount_percent?:$presale_row3->unit_price;
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row3->id){
									$activeCheck=1;
								}
							}
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                            <td>{{$presale_row3->total_coin_unit}}</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row3->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row3->sold_coin}}</td>
                            @else
								@if($presale_row3->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row3->start_date}}</td>
								@else
									<td>${{ ($presale_row3->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row3->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                        @php $presale_row4=App\Presale::where('total_coin_unit',275000)->where('discount_percent',0.14)->first(); @endphp
                         @if($presale_row4)
                         
                         @php 
							$coin_price=$presale_row4->discount_percent?:$presale_row4->unit_price;
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row4->id){
									$activeCheck=1;
								}
							}
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                           <td>{{$presale_row4->total_coin_unit}}</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row4->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row4->sold_coin}}</td>
                            @else
								@if($presale_row4->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row4->start_date}}</td>
								@else
									<td>${{ ($presale_row4->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row4->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                         @endif
                         @php $presale_row5=App\Presale::where('total_coin_unit',559890)->where('discount_percent',0.15)->first(); @endphp
                         @if($presale_row5)
                        @php 
							$coin_price=$presale_row5->discount_percent?:$presale_row5->unit_price;
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row5->id){
									$activeCheck=1;
								}
							}
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                           <td>{{$presale_row5->total_coin_unit}}</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row5->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row5->sold_coin}}</td>
                            @else
								@if($presale_row5->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row5->start_date}}</td>
								@else
									<td>${{ ($presale_row5->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row5->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                        @php $presale_row6=App\Presale::where('total_coin_unit',1000000)->where('discount_percent',0.20)->first(); @endphp
                         @if($presale_row6)
							@php 
							$coin_price=$presale_row6->discount_percent?:$presale_row6->unit_price;
							if($activeCheck!=1){
								if($presale_id){
									if($presale_id==$presale_row6->id){
										$activeCheck=1;
									}
								}
							}
							@endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                            <td>3</td>
                            <td>{{$presale_row6->total_coin_unit}}</td>
                            <td>-</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row6->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row6->sold_coin}}</td>
                            @else
								@if($presale_row6->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row6->start_date}}</td>
								@else
									<td>${{ ($presale_row6->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row6->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                        @php $presale_row7=App\Presale::where('total_coin_unit',1000000)->where('discount_percent',0.25)->first(); @endphp
                         @if($presale_row7)
                        @php 
                        $coin_price=$presale_row7->discount_percent?:$presale_row7->unit_price;
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row7->id){
									$activeCheck=1;
								}
							}
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                            <td>4</td>
                            <td>{{$presale_row7->total_coin_unit}}</td>
                            <td>-</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row7->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row7->sold_coin}}</td>
                            @else
								@if($presale_row7->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row7->start_date}}</td>
								@else
									<td>${{ ($presale_row7->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row7->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
                        @endif
                         @php $presale_row8=App\Presale::where('total_coin_unit',1000000)->where('discount_percent',0.35)->first(); @endphp
                         @if($presale_row8)
                        @php 
                        $coin_price=$presale_row8->discount_percent?:$presale_row8->unit_price;
							$activeCheck=0;
							if($presale_id){
								if($presale_id==$presale_row8->id){
									$activeCheck=1;
								}
							}
                         @endphp
                         <tr class="{{ ($activeCheck==1)?'bg-warning':'' }}">
                            <td>5</td>
                            <td>{{$presale_row8->total_coin_unit}}</td>
                            <td>-</td>
                            <td>$ {{$coin_price}}</td>
                            @if($activeCheck==1)
								<td>${{ ($presale_row8->sold_coin)*($coin_price) }}</td>
								<td>{{$presale_row8->sold_coin}}</td>
                            @else
								@if($presale_row8->sold_coin==0)
									 <td colspan="2">Start Date : {{$presale_row8->start_date}}</td>
								@else
									<td>${{ ($presale_row8->sold_coin)*($coin_price) }}</td>
									<td>{{$presale_row8->sold_coin}}</td>
								@endif
                           
                            @endif
                        </tr>
						@endif
                    </tbody>
                </table>
            </div>   
            
            <div class="mt-30 text-center">
                    <a class="main-btn" href="https://tronscan.org/#/token20/TCwH5iryiwfAHwRidQVeobG148eRonPS8U" target="_blank"><i class="fal fa-arrow-right"></i> View CSM Tronscan</a>
                </div>
                         
        </div>
    </section>

    <section class="who-we-are-area pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="who-we-are-content text-center">
                        <span>Fully Decentralized</span>
                        <h3 class="title">TIME ECOSYSTEM</h3>
                        <p>Components helping to create CAESIUM tokens</p>
                    </div>
                </div>
             </div>
        </div>
        <div class="row">
			<div class="col-md-5 col-sm-5">
				<a target="_blank" href="https://alphareturns.tech/"><img class="mobile_desktop_img" src="time/images/img03.png?drtz" alt="img"></a>
			</div>
			<div class="col-md-7 col-sm-7">
				<div class="mobile_width">

                    <div class="who-we-are-content">
                        <h3 class="title">Hold the winning spirit!</h3>
                        <p>Play an exciting game; generate more CAESIUM tokens with active time spent playing!</p>
                        <br>    
                    </div>
                    <p>A new genre of crypto game – Alpha Returns is an action-packed blockchain game that helps generate CAESIUM tokens with more active time spent playing. It is a multiplayer game to play with your friends that calculates the active playing time of the users, trades their assets, and generates returns on the investment. The game is developed to enhance the oomph factor of players. Virtual battle zone recreated for token miners helping fight and earn rewards and achievements with each passing level.</p>
                    <p>Alpha Returns – <a target="_blank" href="https://alphareturns.tech/">https://alphareturns.tech/</a> </p>
                </div>
			</div>
		</div>
        <div class="row">
			<div class="col-md-7 col-sm-7">
				<div class="mobile_width float-right text-right">
                    <div class="who-we-are-content">
                        <h3 class="title">Welcome to the DeFi world</h3>
                        <p>DeFi or Decentralized Finance controlled by a large network of computers helping in crowd funding for any operations</p>
                        <br>    
                    </div>
                    <p>Defi, leveraging key principles of TIME blockchain with increased transparency and security which helps unlock growth opportunities within the ecosystem. Fully decentralized wallets allowing the CAESIUM community to store, safe keep, and transact their crypto assets with first-in-class features. We assure fair and greater service to all the members within the CAESIUM community, and decentralization is the only answer to a stable environment. Our decentralized finance ecosystem is best used to eliminate centralized models and enable the provisioning of decentralized services. </p>
                </div>
			</div>
            <div class="col-md-5 col-sm-5">
				<img class="mobile_desktop_img right_m_img" src="time/images/img02.png" alt="img">
			</div>
		</div>
        <div class="row">
			<div class="col-md-5 col-sm-5">
				<img class="mobile_desktop_img" src="time/images/img01.png" alt="img">
			</div>
			<div class="col-md-7 col-sm-7">
				<div class="mobile_width">

                    <div class="who-we-are-content">
                        <h3 class="title">Decentralized Applications – dApps</h3>
                        <p>Deploy dApps in the most secure way possible</p>
                        <br>    
                    </div>
                    <p>dApps or decentralized applications are best used in a P2P network that acts as an operating system with a secure and resilient software ecosystem. For example, the Fleet Management dApp is applicable for the management of vehicles, financing & leasing, driver management, fuel management, etc. Many other dApps that are available in the Time Ecosystem are; Global Product Management System best for monitoring business improvements, Environment Health and Safety; which can be utilized for workplace management, Global Reporting System; which can be utilized for comprehensive reporting purpose, and many more. The dApps are simple digital applications that exist and run on a blockchain network of computers instead of using a single computer, and are outside the perception and control of a single authority. These applications also help you operate any business vertical minimizing the risks that are widely associated with the efficiency and productivity of the process.</p>
                </div>
			</div>
		</div>
        <div class="row">
			<div class="col-md-7 col-sm-7">
				<div class="mobile_width float-right text-right">
                    <div class="who-we-are-content">
                        <h3 class="title">IoT and Blockchain – transforming the digital space</h3>
                        <p>A new breed of technology used to record transactions of several databases</p>
                        <br>    
                    </div>
                    <p>Offering a scalable and decentralized environment of operation for IoT devices, platforms, and applications using the chain of blocks adding up several public databases added consecutively in a form of “chain” within a network bridged through the available peer¬ to ¬peer nodes. The storage system is often is referred to as a ‘digital ledger. The transaction that occurs within the ledger happens to be authorized through the owner’s digital signature to authenticate transactions and protect data from being tampered with.</p>
                </div>
			</div>
            <div class="col-md-5 col-sm-5">
				<img class="mobile_desktop_img right_m_img" src="time/images/img04.png?df" alt="img">
			</div>
		</div>
    </section>

    <!--services-->
    <section class="marketplace-area pt-60 pb-60" id="services">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="section-title text-center">
                        <span>What is TIME Blockchain?</span>
                        <h3 class="title">An emerging technology serving multiple verticals across the virtual world</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 order-lg-1 order-1">
                    <div class="marketplace-item item-2 mt-30">
                        <img src="time/images/icon/icon-1.png" alt="icon">
                        <h3 class="title">Data   <br> storage</h3>
                        <p>Best used for storing data or transactional records in a chain of blocks connected on a peer-to-peer network and every transaction is authorized using a digital signature. </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 order-lg-2 order-3">
                    <div class="marketplace-item item-2 mt-30">
                        <img src="time/images/icon/icon-2.png" alt="icon">
                        <h3 class="title">Fully  <br>  decentralized</h3>
                        <p>A decentralized and independent network with a digital ledger storage system bridging the peer-to-peer nodes offers transparency by distributing a copy of the ledger to all its participants.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 order-lg-3 order-5">
                    <div class="marketplace-item item-2 mt-30">
                       <img src="time/images/icon/icon-3.png" alt="icon">
                        <h3 class="title">Highly  <br> secure</h3>
                        <p>Data remains secure in the network and all the transactional records are encrypted and are immutable where data once validated becomes irreversible and cannot be changed later.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 order-lg-4 order-2">
                    <div class="marketplace-item item-2 mt-15">
                        <img src="time/images/icon/icon-4.png" alt="icon">
                        <h3 class="title">Automation   <br> potential</h3>
                        <p>A programmable technology helping generate systematic actions or events in an automated manner once and only the criteria are met accordingly as per the algorithm.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 order-lg-5 order-4">
                    <div class="marketplace-item item-2 mt-15">
                        <img src="time/images/icon/icon-5.png" alt="icon">
                        <h3 class="title">Unanimous  <br> technology</h3>
                        <p>Transactional data can only be validated once the network participants’ of a blockchain network agree to validate each of the data being added to the network. </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7 order-lg-6 order-6">
                    <div class="marketplace-item item-2 mt-15">
                        <img src="time/images/icon/icon-6.png" alt="icon">
                        <h3 class="title">Growth <br>  potential</h3>
                        <p>The exponential growth of blockchain is achieved from the convergence of public and private blockchain into an ecosystem where participants collaborate in a secure and virtual way.</p>
                    </div>
                </div>
            </div>
           
        </div>
    </section> 

    <section class="who-we-are-area pt-50">
        <div class="container">
            <img class="img-responsive" src="time/images/caesiumlab-roadmap.png" alt="">
        </div>
    </section>

    <!--services-->

    <section class="who-we-are-area marketplace-area pt-50 pb-50 light_bg" id="whitepaper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 middle_text">
                    <div class="who-we-are-content">
                        <h3 class="title">Everything about CAESIUM credits! </h3>
                        <p>CAESIUM credits is an open-source type that is particularly built for providing a wide range of use cases and demand of CSC based on TIME blockchain community support.</p>
                        
                        <br>    
                    </div>
                    <p>CAESIUM connected with TIME’s blockchain network is totally virtual and the public ledger is linked and secured through cryptographic means. The network provides you with a continuous process of building blocks (containing a hash pointer, links of previous blocks, timestamp and transaction data). The CAESIUM credits can also be termed as utility credits which are community-based crypto, fully transparent, and is equal to all the participants of TIME blockchain. CAESIUM credits work on the basic concept of trading and earning, and here you need to buy and sell coins or tokens. To know more read the whitepaper which has all the related information.</p>
                    <div class="marketplace-btn">
                        <ul>
                            <li><a target="_blank" class="main-btn" href="time/pdf/TIME_via_Caesium_Credits_Whitepaper_v1.pdf">whitepaper</a></li>
                            <li><a target="_blank" class="main-btn main-btn-2" href="time/pdf/CAESIUM-PITCH-DECK.pdf?df">Pitch Deck</a></li>
                       </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 text-right">
                    <img class="whitepaper_img" src="time/images/whitepaper.png?fgc" alt="">
                </div>
            </div>
            
        </div>
    </section>

    <!--faq-->
    <section class="pt-50 pb-50 who-we-are-area" id="faq">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="who-we-are-content text-center">
                        <span>We value your queries</span>
                        <h3 class="title">Frequently Asked Questions</h3>
                        <p>All your queries are answered here</p>
                    </div>
                </div>
             </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                   <div class="faq-accordion">
                        <div class="accrodion-grp" data-grp-name="faq-accrodion">
                            <div class="accrodion active  animated wow fadeInRight" data-wow-duration="1500ms"
                                data-wow-delay="0ms">
                                <div class="accrodion-inner">
                                    <div class="accrodion-title">
                                        <h4>What is proof-of-time?</h4>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p>It is an elementary concept to understand, and is based on the network consensus mechanism. Proof-of-time used in network is a simple process of token contribution which is dependent to the active time spent on the network. Rewards are generated on the active time of users, the longer a user remains active, the more rewards are generated.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accrodion animated wow fadeInRight" data-wow-duration="1500ms"
                                data-wow-delay="300ms">
                                <div class="accrodion-inner">
                                    <div class="accrodion-title">
                                        <h4>What is decentralization?</h4>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p>The blockchain networks are highly decentralized which disperses any control from a controlling body such as banks or any other governing bodies. Decentralization is everything about the transfer of controlling and decision-making power from a centralized entity with removal of intermediaries.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accrodion animated wow fadeInRight" data-wow-duration="1500ms"
                                data-wow-delay="600ms">
                                <div class="accrodion-inner">
                                    <div class="accrodion-title">
                                        <h4>What is blockchain used for?</h4>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p>Blockchain is basically a decentralized distributed network of blocks and digital ledgers holding the transactional records in every block which cannot be altered once entered and can only be altered after making alterations of the subsequent blocks in the network.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accrodion  animated wow fadeInRight" data-wow-duration="1500ms"
                                data-wow-delay="600ms">
                                <div class="accrodion-inner">
                                    <div class="accrodion-title">
                                        <h4>What is a digital wallet?</h4>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p>It is a software-based system that is used for the storage and transactions of cryptocurrencies. Apart from the storage of digital currencies, the wallets can be used for making payments to buy a product or service. A digital wallet can be used with mobile payment systems as well.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
    <!--faq-->

<script>
// Set the date we're counting down to
var countDownDate = new Date('{{$enddate}}').getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("presale_end_time").innerHTML = days + " Days " + hours + " Hours "
  + minutes + " Minutes " + seconds + " Seconds ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("presale_end_time").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
@endsection

