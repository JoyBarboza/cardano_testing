@extends('layouts.master')
@section('page-title') {{trans('transaction/user-list.Transaction_list')}} @endsection
@section('page-content')


<main>
	<section>
		<div class="rows">
		<h1 class="main_heading">{{trans('transaction/user-list.Transaction')}}</h1>
		@include('flash::message')
			<div class="box box-inbox">
			<div class="panel">
					<div class="panel-body">
						<div class="table-responsive table-scrollable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Txn Hash</th>
                                    <th >Type</th>
                                    <th >CSM Token</th>
                                    <th >BNB Amount</th>
                                    <th>Date</th>
                                    <!-- <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @forelse($bnb_transaction as $transaction)
                                <tr>
                                    <!-- <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>  2021-12-07 5:52:11	-->
                                    <td>{{ $i++}}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td>

                                        @if($transaction->type == 'buy')
                                            @php echo "Buy"; @endphp
                                        @elseif($transaction->type == 'buy_nft')
                                            @php echo "Buy NFT"; @endphp
                                        @elseif($transaction->type == 'resell_nft')
                                            @php echo "Resell NFT"; @endphp
                                        @elseif($transaction->type == 'stake_amount')
                                            @php echo "Stake Amount"; @endphp
                                        @elseif($transaction->type == 'unstake_amount')
                                            @php echo "Ustake amount"; @endphp
                                        @endif
                                    </td>
                                    <td>{{ $transaction->csm_amount }}</td>
                                    <td>{{ $transaction->eth_amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d h:i:s')}}</td>
                                    <!-- <td><span class="text-success">Success</span></td> -->
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No Transaction</td>
                                </tr>
                            @endforelse
                            </tbody>
                            
                        </table>
                    </div>
                        <div class="portlet-footer">
								<span class="text-right">{{ $bnb_transaction->links() }}</span>
							</div>
                    
						
					</div>
				</div>
            </div>
		</div>
	</section>
</main> 







 
@endsection
@push('css')
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script>
    $('.date-picker').datepicker({
        orientation: "bottom",
        autoclose: true
    });
</script>
@endpush
