@php $user = auth()->user(); @endphp
@extends('layouts.master')
@section('page-title') {{trans('withdraw/jpc.JPC_Withdrawal')}} @endsection
@section('page-content')
    <div class="col-md-9 col-sm-8">
        <div class="panel">
            <div class="panel-heading">
                <h2>{{trans('withdraw/jpc.Withdraw')}}<small>(JPC)</small></h2>
            </div>
            <div class="panel-body">
                @include('flash::message')
                @php $payment = session('payment')?session('payment'):null @endphp
                @if($payment)
                    <div class="col-md-12">
                        <p><strong>{{trans('withdraw/jpc.Address')}} : </strong>{{ $payment->address }}</p>
                        <p><strong>{{trans('withdraw/jpc.RefID')}} : </strong>{{ $payment->reference_no }}</p>
                        <p><strong>{{trans('withdraw/jpc.Amount')}} : </strong>{{ number_format($payment->transaction->amount, 8) }}</p>
                        <p><strong>{{trans('withdraw/jpc.Currency')}} : </strong>JPC</p>
                        <a class="btn btn-primary" href="{{ route('user.withdraw.currency', 'jpc') }}">{{trans('withdraw/jpc.GoBack')}}</a>
                    </div>
                @else
                    <form class="form-horizontal" name="withdraw" action="{{ route('user.withdraw.currency.make', 'jpc') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('address')?' has-error':' has-feedback' }}">
                            <label for="amount" class="col-md-3 control-label">{{trans('withdraw/jpc.Address')}}:</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                <span class="help-block">{{$errors->first('address') }}</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount')?' has-error':' has-feedback' }}">
                            <label for="amount" class="col-md-3 control-label">JPC {{trans('withdraw/jpc.Amount')}}:</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                                <span class="help-block">{{$errors->first('amount') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-5">
                                <button class="exchange_btn" type="submit">{{trans('withdraw/jpc.Proceed')}}</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
