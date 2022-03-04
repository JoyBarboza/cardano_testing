@extends('layouts.master')
@section('page-content')

<main>
	<section>
		<div class="rows">
            <h1 class="main_heading">{{trans('account/announcement.announcements')}}</h1>
            @forelse($announcements as $announcement)
            <div class="white_box announcements_box">
                <h3>{{$announcement->title}} </h3>
                <p>{{$announcement->description}}</p>
            </div>
            @empty
            @endforelse  
            {{ $announcements->links() }}
		</div>
	</section>
</main> 



@endsection
