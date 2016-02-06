var paAPI = {
	config : {
		website_url : 'http://www.hoangweb.com/wp-content/themes/patricia/checkdomain_tool',
		base_url : 'http://www.hoangweb.com'
	},
	preload_assets: function(app_path){
		var pic = new Image(),
			pic2 = new Image(),
			pic3 = new Image();
			pic4 = new Image();
		pic.src = app_path+"/images/ajax-loader.gif";
		pic2.src = app_path+"/images/btnCheck1.png";
		pic3.src = app_path+"/images/bad.png";
		pic4.src = app_path+"/images/loadingbar.GIF";
		
	},
	data : {},	//storage
	init: function(){
		olark('api.box.onShow',function(){
			//remove "POWERED BY OLARK"
			$('#habla_middle_div').next().hide();
			
		});
		olark('api.visitor.updateCustomFields',function(){
			hoangdata: '2194832109'
		});
		//message to operator from visitor
		olark('api.chat.onNotificationToOperator',function(msg){
		  if(msg.notification.body.indexOf('[from_checkDomainTool]') !== -1){
			var domain_str=msg.notification.body.match(/\(.+\)/g);
			if(domain_str.length) domain_str = domain_str[0];
			olark('api.chat.sendNotificationToVisitor', {body: "Xác nhận! hoangweb đã nhận được yêu cầu đăng ký domain \""+domain_str+"\" nếu đúng vui lòng nhập SĐT của bạn vào đây, tôi sẽ gọi cho bạn? hoặc gọi đến số 0944.049.910 để được mua ngay."});
		  }
		  //console.log(msg);
		});
	},
	/**
	*@check domain for available
	*/
	checkDomain : function(name,data,cb_success,cb_error){
		$.ajax({
			url:paAPI.config.website_url+"/checkDomain.php?domain="+name,
			data:data,
			type: 'POST',
			success:function(d){
				if(typeof cb_success == 'function') cb_success(d);
				
			},
			error:function(e){
				if(typeof cb_error == 'function') cb_error(e);
			},
			dataType:'json'
		});
	},
	//clear histories
	clearHistory : function(ele){
		$(ele).addClass('loading-status');
		$.ajax({
			url: paAPI.config.website_url+"/ajax.php?do=clear_history",
			success: function(){
				$(ele).removeClass('loading-status');
				window.location.href=window.location.href;
			}
		});
	},
	//create group of domain name
	create_group : function(name){
		arguments.callee.data= arguments.callee.data || {};
		if(!arguments.callee.data[name]){
			var l=$('<h2/>').html(name);
			$('#result-domains-checking').append(l);
			arguments.callee.data[name] = l;
		}
	},
	//number counter
	countdown: function(cb,max){
		var maxSec = jQuery.isNumeric(max)? max : 10;
		var intv = setInterval(function(){
			maxSec--;
			if(maxSec == 0) clearInterval(maxSec);
			if(typeof cb == 'function') cb(maxSec);
		},1000);
	},
	domain_result_ui: function(data){
		/*if(typeof data != 'object'
			|| !data.result || !data.domain) return;*/
		
		var item = $('#check-domain-result').clone().removeClass('hidden').attr('data-ext',data.tld).addClass('checking');
		item.find('.divdomain').attr('id',data.domain.replace('.','_')).html(data.domain);
		var year_price = item.find('.year_price').addClass('loading-status'),	//year price holder
			start_price = item.find('.start_price').addClass('loading-status');	//start price holder
		item.find('.kq_tools').addClass('loading-status');	//tools buttons
		
		//event
		function item_click_event(){
			item.addClass('loadingBar').css('cursor','default');
			item.unbind('click',item_click_event);
			paAPI.hw_WhoisDomain(data.domain,function(){
				item.removeClass('loadingBar').css('cursor','pointer');
				item.bind('click',item_click_event);
			});
		};
		
		item.find('.buythis').bind('click',function(){	//contact form
			window.open(paAPI.config.base_url+'/buy-domain?domain='+data.domain,"_blank");
		});
		/*window resize event*/
		$(window).resize(function() {
			//update dialog position
			if(item.data('dlg')) item.data('dlg').dialog("option", "position", "center");
		});
		function item_chat_click_event(){	//chat with operator
			var self = this;
			if(typeof olark != 'undefined'){
				$(self).unbind('click',item_chat_click_event).css('background','gray');	//unbind click event for this button
				//registry domain form
				var reg_form = $(document.createElement('div')).addClass('loading-status');	
				//#alternate you can build own script that to include wordpress environment
				$.ajax({
					url: paAPI.config.base_url+'/popup-domain-registry-form?domain='+data.domain,
					success:function(d){
						reg_form.html(d);
						$(reg_form).removeClass('loading-status');
						//center dialog
						dlg.dialog("option", "position", "center");
					}
				});
				/*reg_form.load(paAPI.config.base_url+'/popup-domain-registry-form?domain='+data.domain,function(){
					$(this).removeClass('loading-status');
					//center dialog
					dlg.dialog("option", "position", "center");
				});*/
				var dlg = $('<div/>').attr('title','Hướng dẫn mua tên miền').append(reg_form).dialog({width:550,modal:true})	//show form
				.bind('dialogclose', function(event) {
					item.data('dlg',undefined); 
				});
				my=dlg;
				item.data({
					dlg : dlg,
					dialog_callback : function(data){console.log(data);
						//send to operator
						if(data.mailSent == 1){
							var posts = data.posted_data;
							var str = "\nName: "+posts['fullname']
								+"\nEmail : "+posts['email']
								+"\nPhone : "+posts['phone']
								+"\nDomain : "+posts['domain']
								+"\nSubject : "+posts['subject']
								+"\nMsg : "+posts['message'];
							olark('api.chat.sendNotificationToOperator', {body: "[RegisterDomainForm]"+str});
						}
						
						setTimeout(function(){
							var time = document.createElement('span');
							reg_form.empty().html('Cảm ơn bạn đã đăng ký dịch vụ của chúng tôi! <br/>Chúng tôi sẽ gọi điện xác nhận tên miền của bạn  ngay trong chốc lát.').append(time);
							dlg.dialog();	//re-generate dialog
							paAPI.countdown(function(i){
								if(i==0){
									dlg.dialog('close');	//close dialog
								}else{
									$(time).html('(Đếm ngược '+i+' s)');
								}
							},5);
							/*$(this).delay(2000).queue(function(next){
								$(this).remove();
								next();
								dlg.dialog('close');	//close dialog
							});*/
						},2000);
						
					}
				});
				//tell to admin about this order
				olark('api.chat.onNotificationToOperator',function(msg){
					if(msg.notification.body.indexOf('[from_checkDomainTool]') !== -1){
						$(self).hide();	//hide this button
						//notify this to customer
						olark('api.chat.sendNotificationToOperator', {body: "Từ công cụ check domain: đã thông báo cho khách hàng."});
					}
				});
				//popup olark chatbox
				/*olark('api.box.show');
				olark('api.box.expand');*/
				olark('api.chat.sendNotificationToOperator', {body: "[from_checkDomainTool]Từ công cụ check domain: có khách muốn mua domain ("+data.domain+"),"});
			}
		}
		item.find('.chat').bind('click',item_chat_click_event);
		
		paAPI.data[data.domain] = {ui: item, domain: data.domain,name: data.name, tld: data.tld};
		
		paAPI.create_group(data.name);
		$('#result-domains-checking').append(item);	//append to list
		//private methods
		/*set buyable state*/
		function setBuyable(opt){
			//visible something
			item.find('.kq_tools').removeClass('hidden').removeClass('loading-status');
			item.find('.buythis').removeClass('hidden');
			item.find('.chat').removeClass('hidden');
			if(opt==true){	//unavailable
				item.find('.buythis').show();
				item.find('.chat').show();
				item.addClass('unavaiable');
			}else{	//available
				//item.find('.kq_tools').hide();
				item.find('.buythis').hide();
				item.find('.chat').hide();
				item.addClass('avaiable');//.css({'cursor':'pointer'});
				item.find('.whois').eq(0).removeClass('hidden').bind('click',item_click_event);	//get whois domain info
			}
		}
		//display tld price
		function displayPrice(price){
			year_price.removeClass('loading-status');
			start_price.removeClass('loading-status');
			if(typeof price == 'object'){
			year_price.html(parseFloat(price.year_fee)? price.year_fee+' VNĐ' : 'Miễn phí');
			start_price.html(parseFloat(price.start_fee)? price.start_fee+' VNĐ' : 'Miễn phí');
			}
			else{
				year_price.html('error');
				start_price.html('error');
			}
		}
		//init
		function init(){
			
		}
		return {
			ui:item,setBuyable:setBuyable, displayPrice: displayPrice, init: init
		};
	},
	//filter domains
	hw_filterHistoryDomains: function(cInput){
		var tld = cInput.value;
		for(var s in paAPI.data){
			if(paAPI.data[s].tld == tld){
				if(cInput.checked == true ) paAPI.data[s].ui.show();	//show domain in which that tld
				else paAPI.data[s].ui.hide();	//else hidden it
			}
		};
	},
	//get on whois
	hw_WhoisDomain: function(domain,callback){
		$.ajax({
			url: paAPI.config.website_url+'/checkDomain.php?cmd=get_whois&domain='+domain,
			success:function(d){
				/*var content = $(d).find('.whois_main_column');
				var item1 = $(d).find('#registryBlk');//.find('.whois_update').hide();
				var item2 = $(d).find('#registrarBlk');//.find('.whois_update').hide();
				//$(document.body).append([item1,item2]);*/
				var getWhois_url = paAPI.config.website_url+'/viewsWhois.php?domain='+domain;
				//show dialog
				$( "<div/>" ).css({'padding':'0px'}).attr('title','Thông tin whois').html('<iframe width="100%" frameborder="0" height="400px" src="'+getWhois_url+'"/>').dialog({
					modal: true,
					width: "60%",
					maxWidth: "400px"
				});
				if(typeof callback == 'function') callback(d);
			}
		});
	}
}
