@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('presale/create.settings')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('presale/create.control')}}
    <small>{{trans('presale/create.panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')

    <div class="row">
        <div class="col-md-12">
            @include('errors.input')
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('presale/create.Create_new_PreSale')}}{{--{{trans('setting/pre_sale.charge_settings')}}--}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form class="form-horizontal onSubmitdisableButton" role="form" action="{{--{{ route('admin.setting.set.preSale') }}--}}{{ route('admin.presale.store') }}"  method="post">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label">{{--{{trans('setting/pre_sale.presale_date_between')}}--}}{{trans('presale/create.presale_start')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group date-picker input-daterange">
                                        <input class="form-control" name="start_date" type="text" value="{{ (request()->from_date!='')?request()->from_date:old('start_date') }}">
                                        <span class="input-group-addon"> {{trans('presale/create.to')}}</span>
                                        <input class="form-control" name="end_date" type="text"  value="{{ (request()->to_date!='')?request()->to_date:old('end_date') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('total_unit')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('presale/create.Total_Coins_sold')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-cart-arrow-down"></i>
                                                </span>
                                        <input name="total_unit" value ="{{ (request()->total_unit!='')?request()->total_unit:old('total_unit') }}" type="text" class="form-control" placeholder="{{trans('presale/create.limit_amount')}}">
                                    </div>
                                    @if($errors->has('total_unit'))
                                        <span class="help-box">{{ $errors->first('total_unit') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('unit_price')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('presale/create.Coin_unit_price')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-cart-arrow-down"></i>
                                        </span>
                                        <input name="unit_price" value ="{{ (request()->unit_price!='')?request()->unit_price:old('unit_price') }}" type="text" class="form-control" placeholder="{{trans('presale/create.limit_amount')}}">
                                    </div>
                                    @if($errors->has('unit_price'))
                                        <span class="help-box">{{ $errors->first('unit_price') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('bonus_discount')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('presale/create.bonus_discount_applied')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-cart-arrow-down"></i>
                                        </span>
                                        <input name="bonus_discount" value ="{{ (request()->bonus_discount!='')?request()->bonus_discount:old('bonus_discount') }}" type="text" class="form-control" placeholder="{{trans('presale/create.limit_amount')}}">
                                    </div>
                                    @if($errors->has('bonus_discount'))
                                        <span class="help-box">{{ $errors->first('bonus_discount') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="button" class="btn default">{{trans('presale/create.cancel')}}</button>
                            <button type="submit" class="btn blue check_unit submitButton">{{trans('presale/create.submit')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
{{--<script>
    function addQty(){
        $('.partition_div').append('<div class="input-group col-md-12 part_sale" id="part_sale">'+$('.part_sale').html()+'</div>');
        $('.part_sale').last().find('.add_more').remove();
        $('.part_sale').last().append('<a class="removeQty"><i class="fa fa-minus-square" aria-hidden="true"></i></a>');
    }

    $(document).on('click','.removeQty',function(){
        $(this).parent().remove();
    });

    $('#total_unit').keyup(function(){
        var unit = $(this).val();
        if (!($.isNumeric(unit))) {
            $('.err_response').text('Total Unit Must Be Numeric');
            $('#total_unit').val('');
        }
    });

    $(document).on('keyup','.coin-qnty',function(){
        var unit = $(this).val();
        if (!($.isNumeric(unit))) {
            $('.sub_unit_err').text('Coin Unit Must Be Numeric');
            $(this).val('');
        }
    });

    $(document).on('keyup','.coin-price',function(){
        var unit = $(this).val();
        if (!($.isNumeric(unit))) {
            $('.sub_unit_err').text('Coin Price Must Be Numeric');
            $(this).val('');
        }
    });

    $('#total_unit').keyup(function(){
        var unit = $(this).val();
        if (!($.isNumeric(unit))) {
            $('.err_response').text('Total Unit Must Be Numeric');
            $('#total_unit').val('');
        }
    });

    $('.check_unit').click(function(e){
        e.preventDefault();
        var from_date = $('#from_date').val();
        if(from_date == ''){
            $('#from_date').focus();
            $('.date_err').text('Date Fields are necessary');
        }
        var to_date   = $('#to_date').val();

        if(to_date == ''){
            $('#to_date').focus();
            $('.date_err').text('Date Fields are necessary');
        }

        if((to_date != '') && (to_date<=from_date)){
            $('#to_date').focus();
            $('.date_err').text('End Date should be greater than Start Date.');
        }

        var total_coin_unit = $('#total_unit').val();
        if(total_coin_unit==''){
            $('.err_response').text('Insert Total Unit');
        }

        var coin_qnty = $('.coin-qnty').val();
        var coin_price = $('.coin-price').val();
        if(coin_qnty == ''){
            $('.coin-qnty').focus();
            $('.sub_unit_err').text('Coin Unit Can not be Blank');
        }

        if(coin_price == ''){
            $('.coin-price').focus();
            $('.sub_unit_err').text('Coin Price Can not be Blank');
        }

        var qty = total_qty = total_unit= 0;
        $('.coin-qnty').each(function() {
            qty = $(this).val();
            total_qty += parseInt(qty);
        });

        total_unit = parseInt(total_coin_unit);

        if((total_coin_unit!='') && (coin_qnty!='') && (coin_price!='')){
            if(total_unit<total_qty){
                $('.err_response').text('Total Units must be same with sub units');
            }else{
                $('#pre_sale_form').submit();
            }
        }
    });


</script>--}}
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script>
    $('.date-picker').datepicker({
        orientation: "bottom",
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $(document).on('submit', '.onSubmitdisableButton', function(e) {	
		  if (confirm("Are You Sure ?") == true) {
			$('.submitButton').attr('disabled',true);
			return true;
		  } else {
			return false;
		  }
	});
</script>
@endpush
