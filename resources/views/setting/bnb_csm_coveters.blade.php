@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>BNB To CSM Converter</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
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
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            @include('flash::message')
            <hr><h3 style="margin:10px;">BNB To CSM Converter</h3><hr>
            <form method="POST" action="{{ route('admin.update_bnb_csm') }}" enctype="multipart/form-data" data-parsley-validate>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$bnb_csm->id}}">
                <div class="card-widget white">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                <div class="row margin-top-20">
                                    
                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">CSM</h6>

                                        <input type='text' name="csm" id="csm" required data-parsley-required data-parsley-required-message="Enter the csm" value="{{$bnb_csm->csm}}" readonly/>
                                    </div>  

                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">BNB</h6>

                                        <input type='text' name="bnb" id="bnb" required data-parsley-required data-parsley-required-message="Enter bnb amount" value="{{$bnb_csm->bnb}}"/>
                                    </div>   

                                                            
                                </div>
                                 <div class="col-md-12">
                                    <button type="submit" class="btn mint_submit btn-block btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
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
