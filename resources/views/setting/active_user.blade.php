@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>Active User</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- <hr><h3 style="margin:10px;">Active User</h3><hr> -->

            <hr>
            <div  style="display: flex;">
                <h3 style="margin:10px;">Active User</h3>
                <div class="" style="margin-left: auto;">
                    <a href="{{ route('admin.active') }}" class="nav-link" style="margin-left: 25px; border:1px solid blue; border-radius:25px !important; padding:2px 15px;">Active</a>
                    
                    <a href="{{ route('admin.deactive') }}" class="nav-link" style="float: right; color: red; margin-left: 25px; border:1px solid red; border-radius:25px !important; padding:2px 15px;">Deactive</a>
                </div>
            </div>
                
            <hr>

            <table class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>User_name</th>
                        <th>Steps</th>
                        <th>Bullet Shot</th>
                        <th>Total Timeplayed</th>
                        <th>Status</th>
                        <th>CSM Wallet</th>
                        <!-- <th>Ipfs</th> -->
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @foreach($active_user as $m)
                        <tr>
                            <td>{{ $i++}}</td>
                            <td>{{$m['first_name']}}</td>
                            <td>{{$m['steps']}}</td>
                            <td>{{$m['bullets_shot']}}</td>
                            <td>{{$m['total_time']}}</td>
                            <td>
                                <?php
                                    if($m['status'] == 1){
                                        echo "Active";
                                    }else{
                                        echo "Deactive";
                                    }

                                ?>
                            </td>
                            <td>{{$m['cjm_wallet']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
