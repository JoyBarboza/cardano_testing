@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button class="close" data-close="alert"></button>
        {{--<strong>{{trans('errors/503.mantainance_mode')}}!</strong> {{$message}} <br><br>--}}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@include('flash::message')
