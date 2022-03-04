<div class="modal-dialog" @yield('modalSize')>
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@yield('dialogTitle')</h4>
        </div>
        @yield('dialogContent')    
    </div>
</div>