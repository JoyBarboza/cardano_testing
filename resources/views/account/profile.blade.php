@extends('layouts.master')
@section('page-content')

<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('account/profile.profile')}}</h1>
            <div class="box box-inbox">
            <div class="profile_section">
            <div class="send_request_background">
                @php $filePhoto = ($user->document()->where('name','PHOTO')->exists()) ? $user->document()->where('name','PHOTO')->first()->location : 'no-image.jpg' ;  @endphp
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        @if((auth()->user()->document()->where('name','PHOTO')->exists()))
                            <img class="rounded-circle" style="text-align:center;width: 200px;" src="{{ route('photo.get', [$filePhoto,auth()->user()->username]) }}" alt="img">
                        @else
                            <img class="rounded-circle" src="{{ asset('images/no-image.png') }}" alt="">
                        @endif
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <ul class="list-group">
                            <li class="list-group-item"><span>{{trans('account/profile.Your_Referral_Code')}} :</span> <span class="text-info">{{ $user->referral }}</span></li>
                            <li class="list-group-item"><span>{{trans('account/profile.acc_type')}} :</span> {{ $user->profile->account_type }}</li>
                            <li class="list-group-item"><span>{{ ($user->profile->account_type=='company')?trans('account/profile.company'):trans('account/profile.name') }} :</span> {{ $user->full_name }}</li>
                            {{--
                            <li class="list-group-item"><span>{{trans('account/profile.tax_id')}} :</span> {{ $user->username }}</li>
                            --}}
                            <li class="list-group-item"><span>{{trans('account/profile.email')}} :</span> {{ $user->email }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.phone')}} :</span> {{ $user->phone_no }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.Address')}} :</span> {{ $user->profile->address }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.Pincode')}} :</span> {{ $user->profile->pin_code }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.City')}} :</span> {{ $user->profile->city }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.State')}} :</span> {{ $user->profile->state }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.Country')}} :</span> {{ ($user->profile->country_id)?$user->profile->country->name:'' }}</li>
                            <li class="list-group-item"><span>{{trans('account/profile.Document_no')}} :</span> {{ $user->profile->ide_no }}</li>
                           @php $docPhoto = ($user->document()->where('name','DOC_PHOTO')->exists()) ? $user->document()->where('name','DOC_PHOTO')->first()->location : 'no-image.jpg' ;  @endphp
                
                            <li class="list-group-item"><span>{{trans('account/profile.Document_proof')}} :</span>
                                @if((auth()->user()->document()->where('name','DOC_PHOTO')->exists()))
                                <img class="profile_img" style="text-align:center;width: 100px;" src="{{ route('photo.get', [$docPhoto,auth()->user()->username]) }}" alt="img" style="float:left;">
                                @else
                                <img src="{{ asset('images/no-image.png') }}" alt="">
                                @endif
                            </li>
                        </ul>
                        <hr>
                        @if (!auth()->user()->profile->kyc_verified)
					   <div class="text-center">
						<button onclick="location.href='{{ route('account.editMyprofile') }}';" class="btn btn-info">{{trans('account/profile.Complete_KYC')}}</button>
							
						</div>
						@else
						<p><strong>{{trans('account/profile.KYC')}} : </strong> {{trans('account/profile.Verified')}} <i class="fa fa-check" aria-hidden="true"></i></p>
						@endif
                        
                </div>
            </div>
        </div>
            </div>
		</div>
	</section>
</main> 



@endsection
