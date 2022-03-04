@extends('template.dialog')
@section('modalSize') style='width:800px' @endsection
@section('dialogTitle') Transaction - {{$transaction->reference_no}} @endsection
@section('dialogContent')
    <div class="modal-body"  style="overflow:hidden">
        @if(isset($details['operation']))
            @php $name = explode('_',$details['operation']->name); @endphp
            <p>
                Transaction for - {{$name[0]}} {{$name[1]}}<br />
                Debit Amount: {{$details['operation']->source_amount}}{{$details['operation']->source->name}}<br />
                Credit Amount: {{$details['operation']->destination_amount}}{{$details['operation']->destination->name}}<br />
                Date : {{$details['operation']->created_at}}
            </p>

        @elseif(isset($details['payment']))
            <p>Transaction for - {{$details['payment']->remarks}}<br />
                @if($details['payment']->address)<br />
                    Address - {{$details['payment']->address}}<br />
                    Txn - {{--<a href="http://www.wtcexplorer.com/tx/{{ $details['payment']->reference_no }}" target="_blank">--}}{{$details['payment']->reference_no}}{{--</a>--}} <br />
                    Amount - {{$transaction->currency->name}} {{$transaction->amount}}<br />
                    Date - {{$transaction->created_at}}
                @else
                    Reference No - {{$details['payment']->reference_no}}; <br />
                    Amount - {{$transaction->currency->name}} {{$transaction->amount}}<br />
                    Date - {{$transaction->created_at}}
                @endif
            </p>
        <p> {{trans('transaction/transaction.transaction_for')}}- {{$name[0]}} {{$name[1]}}<br />
            {{trans('transaction/transaction.debit_amount')}}: {{$details['operation']->source_amount}}{{$details['operation']->source->name}}<br />
            {{trans('transaction/transaction.credit_amount')}}: {{$details['operation']->destination_amount}}{{$details['operation']->destination->name}}<br />
            {{trans('transaction/transaction.date')}} : {{$details['operation']->created_at}}
        </p>

        @elseif(isset($details['payment']))
            <p>{{trans('transaction/transaction.transaction_for')}}- {{$details['payment']->remarks}}<br />
                @if($details['payment']->address)<br />
                {{trans('transaction/transaction.Address')}} - {{$details['payment']->address}}<br />
                {{trans('transaction/transaction.Txn')}} - <a href="http://www.wtcexplorer.com/tx/{{ $details['payment']->reference_no }}" target="_blank">{{$details['payment']->reference_no}}</a> <br />
                {{trans('transaction/transaction.Amount')}} - {{$transaction->amount}}{{$transaction->currency->name}}<br />
                {{trans('transaction/transaction.date')}} - {{$transaction->created_at}}
                @else
                    {{trans('transaction/transaction.Reference_No')}} - {{$details['payment']->reference_no}}; <br />
                    {{trans('transaction/transaction.Amount')}} - {{$transaction->amount}}{{$transaction->currency->name}}<br />
                    {{trans('transaction/transaction.date')}} - {{$transaction->created_at}}
                @endif
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('transaction/transaction.Close')}}</button>
    </div>
@stop
