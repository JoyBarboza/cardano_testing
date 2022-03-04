<section class="member-status rights closed"> 
    <div class="sidebar-member">
       
        <div class="">
            
            <div class=" scroll">
                @php
                $announcements = \App\Announcement::where('status',1)->latest()->take(10)->get();
                @endphp
                <ul class="notify">
                @forelse($announcements as $announcement)
                    <li>                        
                        <div class="notify-content">
                            {{$announcement->title}}
                        </div>
                        <div class="clearfix"></div>
                    </li>
                @empty
                    <li>                        
                        <div class="notify-content">
                        
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    
                @endforelse  
                <li>                        
                        <a href="{{route('account.announcements')}}"><div class="notify-content">
                        {{trans('announcement/index.view_all')}}
                        </div></a>
                        <div class="clearfix"></div>
                    </li>  
                </ul>
            </div>
        </div>
    </div>
</section>
