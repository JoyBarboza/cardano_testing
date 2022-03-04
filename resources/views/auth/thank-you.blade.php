<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partial.front.htmlheader')

<style>
   .thankyou_inner .f_media_bg_ul{margin-top:30px; text-align:center}
   .thankyou_inner .f_media_bg_ul li{display: inline-block; width: auto; float:unset;}
   .thankyou_inner .f_media_bg_ul li a span { color: #0c0c0c; display: block; font-size: 12px; margin-top: 10px;}
</style>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
    @include('layouts.partial.front.header')
    
    
    <section class="pt-50 pb-50">
        <div class="who-we-are-area">

        <div class="container thankyou_inner">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="who-we-are-content text-center">
                        <span> {{ config('app.name') }} </span>
                        <h3 class="title">{{trans('auth/thank-you.Registration_Done')}}!</h3>
                        <p>{{trans('auth/thank-you.Hello')}} {{ ($user)?$user->first_name:'' }},</p> 
                    </div>
                </div>
             </div>
             <div class="text-center">
               
                <p>{{trans('auth/thank-you.Congratulations_on_coming_onboard')}}!! </p>

                <p>{{trans('auth/thank-you.To_start_Login')}}. </p>

               <p> {{trans('auth/thank-you.Thanks_Regard')}},</p>
                   
               <br>
              <h4>Stay in Touch</h4>
                <ul class="f_media_bg_ul">
                    <li>
                        <a target="_blank" href="https://www.reddit.com/r/Caesium_lab/"><img src="/time/images/reddit.png" alt=""> <span>Reddit</span></a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.quora.com/profile/Caesiumlab-2"><img src="/time/images/quora.png" alt=""> <span>Quora</span></a>
                    </li>
                    <li>   
                        <a target="_blank" href="https://twitter.com/Caesiumlab"><img src="/time/images/twitter.png" alt=""> <span>Twitter</span></a>
                    </li>
                    <li>   
                        <a target="_blank" href="https://www.linkedin.com/in/caesiumlab"><img src="/time/images/linkedin.png?dfx" alt=""> <span>LinkedIn</span></a>
                    </li>
                    <li>
                        <a target="_blank" href="https://discord.gg/U9HChy9Hyq"><img src="/time/images/discord.png" alt=""> <span>Discord</span></a>
                    </li>
                    <li>    
                        <a target="_blank" href="https://caesiumlab.slack.com/"><img src="/time/images/slack.png" alt=""> <span>Slack</span></a>
                    </li>
                    <li>   
                        <a target="_blank" href="https://www.facebook.com/Caesiumlab2/"><img src="/time/images/facebook.png" alt=""> <span>Facebook</span></a>
                    </li>
                    <li>    
                        <a target="_blank" href="https://t.me/Caesiumlab"><img src="/time/images/telegram.png?f" alt=""> <span>Telegram</span></a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.youtube.com/channel/UCGI-hbW0IqnigZWmviaIL-g"><img src="/time/images/youtube.png" alt=""> <span>Youtube</span></a>
                    </li>
                    <li>
                        <a target="_blank" href="https://bitcointalk.org/"><img src="/time/images/bitcointalk.png" alt=""> <span>Bitcointalk</span></a>
                    </li>
                </ul>
            </div>



        </div>




    </section>


    @include('layouts.partial.front.footer')

<a id="scroll_up" class="main-btn"><i class="far fa-angle-up"></i></a>

@include('layouts.partial.front.scripts')
</body>
</html>
