@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN CONTENT BODY -->
	<!-- BEGIN PAGE BAR -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{ url('/home') }}">{{trans('language/index.home')}}</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<span>{{trans('language/index.language')}}</span>
			</li>
		</ul>
	</div>
	<!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{trans('language/index.language')}}</h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    @include('flash::message')
    <div class="row">
        <div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-red"><i class="fa fa-language font-red"></i>{{trans('language/index.choose_lang')}}</div>
				</div>
				<div class="portlet-body flip-scroll">
					<form role="form"  method='POST' action="{{ route('admin.language.get-files') }}">
						{{ csrf_field()}}
						<div class="row">
							<div class="col-md-5">
								<label for="">{{trans('language/index.select_language')}}:</label>
								<select name="language" class="form-control">
									<option value="en" @if(request()->language == 'en') {{"selected=selected"}} @endif>{{trans('language/index.english')}}</option>
									<option value="ja" @if(request()->language == 'ja') {{"selected=selected"}} @endif>{{trans('language/index.Japanesse')}}</option>
									<option value="pt" @if(request()->language == 'pt') {{"selected=selected"}} @endif>{{trans('language/index.Portugues')}}</option>
									<option value="es" @if(request()->language == 'es') {{"selected=selected"}} @endif>{{trans('language/index.Spanish')}}</option>
									<option value="ko" @if(request()->language == 'ko') {{"selected=selected"}} @endif>{{trans('language/index.Korean')}}</option>
									<option value="zh" @if(request()->language == 'zh') {{"selected=selected"}} @endif>{{trans('language/index.Chinese')}}</option>
									<option value="ru" @if(request()->language == 'ru') {{"selected=selected"}} @endif>{{trans('language/index.Russian')}}</option>
								</select>
							</div>
							<div class="col-md-5">
								<label for="">{{trans('language/index.select_file')}}:</label>
								<select name="file" class="form-control">
									<option>- {{trans('language/index.select_file')}} -</option>
									@foreach ($file_list_path as $file_list)
										@if ($file_list != '')
											@php $select_value= ''; @endphp
											@if (($pos = strpos($file_list, 'en/')) != FALSE)
												@php $select_value= substr($file_list, $pos+3); @endphp
											@endif
											<option value="{{$select_value}}"  @if(isset($request))@if($select_value == $request->file) {{"selected=selected"}} @endif   @endif >
												{{$select_value}}
											</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label for="">&nbsp;</label>
								<button type="submit" class="btn btn-success btn-block" name="choose" value="true">{{ trans('language/index.file_select') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>

	@if(isset($contentLang))
	<div class="portlet light bordered">
		 <form method='POST' action="{{ route('admin.language.export-to-file') }}">
			 {{ csrf_field()}}
			<div class="add_button" style="width: 64px; height: 44px;"><button type="button" style="margin: 3px;float:left;" class= "add_equipment btn btn-primary" >+</button><br><br><br></div>
				<table id="all_lang" style="width:100%;">
				
						<thead>
							<tr>
								<th>{{trans('language/index.key')}}</th>
								<th>{{$language}}</th>
								<th></th>
							</tr>
						</thead>
							
						<tbody>
							@foreach ($contentLang as $key => $value)   
								@if(is_array($value))   
									@foreach ($value as $subkey => $subvalue)  
									@if($subvalue)
									<tr>
										<td id="{{$subkey}}"> <input  class="form-control" type="text" name="key_name[]"  value="{{$key}}.{{$subkey}}" readonly> </td>
										<td id="{{$subkey}}"> <input  class="form-control" type="text" name="key_val[]" value="{{is_array($subvalue)?join('',$subvalue):$subvalue}}">	</td>
										<td id="{{$subkey}}"> <button type="button" style="margin-bottom: 4px;margin-left: 3px;padding-top: 3px;" id="{{$subkey}}" class = "btn btn-danger remove_button add_equipment">-</button></td>
									
									</tr> 
									@endif
									@endforeach
								@else 
									<tr>
										<td id="{{$key}}"> <input  class="form-control" type="text" name="key_name[]"  value="{{$key}}" readonly> </td>
										<td id="{{$key}}"> <input  class="form-control" type="text" name="key_val[]" value="{{$value}}">	</td>
										<td id="{{$key}}"> <button type="button" style="margin-bottom: 4px;margin-left: 3px;padding-top: 3px;" id="{{$key}}" class = "btn btn-danger remove_button add_equipment">-</button></td>
									</tr>
								@endif
							@endforeach
						</tbody>
				</table>
				<div style="padding:20px;text-align:right;">
					<input type="submit" name="Change" value="{{trans('language/index.save')}}" class="add_equipment btn btn-success" >
				</div>	
					
			</form>
       </div>
       @endif
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
 </div>
    </div>
</div>

<!-- END CONTENT BODY -->
@endsection
@push('css')
@push('js')

<script type="application/javascript">
	$(document).ready(function(){  
		//$('.remove_button').live('click',function(){
		$(document).on('click','.remove_button', function(e){	 
			$(this).closest('tr').remove();
		});	
	});
</script>

<script>
	$(document).on('click','.add_button', function(e){
		$('#all_lang tbody').prepend('<tr>'+
			'<td><input class="form-control" type="text" name="key_name[]"></td>'+
			'<td><input class="form-control" type="text" name="key_val[]"></td>'+

			'<td><button type="button" style="margin-left: 3px;margin-bottom: 4px;padding-top: 3px;" class = "btn btn-danger remove_button add_equipment">-</button></td>'+
		'</tr>');
	});
</script>

@endpush
