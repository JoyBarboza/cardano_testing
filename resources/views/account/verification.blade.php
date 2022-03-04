@extends('layouts.master')

@section('page-content')
<div class="col-md-9 col-sm-8">
    <div class="recharge_section">
        <h1 class="main_heading">{{trans('account/verification.edit_profile')}}</h1>
        <div class="alert alert-warning fade in alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {{trans('account/verification.fill_your_document')}}
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                <span class="round-tab">
                                    <i class="glyphicon glyphicon-folder-open"></i>
                                </span>
                            </a>
                        </li>

                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                <span class="round-tab">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                <span class="round-tab">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                @php $user = auth()->user() @endphp
                <form role="form" method="post" action="{{ route('account.profile.edit') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">

                        <h1 style="font-size: 16pt;color: #8abb9f;">{{trans('account/verification.account_details')}}</h1>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">{{trans('account/verification.indentification_no')}} :</label>
                                        <input type="text" class="form-control" name="ide_no" value="{{ old('ide_no')?:$user->profile->ide_no }}">
                                        <label class="ide_resp" style="color:#FF0000;"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="usr">{{trans('account/verification.phone_number')}} :</label>
                                        <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no')?:$user->phone_no }}">
                                        <label class="ph_resp" style="color:#FF0000;"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="usr">{{trans('account/verification.full_residential')}} :</label>
                                        <textarea class="form-control" rows="3" name="address">{{ old('address')?:$user->profile->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sel1">{{trans('account/verification.city')}} :</label>
                                        <input type="text" class="form-control" name="city" value="{{ old('city')?:$user->profile->city }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sel1">{{trans('account/verification.state')}} :</label>
                                        <input type="text" class="form-control" name="state" value="{{ old('state')?:$user->profile->state }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usr">{{trans('account/verification.pincode')}} :</label>
                                        <input type="text" class="form-control" name="zip" value="{{ old('zip')?:$user->profile->pin_code }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sel1">{{trans('account/verification.country')}} :</label>
                                        <select name="country" class="form-control">
                                            @foreach($countries as $id => $name)
                                                <option @if((old('country') == $id) or $user->profile->country_id == $id) selected @endif value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li><button type="button" data-next-step="#step2" class="exchange_btn next-step">{{trans('account/verification.next')}}</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <br>
                            <div class="step2_container">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="step2_img_con">
                                            <img src="{{ asset('/images/no-image.png') }}" alt="img" height="20%" width="20%">
                                             <label class="btn-bs-file input_file">
												{{trans('account/verification.Browse')}}
												<input type="file" name="identity" accept="image/*" id="identity" />
											</label>
                                            
                                           <p>{{trans('account/verification.Identity_proof')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="step2_img_con">
                                            <img src="{{ asset('/images/no-image.png') }}" alt="img">
                                            <label class="btn-bs-file input_file">
												{{trans('account/verification.Browse')}}
												<input type="file" name="photo" accept="image/*" id="photo"/>
											</label>
                                           <p>{{trans('account/verification.Photo')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                                <li><button type="button" data-prev-step="#step1" class="exchange_btn prev-step">{{trans('account/verification.previous')}}</button></li>
                                <li><button type="button" data-next-step="#step3" class="exchange_btn next-step">{{trans('account/verification.next')}}</button></li>
                            </ul>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step3">
                            <ul class="step_three_verification">
                                <li><div>{{trans('account/verification.phone_number')}} :</div><span id="phone"> {{$user->phone_no}}</span></li>
                                <li><div>{{trans('account/verification.identification_no')}} :</div><span id="ide_no">{{$user->profile->pan_no}}</span></li>
                                <li><div>{{trans('account/verification.address')}} :</div><span id="address">{{$user->profile->address}}</span></li>
                                <li><div>{{trans('account/verification.city')}} :</div><span id="city">{{$user->profile->city}}</span></li>
                                <li><div>{{trans('account/verification.state')}} :</div><span id="state">{{$user->profile->state}}</span></li>
                                <li><div>{{trans('account/verification.pincode')}} :</div><span id="pin">{{$user->profile->pin_code}}</span></li>
                            </ul>
                            <ul class="list-inline pull-right">
                                <li><button type="button" data-prev-step="#step2" class="exchange_btn prev-step">{{trans('account/verification.previous')}}</button></li>
                                <li><button type="submit" data-next-step="#step4"  class="exchange_btn btn-info-full next-step">{{trans('account/verification.submit')}}</button></li>
                            </ul>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="step4">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
@push('css')
<style>.require::after {content: '*'; font-size: 15px; font-weight: bold; color: #d34e4f; margin-left:5px;}</style>
@endpush
@push('js')
<script type="text/javascript">
    $(document).ready(function() {

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('div.step2_img_con').find('img')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("input[type=file]").change(function(){
            readURL(this);
        });

        $('button.next-step').click(function(){

            
			
			if($(this).attr('data-next-step')=='#step2'){
				if($("input[name=ide_no]").val()==''){
					$("input[name=ide_no]").focus();
					$('.ide_resp').html('Please Insert Identification No.');
				}else if($("input[name=phone_no]").val()==''){
					$("input[name=phone_no]").focus();
					$('.ph_resp').html('Please Insert Phone No');
				}else if(isNaN($("input[name=phone_no]").val())){
					$("input[name=phone_no]").focus();
					$('.ph_resp').html('Phone No. must be a number');
				}else{
					var hash = $(this).attr('data-next-step');
					window.location.hash = hash;
					hash && $('ul.nav a[href="' + hash + '"]').tab('show');
				
					var currentTab = $(this).closest('div.tab-pane')
						.removeClass('active')
						.next();

					currentTab.addClass('active');
				}
			}else{
				var hash = $(this).attr('data-next-step');
				window.location.hash = hash;
				hash && $('ul.nav a[href="' + hash + '"]').tab('show');
				
				var currentTab = $(this).closest('div.tab-pane')
                    .removeClass('active')
                    .next();

				currentTab.addClass('active');

			}
			
            
            if(currentTab.attr('id') == 'step3') {
                $('span[id=phone]').text($('input[name=phone_no]').val());
                $('span[id=ide_no]').text($('input[name=ide_no]').val());
                $('span[id=address]').text($('textarea[name=address]').val());
                $('span[id=city]').text($('input[name=city]').val());
                $('span[id=state]').text($('input[name=state]').val());
                $('span[id=pin]').text($('input[name=zip]').val());
                $('span[id=account]').text($('input[name=account_no]').val());
                $('span[id=ifsc]').text($('input[name=ifsc]').val());
            }
            if(currentTab.attr('id') == 'step4') {
                $('#step4').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> updating..');
            }


        });
        $('button.prev-step').click(function(){

            var hash = $(this).attr('data-prev-step');
            window.location.hash = hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');


            $(this).closest('div.tab-pane')
                    .removeClass('active')
                    .prev()
                    .addClass('active');
        });
    });

</script>
<script>
	$('.next-step').click(function(e){
		if($("input[name=first_name]").val()==''){
			e.preventDefault();
			$("input[name=first_name]").focus();
		}else if($("input[name=last_name]").val()==''){
			e.preventDefault();
			$("input[name=last_name]").focus();
		}
	});
</script>

@endpush
