"use strict";

var p_min = 0;
var p_max = 0;


function confirm_inv(id, pn, p, di, min, max, wallet)
{
	p_min = min;
	p_max = max;
	
	$('#WalletBal').text(Math.fround(wallet).toFixed(2));
	$('#pack_inv').text(pn);
	$('#period').text(p);
	$('#intr').text(Math.fround(di*p*100).toFixed(2));
	$('#min').text(min);
	$('#max').text(max);
	$('#p_id').val(id);

	$('#popInvest').show();
	
}

////////////////////////////////// user /////////////////////////////////////////////////////////////
 
$(document).ready(function(){
	$('#country').on('change', function(){		
		var data = $('#country').val();
		$('#p_loading').show();
		$.ajax
		({
		    url: "/user/get/states/"+data,
		    type: "get",
		    // dataType: 'json',
		    data: data,
		    success:function(result)
		    {
		        var str = "";
		        var dt = JSON.parse(result);
		        $('#states').html("<option selected disabled>select state</option>");

		        for(var i = 0; i < dt.length; i++ )
		        {
		        	str = str + '<option value="'+dt[i].id+'">'+dt[i].name+'</option>';
		        }		                
		        $('#states').append(str);
		        // alert('here');
		    },
		    error: function (xhr) {	
		    	$('#p_loading').hide();	                
		        alert(xhr.responseText)		                
		    }
		   
		});   

		$.ajax
		({
		    url: "/user/get/countryCode/"+data,
		    type: "get",		            
		    data: data,
		    success:function(result)
		    { 
		        $('#cCode').val('+'+result);
		        $('#countryCode').html('+'+result);	
		        $('#p_loading').hide();	                
		    },
		    error: function (xhr) {	
		    	$('#p_loading').hide();	                
		        alert(xhr.responseText);		                
		    }
		   
		}); 

		// $('#p_loading').hide();       
	});
});



$('#selectPic').on ('click', function(){ 				
	$('#prPic').click();
});

$('#prPic').on('change', function(){
	$('#form_profilepic').submit();
});


$(document).ready(function()
{
    var amt = [];
    var user_id = [];
    var c = 0;

    $.ajax
    ({
        url: "/admin/getMonthlyIvCart",
        type: "get",           
        data: '',
        success:function(result)
        {
            var dt = JSON.parse(result);            
            for(var i in dt) 
            {
                amt.push(dt[i]);     
            }

            var ctx = document.getElementById('mycanvas');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan','Feb', 'Mar','Apr','May','Jun','Jul','Aug', 'Sep','Oct','Nov','Dec'],
                    datasets: [{
                        label: 'Investments this year:',
                        data: amt,
                        backgroundColor: [
                            'rgba(2, 99, 222, 0.9)',
                            'rgba(54, 162, 235, 0.9)',
                            'rgba(2, 20, 255, 0.9)',
                            'rgba(75, 192, 192, 0.9)',
                            'rgba(15, 102, 255, 0.9)',
                            'rgba(25, 159, 64, 0.9)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(153, 102, 255, 1)'
                            
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            // $('#data').html(c);                
        },
        error: function (xhr) {                     
            alert(xhr.responseText)                     
        }
       
    }); 
      
        
});


function inv(id, pn, p, di, min, max, wallet)
{
	alert("here");
}

function read(id, sta)
{
	if(sta == "yes")
	{
		$.ajax
	    ({
	        url: "/user/update/readmsg/"+id,
	        type: "get",		            
	        data: '',
	        success:function(result)
	        { 
	        	var ht = $('#dis_not'+id).html();	            
	            $('#read_not').fadeOut(1000, function(){
	            	$('#read_not').html(ht);
	            });	            
	            $('#read_not').fadeIn(2000);
	            	              
	        },
	        error: function (xhr) {		                
	            		                
	        }
	       
	    }); 
	}
}

function admread(id, sta)
{
	$('#readmsg').fadeIn(1000);
	$('#msgC').html($('#msg_cnts'+id).html());
}

function wd(p,id, earn, w_able, days, ended)
{
    $('#pack_type').val(p);
	$('#earned').text(earn);
	$('#days').text(days);
	$('#inv_id').val(id);
	$('#ended').val(ended);
	$('#withdrawable_amt').val(w_able);
	$('#div_withdrawal').show();

}
function edit_pack(id, min, max, interest, wd_fee, token, cur)
{
	$('#p_id').val(id);
	$('#min').val(min);
	$('#max').val(max);
	$('#interest').val(interest);
	$('#fee').val(wd_fee);
	$('#token').val(token);
	$('.pack_edit_cur').text(cur);

	$('#packEdit').show();

}


$(document).ready(function()
{  
    $('#invdata').show();
});

$(document).ready(function()
{ 
	$('#wd_ref_bal').click( function(){
		$('#ref_wd').show();
	});

	$('#wd_bal').click( function(){
		$('#wallet_wd').show();
	});

	$('#pay_with_bank').click( function(){
		$('#pay_cont').hide();
		$('#pay_with_bank_pop').fadeIn(1000);
	});

	$('#pay_with_card').click( function(){
		$('#pay_cont').hide();
		$('#pay_with_card_pop').fadeIn(1000);
	});
	
	$('#pay_with_btc').click( function(){
		$('#pay_cont').hide();
		$('#pay_with_btc_pop').fadeIn(1000);
        // alert("Coming soon........")
	});
});

$(document).ready(function () {

    if ($(window).width() < 1000 ) {
        $('.mob_d').css({'margin-top':'150px'});
    }
    else {
        $(".mob_drop").hide();
    }
    
    $(window).resize(function()     {
        
        if ($(window).width() < 1000 ) {
            $('.mob_d').css({'margin-top':'150px'});
        }
        else {
    
            $('.mob_d').css({'margin-top':''});
        }
        
    });
    

});

function view_pop(id)
{

	var atr = $('#img'+id).attr('src');
	$('#img_pop').attr('src', atr) ; 
	$('#dep_pop').fadeIn(1000);

}

function act_deact_pack(id)
{
	$.ajax
    ({
        url: "/admin/act_deact/pack/"+id,
        type: "get",		            
        data: '',
        success:function(result)
        { 
            if(result == 's')
            {
	            $('#suc').html('Package updated');
	            $('#suc').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);  
            }
            else
            {
                $('#err').html(result);
                $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            }
        },
        error: function (xhr) {	
            $('#err').html('Error updating package');
            $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);		                
        }
    }); 

}

function copy_txt() {
  /* Get the text field */
  var copyText = document.getElementById("reflnk");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Referral Link Copied, Share with Friends and Family to Earn 4% of their Investment");
} 

function load_get_ajax(url, id, content)
{
	$('#p_loading').show();
	$.ajax
    ({
        url: url,
        type: "get",		            
        data: '',
        dataType: 'json',
        success:function(result)
        { 
        	$('#p_loading').hide();
            if(content == 'admEditMsg')
            {               
	            $('#subject').val(result.subject);
                $('#msg_state').val(result.id);  
                $('#msg_users').text(result.users);       
	            tinyMCE.get('textmsg2').setContent(result.message); 	            
            }
            if(content == 'admDeleteMsg')
            {
                var dis_msg =  $('#del_msg_lang').html();
            	$('#suc').html(dis_msg);
            	$('#suc').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            	window.location.href = "";
            }            
        },
        error: function (xhr) {	
            $('#err').html('Error encountered!!!');
            $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            $('#p_loading').hide();		                
        }
    }); 

};



function load_post_ajax(url, id, content)
{
    $('#'+id).on('submit', function(e){
        e.preventDefault();
    });
  
	$('#p_loading').show();
    var data = new FormData(document.getElementById(id));
    
    $.ajax
    ({
        url: url,
        type: "post",                
        data: data,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(result)
        { 
        	$('#p_loading').hide();
            if(content == 'admin_settings_form')
            {   
            	if(result.type == 'suc')
            	{          
		            $('#suc').html(result.msg)
	            	$('#suc').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50); 
	            }
	            else
	            {
	            	$('#err').html(result.msg)
	            	$('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
	            }	            
            } 
            if(content == 'add_pack')
            { 
                if(result.type == 'suc')
            	{          
		            $('#suc').html(result.msg)
	            	$('#suc').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50); 
	            }
	            else
	            {
	            	$('#err').html(result.msg)
	            	$('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
	            }
            }
        },
        error: function (xhr) {	
            $('#err').html(xhr.responseText);
            alert(xhr.responseText);
            // $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            $('#p_loading').hide();		                
        }
    }); 

};

$(document).ready(function(){
    $('#comment_form').submit(function(e){
        e.preventDefault();
    });
});

function post_comment(user)
{    
    // $('#p_loading').show();
    var data = new FormData(document.getElementById('comment_form'));    
    $.ajax
    ({
        url: $('#comment_form').attr('action'),
        type: "post",                
        data: data,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(result)
        {            
            if(result.toast_type == 'suc' && user == 'support')
            {  
                $('#chat_msg_container').append(
                    '<div class="row col-sm-12 d-flex justify-content-end">\
                        <div class="talk-bubble tri-right right-top ">\
                          <div class="talktext">\
                            <p class="p-0">\
                                '+result.comment_msg+'\
                            </p>\
                            <small class="font_10 p-0"><i>'+result.comment_time+'</i></small>\
                          </div>\
                        </div>\
                        <p class="mg_top_30">\
                           <img src="/img/logo.png" alt="..." class="avatar_chat rounded-circle">\
                        </p>             \
                    </div>'
                );
                $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000); 
                $('#msg_entry').val('');
            }
            else if(result.toast_type == 'suc' && user == 'user')
            {
                $('#chat_msg_container').append(
                    '<div class="row col-sm-12 d-flex justify-content-end">\
                        <div class="talk-bubble tri-right right-top ">\
                          <div class="talktext">\
                            <p class="p-0">\
                                '+result.comment_msg+'\
                            </p>\
                            <small class="font_10 p-0"><i>'+result.comment_time+'</i></small>\
                          </div>\
                        </div>\
                        <p class="mg_top_30">\
                           <img src="/img/profile/'+result.user_img+'" alt="..." class="avatar_chat rounded-circle">\
                        </p>\
                    </div>'
                );
                $("#chat_msg_container").animate({ scrollTop: $('#chat_msg_container')[0].scrollHeight }, 1000); 
                $('#msg_entry').val('');
            }
            else
            {
                $('#err').html(result.toast_msg)
                $('#err').show().animate({ width: "30%" }, "1000").delay(6000).fadeOut(1000);
            }               
            
        },
        error: function (xhr) { 
                   
        }
    }); 

};

function load_chat()
{
    var id = $('#ticket_id').val();    
    $.ajax
    ({
        url: '/ticket/chat/'+id,
        type: 'get',                    
        data: {"id": id},
        dataType: 'json',
        success:function(result)
        {    
            if(Object.keys(result).length > 0)
            {  
                var i = 0;
                while(i < Object.keys(result).length)
                {   
                    $('#chat_msg_container').append(
                        '<div class="row col-sm-12">\
                            <p class="mg_top_30">\
                               <img src="/img/logo.png" alt="..." class="avatar_chat rounded-circle">\
                            </p>\
                            <div class="talk-bubble tri-right left-top ">\
                              <div class="talktext">\
                                <p class="p-0">\
                                    '+result[i].message+'\
                                </p>\
                                <small class="font_10 p-0 float-right"><i>'+result[i].created_at+'</i></small>\
                              </div>\
                            </div>\
                        </div>'
                    );
                    i = i+1;
                }
                $('#buzzer').get(0).play();
            }
            
        },
        error: function (xhr) { 
           
        }
    });
}

function load_chat_adm()
{
    var id = $('#ticket_id').val();    
    $.ajax
    ({
        url: '/support/chat/'+id,
        type: 'get',                    
        data: {"id": id},
        dataType: 'json',
        success:function(result)
        {    
            if(Object.keys(result).length > 0)
            {  
                var i = 0;
                while(i < Object.keys(result).length)
                {   
                    $('#chat_msg_container').append(
                        '<div class="row col-sm-12">\
                            <p class="mg_top_30">\
                               <img src="/img/profile/'+result[i].user.img+'" alt="..." class="avatar_chat rounded-circle">\
                            </p>\
                            <div class="talk-bubble tri-right left-top ">\
                              <div class="talktext">\
                                <p class="p-0">\
                                    '+result[i].message+'\
                                </p>\
                                <small class="font_10 p-0 float-right"><i>'+result[i].created_at+'</i></small>\
                              </div>\
                            </div>\
                        </div>'
                    );
                    i = i+1;
                }
                $('#buzzer').get(0).play();
            }
            
        },
        error: function (xhr) { 
            
        }
    });
}

function prvColor(id, input){
	$("#"+id+"color").css({'background-color': $("#input_"+input).val()});
}

function checkedOnOff(id)
{
	if($("#"+id).val() == 1)
	{
		$("#"+id).val(0);		
	}
	else
	{
		$("#"+id).val(1);		
	}
}

function s_2fa(opr)
{
    // window.location.href='/user/fa/'+opr;
    $('#p_loading').show();
    $.ajax
    ({
        url: '/user/fa/'+opr,
        type: "get",                    
        data: '',
        dataType: 'json',
        success:function(result)
        { 
            $('#p_loading').hide();
            if(result.msg == 'suc')
            {   $('#sec_enable_div').hide();
                $('#google_2fa_disable').hide();          
                $('#seccode').val(result.secret)  ;
                $('#img_2fa').attr('src', result.QR_Image)  ;
                $('#google_2fa_cont').show();           
            }
            if(result.msg == 'disable_2fa')
            {
                $('#sec_enable_div').hide(); 
                $('#google_2fa_cont').hide();        
                $('#google_2fa_disable').show();                
            } 
            if(result.msg == 'exist')
            { 
                $('#err').html('Two factor authentication is active');
                $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            }
            if(result.msg == 'disable')
            {
                $('#err').html('Two factor authentication is not active');
                $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);
            }      
        },
        error: function (xhr) { 
            $('#err').html(xhr);
            $('#p_loading').hide();  
            $('#err').show().animate({ width: "30%" }, "1000").delay(2000).animate({ width: "-50px" }, "1000").fadeOut(50);                               
        }
    }); 
}

$(document).ready( function(){
    $('#card_select').change(function(){
        if($('#card_select').val() == 'idcard_op' || $('#card_select').val() == 'driver_op')
        {
            $('#pass_cont').hide();
            $('#card_cont').show();
        }
        else if($('#card_select').val() == 'passport_op')
        {
            $('#card_cont').hide();
            $('#pass_cont').show();
        }
    });

    $('#lang_select').change(function(){
        // alert('here');
        var lang = $('#lang_select').val();
        // alert(lang);
        window.location.href = "/locale/"+lang;
    });
});

function set_inputs(num)
{
    var i = 1;
    var div_str = '';
    for(i = 1; i<=num; i++)
    {
        div_str = div_str+'<div class="col-sm-6 mt-3">\
                                <h6> Level '+i+' Referral Percentage </h6>\
                                <input type="number" step="any" name="'+i+'" value="" class="form-control" placeholder="" required>\
                            </div>';
    }
    $('#referal_levels_div').html(div_str);
    $('#warning_div').show();
}

$('#referal_system').on('change', function(){
    if($('#referal_system').val() == 'Multi_level')
    {
        $('#Multi_level_settings').show();
    }
    else
    {
        $('#Multi_level_settings').hide();
    }
});