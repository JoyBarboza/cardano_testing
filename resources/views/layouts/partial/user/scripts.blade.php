

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript" src="{{ asset('js/home3/jquery.flagstrap.min.js') }}"></script>

{{--<script src="{{ asset('/time/js/vendor/modernizr-3.6.0.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/vendor/jquery-1.12.4.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/bootstrap.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/popper.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/jquery.nice-select.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/jquery.syotimer.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/main.js') }}?v={{time()}}"></script>--}}

   <!-- <script src="{{ asset('web/js/parsley.js') }}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
        $('.nav-link').click(function(){
        $('html, body').animate({
            scrollTop: $( $(this).attr('href') ).offset().top
        }, 500);
        return false;
    });
</script>

<!--



<script src="{{ asset('/masonicoin/js/tether.min.js') }}"></script>
<script src="{{ asset('/masonicoin/js/bootstrap4-alpha3.min.js') }}"></script>
<script src="{{ asset('/masonicoin/js/jquery.flagstrap.min.js') }}"></script>



<script type="text/javascript" src="{{ asset('/masonicoin/js/jquery.mCustomScrollbar.js') }}"></script>
<script src="{{ asset('/masonicoin/js/smoothscroll.js') }}"></script>


<script src="{{ asset('/masonicoin/js/main.js') }}"></script>	
-->
<script>
     $('.button-menu-right').click(function(){
        $('.button-menu-right').toggleClass('active');
        $('main').toggleClass('open');
        $('.member-status').toggleClass('closed');
    });
    $('.top-button').click(function(){
        $('.logo').toggleClass('active');
        $('.top-button').toggleClass('active');
        $('.vertical-navigation').toggleClass('active show');
    });
    $('.user').click(function(){
        $('.user').toggleClass('open');
        $('.dropdown-menu').toggleClass('active');
    });
    $(document).ready(function(){
        $('main').addClass('open');
    });
</script>


<script>
    @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if(session('status_err'))
            toastr.error("{{ session('status_err') }}");
        @endif  

    var baseURL = $('base').attr('href');
    var language = $('html').attr('lang');

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#select_country').attr('data-selected-country',language.toUpperCase());

        $('#select_country').flagStrap({
            onSelect: function (value, element) {
		value = $(element).children("option[selected=selected]").val();
		var url = baseURL + '/locale/' + value;
        console.log(url);

		
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
