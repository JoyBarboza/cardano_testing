
<div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<div class="row">
			<div class="col-md-12 fro_profile">
				<div class="fro_profile-main">
					<div class="fro_profile-main-pic">
						<img src="{{ $member->profile->avatar?:'avatars/' }}" alt="" class="rounded-circle">
					</div>
					<div class="fro_profile_user-detail">
						<p><strong>{{ __('Username') }}: </strong> {{ $member->username }}</p>
					</div>
				</div>
				
			</div>
			
		</div>
            
            <table class="table table-hover">
                
                <tbody>
                    
                    <tr>
                        <td><strong>{{ __('Total Referral') }}:</strong></td>
                        <td>{{ count($downline) }}</td>
                    </tr>
                    
                </tbody>
            </table>
       
          
        </div>
    </div>
</div>
