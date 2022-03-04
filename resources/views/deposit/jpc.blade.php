@extends('layouts.master')
@section('page-title') {{trans('deposit/jpc.Deposit_Fiat_Currency')}} @endsection
@section('page-content')

<main>
	<section>
		<div class="rows">
        @include('flash::message')
            <h1 class="main_heading">{{trans('deposit/jpc.Deposit')}}<small> (Token)</small></h1>
            <div class="box box-inbox">
                <figure class="text-center">
                    <img class="img-responsive" style="margin: auto" src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl={{ $address }}">
                    <div>
                    <br>
                    </div>
                    <figcaption>{{ $address }}</figcaption>
                </figure>
                <br>
                <div class="panel">
                    <div class="panel-heading">
                        {{trans('deposit/jpc.JPC_Payment_Instructions')}}
                    </div>
                    <div class="panel-body">
                        
                        <p class="text-justify">{{trans('deposit/jpc.JPC_Payment_Instructions_details')}}</p>

                    </div>
                </div>
            </div>
		</div>
	</section>
</main> 



@endsection
