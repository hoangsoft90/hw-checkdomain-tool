<?php //session_start();?>
	<!--
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
-->
	  <!-- <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> -->
	  
	  <script src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/js/api.js"></script>
	  <script>
	  pic = new Image();
  pic2 = new Image();
  pic3 = new Image();
    pic.src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/images/ajax-loader.gif";
    pic2.src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/images/btnCheck1.png";
    pic3.src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/images/bad.png";
	  </script>
	  <!-- olark -->
	  <!-- begin olark code -->

<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){

f[z]=function(){

(a.s=a.s||[]).push(arguments)};var a=f[z]._={

},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){

f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={

0:+new Date};a.P=function(u){

a.p[u]=new Date-a.p[0]};function s(){

a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){

hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){

return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){

b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{

b.contentWindow[g].open()}catch(w){

c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{

var t=b.contentWindow[g];t.write(p());t.close()}catch(x){

b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({

loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});

/* custom configuration goes here (www.olark.com/documentation) */

olark.identify('4862-511-10-8580');/*]]>*/</script><noscript><a href="https://www.olark.com/site/4862-511-10-8580/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>

<!-- end olark code -->
<!-- hidden -->
<div id="check-domain-result" data-ext="" class="check-domain checking hidden tb-row">
	<div id="" class="kq_name divdomain col"></div>
	<div class="kq_gia year_price col"></div>
	<div class="kq_gia start_price col"></div>
	<div class="col kq_tools hidden">
	<div class="btn-check-domain btn buythis hidden">Liên hệ</div>
	<div class="btn-check-domain btn chat hidden">Đăng ký</div>
	<div class="btn-get-whois btn whois hidden">Whois</div>
	</div>
</div>
<?php
include('config.php');
include('functions.php');

/**
first check domain in popular tlds
*/
if(isset($_POST['checkdm'])){
	//list tlds to check with domain name
	$listTlds2check = array_unique($_POST['tlds']);
	//more domain name check for avaiable
	$multi_domains = parse_all_domains($_POST['domain_n']);
}
/**-----------------------------------multi-check-domains------------------------------------------------
* action
*/
if(isset($_POST['btn_multiCheckDm'])){
	if(!isset($_POST['tlds']) || !is_array($_POST['tlds']) || count($_POST['tlds'])==0 
		|| !$_POST['txt_multi_domains'])
	{
		echo 'Nothing to do!';
	}
	else{
//	goto NOTHING_TO_DO;
	//list tlds to check with domain name
	$listTlds2check = array_unique($_POST['tlds']);
	//more domain name check for avaiable
	$multi_domains = parse_all_domains($_POST['txt_multi_domains']);
	
	}
	
}
if(isset($multi_domains) && isset($listTlds2check)){
	//merge history domains
	$test=array();
	mergeHistoryDomainTlds($multi_domains,$test/*$listTlds2check*/);
	check_domains($multi_domains,$listTlds2check);
}
?>
<script>
//paAPI.hw_WhoisDomain('hoangweb.com');
</script>


<div style="background:#fff;" class="check-multidomains-holder">
<form action="" method="POST" onsubmit="return valid_frm_checkdomain(this)">
<table width="100%" border="0">
	<tr>
		<td colspan="3" style="width: 315px;position: relative; padding-top: 18px;" class="pa-tld-header">
			<div style="position:relative;width:921px;">
			<h1 style="position: absolute; top: -5px; left: 50px; font-weight: normal; font-family: 'robotocondensed-regular', tahoma; font-size: 30px; color: #363636;">Nhập tên miền</h1>
			<h1 style="position: absolute; top: -5px; left: 361px; font-weight: normal; font-family: 'robotocondensed-regular', tahoma; font-size: 30px; color: #363636">Chọn đuôi tên miền</h1>
			<h1 class="dwKiemtra" style="position: absolute; top: -5px; right: -32px; font-weight: normal; font-family: 'robotocondensed-regular', tahoma; font-size: 30px; color: #363636">Kiểm tra</h1>
			
			<img src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/images/stepcheckdomain.png" style="margin-left: 20px; margin-bottom: 20px;">
			</div>
		</td>
	</tr>
	<tr>
		<td style="width: 315px;" valign="top" >
			<div class="reg-multi-domain-form"><textarea class="txt-reg-domain" name="txt_multi_domains" placeholder="Nhập tên miền cần kiểm tra" cols="40" rows="5" style="margin-bottom: 10px"><?php echo isset($_POST['txt_multi_domains'])? $_POST['txt_multi_domains']:''?></textarea>
		<h2 style="color: #b4b4b4; font-size: 12px;font-weight:normal;font-family:arial;">Nhập tên miền trên từng dòng hoặc cách khoảng trắng để kiểm tra nhiều tên miền. Mỗi tên miền chỉ 63 kí tự.</h2>
			</div>
		</td>
		<td style="padding-left:10px;position: relative" colspan="2" valign="top">
			
			<div id="tabs-tlds">
				<ul>
					<li><a href="#tabs-1">Phổ biến</a></li>
					<li><a href="#tabs-2">Tên miền việt nam</a></li>
					<li><a href="#tabs-3">Tên miền quốc tế</a></li>
					<li><a href="#tabs-4">Tên miền mới</a></li>
				</ul>
				<div id="tabs-1" class="tab-content">
				<p>
					<?php foreach(explode(',',$config['popularTLD']) as $tld){?>
					<div class="tld">
					<label><input type="checkbox" name="tlds[]" <?php if((isset($listTlds2check) && in_array($tld,$listTlds2check)) || is_tld_default($tld)) echo 'checked="checked"'?> value="<?php echo $tld?>"/> .<?php echo $tld?></label>
					</div>
					<?php }?>
				</p>
				<div class="clear"></div>
			  </div>
				<div id="tabs-2" class="tab-content">
					<?php foreach(explode(',',$config['vnTLD']) as $tld){?>
					<div class="tld"><label><input type="checkbox" name="tlds[]" <?php if((isset($listTlds2check) && in_array($tld,$listTlds2check)) || is_tld_default($tld)) echo 'checked="checked"'?> value="<?php echo $tld?>"/> .<?php echo $tld?></label></div>
					<?php }?>
					<div class="clear"></div>
				</div>
				<div id="tabs-3" class="tab-content">
					<?php foreach(explode(',',$config['nationalTLD']) as $tld){?>
					<div class="tld"><label><input type="checkbox" name="tlds[]" <?php if((isset($listTlds2check) && in_array($tld,$listTlds2check)) || is_tld_default($tld)) echo 'checked="checked"'?> value="<?php echo $tld?>"/> .<?php echo $tld?></label></div>
					<?php }?>
					<div class="clear"></div>
				</div>
				<div id="tabs-4" class="tab-content">
					<?php foreach(explode(',',$config['newTLD']) as $tld){?>
					<div class="tld"><label><input type="checkbox" name="tlds[]" <?php if((isset($listTlds2check) && in_array($tld,$listTlds2check)) || is_tld_default($tld)) echo 'checked="checked"'?> value="<?php echo $tld?>"/> .<?php echo $tld?></label></div>
					<?php }?>
					<div class="clear"></div>
				</div>
			</div>
			<input type="submit" name="btn_multiCheckDm" value="Kiểm tra" class="mybtn btn_check btn-primary"/>
		</td>
	</tr>
	
</table>

</form>
<?php if(isset($listTlds2check) && is_array($listTlds2check) && count($listTlds2check)){	//if get form data?>
<div class="history-domain-panel">
<h3 class="newtitledomain">Lịch sử kiểm tra tên miền</h3>
<table width="100%" border="0" style="clear:both;">
	<tr>
		<td valign="top" width="20%" style="/*width: 215px;*/">
			
			<h4 class="title">Chọn lọc</h4>
			<div id="filter-tlds">
			<!-- <ul> -->
			<?php foreach($listTlds2check as $tld){?>
				<div class="checkbox-ext" data-ext="<?php echo $tld?>">
				<label ><input type="checkbox" checked="checked" onclick="paAPI.hw_filterHistoryDomains(this)" value="<?php echo $tld?>"/> .<?php echo $tld?></label>
				</div>
			<?php }?>
			<!-- </ul> -->
			</div>
			<p><a href="javascript:void(0)" onclick="paAPI.clearHistory(this)" class="btn btn-default">Xóa lịch sử</a></p>
		</td>
		<td width="80%" valign="top" class="">
			<div id="ketquakiemtra">
				<div class="kq_caption_tenmien">Tên miền</div>
				<div class="kq_caption_phiduytri">Phí duy trì</div>
				<div class="kq_caption_phiduytri">Phí khởi tạo</div>
				<div class="kq_caption_tools">Thông tin Whois</div>
			</div>
			<div id="result-domains-checking">
			
			</div>
		</td>
	</tr>
</table>
</div>
<?php }?>
</div>
<script>
  $(function() {
    $( "#tabs-tlds" ).tabs();
  });
  //init
$(function(){
	paAPI.init();
});
/**
valid check domain form
*/
function valid_frm_checkdomain(frm){
	//remove class
	$(frm.txt_multi_domains).removeClass('invalid_value');
	if(!frm.txt_multi_domains.value){	//get list domains
		frm.txt_multi_domains.focus();
		$(frm.txt_multi_domains).addClass('invalid_value');
		return false;
	}
	return true;
}
<?php ?>
</script>