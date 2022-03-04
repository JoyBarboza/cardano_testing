


<div class="overlay">
    <div class="overlayDoor"></div>
    <div class="overlayContent">
        <div class="">
            <img src="{{ asset('/time/images/logo_icon.png?gf') }}" alt="">
            <p>Loading.....</p>
        </div>
    </div>
</div>




<script src="{{ asset('/time/js/vendor/modernizr-3.6.0.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/vendor/jquery-1.12.4.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/popper.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/bootstrap.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/jquery.nice-select.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/jquery.syotimer.min.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/main.js') }}?v={{time()}}"></script>
<script src="{{ asset('/time/js/polygonizr.min.js') }}?v={{time()}}"></script>

<script type="text/javascript" src="{{ asset('js/home3/jquery.flagstrap.min.js') }}"></script>

<script>

    $(document).ready(function() {
            $('.skip').click(function() {
                $('.overlay, body').addClass('loaded');
            })
            
             $(window).bind('load', function() {
                $('.overlay, body').addClass('loaded');
                setTimeout(function() {
                    $('.overlay').css({'display':'none'})
                }, 2000)
            });
            
            setTimeout(function() {
                $('.overlay, body').addClass('loaded');
            }, 60000);
        })
    
    
    
            $('.nav-link').click(function(){
            $('html, body').animate({
                scrollTop: $( $(this).attr('href') ).offset().top
            }, 500);
            return false;
        });
    </script>



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
