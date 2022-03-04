@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>Add FT</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
@endsection
<style>
    .mint_form #left-code {
        width: 300px;
        font-size: 16px;
    }
    .mint_form {
        display: inline-block;
        width: 100%;
        padding: 25px;
        background: #fff;
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 50%);
    }
    .mint_form .col-md-12 {
        display: flex;
        align-items: center;
        margin: 5px auto;
    }
    .mint_form input, .mint_form textarea {
        width: calc(100% - 350px);
        margin-left: auto;
        border: 1px solid #ddd;
    }
    
    .mint_form input {
        height: 38px;
    }
    .mint_form textarea {
        height: 100px;
    }
    .mint_submit {
        margin: 15px auto;
        display: block;
        width: 250px !important;
        font-size: 17px !important;
    }
</style>
@section('contents')
    <div class="row">

        <div class="col-md-12 col-sm-12">
            <h3>Add FT</h3><hr>

            @include('flash::message')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!--<form action="#" data-parsley-validate enctype="multipart/form-data"/>-->
                {{ csrf_field() }}
                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                <div class="row margin-top-20">
                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">FT Name</h6>

                                        <input type='text' name="name" id="f_name" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_name')}}"/>
                                    </div>  

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">FT Image</h6>

                                         <img width="100" id="f_img_add" name="nft_img">

                                        <!--<input type='file' name="nft_img" id="imgadd" class="upload" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_img')}}"/>-->
                                        
                                         <input type="file" name="nft_img" id="ft_photo" required data-parsley-required data-parsley-required-message="FT Image">
                                         <!--<button type="button" id="hash" name="hash" onclick="download()">Download</button>-->
                                    </div>
                                    
                                    <input type='hidden' name="ipfs_url" id="ipfs_url" value=""/>

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">FT Descripition</h6>
                                        <textarea name="descripition" id="f_descripition" class="upload" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_descripition')}}"></textarea>
                                    </div>    

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">FT Price</h6>
                                        <input type='number' name="price" id="f_price" required data-parsley-required data-parsley-required-message="FT Price" min="1" />
                                    </div>                              
                                </div>
                                 <div class="col-md-12">
                                    <button type="submit" class="btn mint_submit btn-block btn-primary" onclick="add_ft()">Add FT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</form>-->
        </div>		
    </div>
@endsection
@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.stack.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.crosshair.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.axislabels.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.time.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ asset('assets/pages/scripts/charts-flotcharts.js') }}?v={{time()}}" type="text/javascript"></script> 
    <!-- END PAGE LEVEL SCRIPTS -->
    
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>
<script type="text/javascript">
				
</script>
@endpush
