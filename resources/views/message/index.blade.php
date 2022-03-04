@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
	<ul class="page-breadcrumb">
		
		<li>
			<span>{{trans('message/index.message')}}</span>
		</li>
	</ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
	{{trans('message/index.message')}}
	<small>{{trans('message/index.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
	<div class="inbox">
		<div class="row">
			<div class="col-md-2">
				<div class="inbox-sidebar">
					@if(!request()->is('message/compose'))
						<a href="{{ route('admin.message.compose') }}" data-title="Compose" class="btn red compose-btn btn-block">
							<i class="fa fa-edit"></i> {{trans('message/index.compose')}} </a>
					@endif
					<ul class="inbox-nav">
						<li {{ request()->is('message')?'class=active':'' }}>
							<a href="{{ route('admin.message.inbox') }}" data-type="inbox" data-title="Inbox"> {{trans('message/index.inbox')}}
								{{--<span class="badge badge-success">3</span>--}}
							</a>
						</li>
						<li {{ request()->is('message/outbox')?'class=active':'' }}>
							<a href="{{ route('admin.message.outbox') }}" data-type="sent" data-title="Sent"> {{trans('message/index.outbox')}} </a>
						</li>
						{{--<li {{ request()->is('message/drafted')?'class=active':'' }}>
							<a href="{{ route('message.drafted') }}" data-title="Drafted">  {{trans('message/index.drafted')}}
								--}}{{--<span class="badge badge-info">23</span>--}}{{--
							</a>
						</li>--}}
						<li {{ request()->is('message/important')?'class=active':'' }}>
							<a href="{{ route('admin.message.important') }}" data-type="important" data-title="Important"> {{trans('message/index.important')}} </a>
						</li>
						<li class="divider"></li>
						<li {{ request()->is('message/trash')?'class=active':'' }}>
							<a href="{{ route('admin.message.trash') }}" class="sbold uppercase" data-title="Trash"> {{trans('message/index.trash')}}
								{{--<span class="badge badge-info">23</span>--}}
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-10">
				@yield('message-page-content')
			</div>
		</div>
	</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/apps/css/inbox.min.css') }}">
@endpush

@push('js')
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{{--<script src="{{ asset('assets/apps/scripts/inbox.js') }}" type="text/javascript"></script>--}}
<!-- END PAGE LEVEL SCRIPTS -->
@endpush
