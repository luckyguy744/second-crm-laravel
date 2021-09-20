 <?php

 ////////// mail///////////////////////////////////


	    'adm_wd_msg'		=> ' Hi, this is to notify you that your withdrawal request with ID: <b>{{$md['wd_id']}} on {{env('APP_URL')}} </b> has been approved. <br> 
        	   Kindly wait patiently for deposit into your account.',
	    'adm_wd'			=> 'Withdrawal Approval',
	    'adm_dep_notf'		=> '      	<p>
        	   Hi Admin, <b>{{$md['username']}}</b> has deposited on {{env('APP_URL')}}.
        	   <br>
               Kindly attend to this transaction.
        	   
        	</p>',
	    'adm_dep'			=> 'Deposit Notification',		
	    'adm_inv_notf'		=> 'Investment Notification',
	    'adm_inv_notf'					=> ' <p>
               Hi Admin, <b>{{$md['username']}}</b> has just invested on {{env('APP_URL')}}.
               <br>
               Kindly attend to this transaction.               
            </p>',
	    'adm_kyc_notf'					=> 'KYC Approval Request',
	    'adm_kyc_notf'					=> ' <p>
                           Hi Admin, <b>{{$md['username']}} on {{env('APP_NAME')}} </b> has submitted KYC documents for approval. <br> 
                           Kindly attend to this request.<br>                           
                        </p>',
	    'adm_res_pwd'					=> 'Password Reset',
	    'adm_res_pwd'					=> 'Password reset Notification',
	    'adm_res-pwd'					=> '<p>
        	   Your request to reset your password on {{env('APP_NAME')}} was successful. Your new password is <br> <b>{{ $md['new_pwd'] }}</b>
        	</p>',
	    'adm_tck_msg'					=> 'Tickect Message',
	    'adm_tck_msg'					=> '  <p>
               Hi, <b>{{$md['username']}}</b> you have a message from {{env('APP_URL')}} support team.
               <br>
               Kindly check if your issue has been solved.               
            </p>',
	    'adm_wd_notf'					=> '<p>
        	   Hi, this is to notify you that <b>{{$md['username']}}</b> has made a withdrawal request on {{env('APP_URL')}}
        	   <br>
        	   Kindly attend to this withdrawal request.
        	</p>',
	    'adm_wd_notf'					=> 'Withdrawal Notification',
	    'login_noft'					=> '>Login Notification',
	    'login_noft'					=> ' Hi {{$md['username']}}',
	    'login_noft'					=> '	<p>
		This is to notify you that there is a login into your account a moment ago.<br>
		If you were not the one please contact support now for a quick action.<br>
		<br>
		Contact support now: {{env('SUPPORT_EMAIL')}}
	</p>',
	    'pwd_reqs'					=> '<p>
		You receive this mail because you requested for password reset for your account a moment ago.<br>
		If you were not the one please contact support now for a quick action.<br>
		<br>
		<a  href="{{env('APP_URL')}}/reset/password/{{$md['username']}}/{{$md['token']}}">Reset Password</a><br><br>
		Contact support now: {{env('SUPPORT_EMAIL')}}
	</p>',
	    'reg_conf'					=> 'Registration Confirmation',
	    'reg_conf'					=> 'Hi {{$md['usr']}}, ',
	    'reg_conf_msg'					=> '',
	    'usr_dep_notf'					=> 'Deposit Notification',
	    'usr_dep_notf'					=> '<p>
        	   Hi, <b>{{$md['username']}}</b> your deposit on {{env('APP_URL')}} was successful.
        	   <br>
               Your wallet balance will be updated shortly.
        	   
        	</p>',
	    'usr_inv_motf'					=> 'Investment Notification',
	    'usr_inv_notf'					=> '<p>
        	   Hi, <b>{{$md['username']}}</b> your Investment on {{env('APP_URL')}} was successful.
        	   <br>
               You can check your investment growth under my investments on your dashboard.
        	   
        	</p>',
	    'usr_tck_msg'					=> ' <p>
               Hi Admin, <b>{{$md['username']}}</b> has left a message on {{env('APP_URL')}}.
               <br>
               Kindly attend to this message.               
            </p>',
	    'usr_wd_notf'					=> '<p>
        	   Hi, <b>{{$md['username']}}</b> your withdrawal request on {{env('APP_URL')}} has been created successfully.
        	   <br>
        	   Kindly attend to this withdrawal request.
        	</p>',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',
	    ''					=> '',