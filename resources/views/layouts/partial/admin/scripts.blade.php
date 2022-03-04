<!--[if lt IE 9]>
<script src="{{ asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/excanvas.min.js') }}"></script> 
<script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<!-- <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script> -->
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/jquery.flagstrap.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- END THEME LAYOUT SCRIPTS -->
<!-- START PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
	   @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif
        @if(session('status_err'))
            toastr.error("{{ session('status_err') }}");
        @endif  
        
	var language = $('html').attr('lang');
	//~ var baseURL = '{!! url("/") !!}/' + language + '/';
	var baseURL = window.location.origin+'/' + language + '/';
	$(document).ready(function(){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('#select_country').attr('data-selected-country',language.toUpperCase());

		$('#select_country').flagStrap({
			onSelect: function (value, element) {
			value = $(element).children("option[selected=selected]").val();
				var url = baseURL + 'locale/' + value;

				$.ajax({
					type: "GET",
					url: url,
					dataType:"json",
					success: function( result ) {
						if(result.status) {
							location.href = result.locale;
						}
					}
				});
			}
		});
	});
</script>
@stack('js')
<!-- END PAGE LAVEL SCRIPTS -->
