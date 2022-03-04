@extends('template.dialog')
@section('modalSize') @if($user->isVerified()) modal-lg @endif @endsection
@section('dialogTitle') Document Details : @endsection  
@section('dialogContent')
<div class="modal-body">
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">{{ ucfirst($user->full_name) }}</h3>
        </div>
        <div class="panel-body">
			<p><strong>Document Number: </strong>{{ $user->profile->ide_no }}</p>
			<p><strong>KYC Verified: </strong>{{ ($user->profile->kyc_verified)?'YES':'NO' }}</p>
            @foreach($user->document as $document)
            @if($document->name=='DOC_PHOTO')
                    <div class="thumbnail"> 
                        <img src="{{ route('photo.get', [$document->location]) }}?z" style="width: 100%; height: 500px; display: block;">
                        <div class="text-center">ID Proof</div>
                    </div>
            @endif
                @endforeach
        </div>
        <!-- List group -->
        
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('user/show.close')}}</button>
</div>
@stop    
