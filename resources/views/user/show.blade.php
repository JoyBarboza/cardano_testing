@extends('template.dialog')
@section('modalSize') @if($user->isVerified()) modal-lg @endif @endsection
@section('dialogTitle') {{trans('user/show.View_User_information')}} @endsection  
@section('dialogContent')
<div class="modal-body">
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">{{ ucfirst($user->full_name) }}</h3>
        </div>
        <div class="panel-body">
            <div class="col-md-7 col-sm-12">
                <p> <strong>{{trans('user/show.refferal_code')}}:</strong> {{ ($user->referral) }} </p>
                <p> <strong>{{trans('user/show.acc_type')}} :</strong> {{ $user->profile->account_type }} </p>
                <p> <strong>{{ ($user->profile->account_type=='company')?trans('user/show.Company_Name'):trans('user/show.Name') }}:</strong> {{ ucfirst($user->first_name) }} </p>
                
                <p> <strong>{{trans('user/show.Tax_Id')}}:</strong> {{ $user->username }} </p>
                <p> <strong>{{trans('user/show.email')}}:</strong> {{ $user->email }} </p>
                <p> <strong>{{trans('user/show.phone')}}:</strong> {{ $user->phone_no?:'Not Available' }} </p>
                {{--<p> <strong>{{trans('user/show.country')}}:</strong> {{ $user->country?:'Not Available' }} </p>--}}
                <p> <strong>{{trans('user/show.status')}}:</strong> {{ $user->status?'Active':'InActive' }} </p>
                <p> <strong>{{trans('user/show.email_verified')}}:</strong> {{ $user->verified_at?'Verified':'Unverified' }} </p>
                {{--<p> <strong>Two Fector Enabled:</strong> {{ ($user->TwoFactorEnable=='Y')?'Yes':'No' }} </p>--}}
				<p><strong>{{trans('user/show.Address')}} :</strong> {{ $user->profile->address }}</p>
				<p><strong>{{trans('user/show.Pincode')}} :</strong> {{ $user->profile->pin_code }}</p>
				<p><strong>{{trans('user/show.City')}} :</strong> {{ $user->profile->city }}</p>
				<p><strong>{{trans('user/show.State')}} :</strong> {{ $user->profile->state }}</p>
				<p><strong>{{trans('user/show.Country')}} :</strong> {{ ($user->profile->country_id)?$user->profile->country->name:'' }}</p>
				<p><strong>{{trans('user/show.Document_number')}} :</strong> {{ $user->profile->ide_no }}</p>
				</p>
            </div>
            <div class="col-md-5 col-sm-12">
                @foreach($user->document as $document)
                    <div class="thumbnail">
                        <img src="{{ route('photo.get', [$document->location]) }}?z" style="width: 100%; height: 200px; display: block;">
                        <div class="text-center">{{ $document->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- List group -->
        {{-- <ul class="list-group">
            <li class="list-group-item"> {{trans('user/show.first_name')}}
                <span class="badge badge-default"> 3 </span>
            </li>
            <li class="list-group-item"> {{trans('user/show.last_name')}}
                <span class="badge badge-success"> 11 </span>
            </li>
            <li class="list-group-item"> {{trans('user/show.email')}}
                <span class="badge badge-danger"> new </span>
            </li>
            <li class="list-group-item"> {{trans('user/show.porta_ac_consectetur_ac')}}
                <span class="badge badge-warning"> 4 </span>
            </li>
            <li class="list-group-item"> {{trans('user/show.vestibulum_at_eros')}}
                <span class="badge badge-info"> 3 </span>
            </li>
            <li class="list-group-item"> {{trans('user/show.vestibulum_at_eros')}} </li>
        </ul> --}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('user/show.close')}}</button>
   </div>
@stop    
