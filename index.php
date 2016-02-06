<?php 
include('config.php');
include('functions.php');

?><div class="domain_search">
<form action="<?php echo site_url('dang-ky-ten-mien')?>" method="POST" >
<div class="search_box">
<input type="text" name="domain_n" placeholder="Gõ tên miền cần kiểm tra" value=""/>
<p class="bt"><input type="image" src="<?php echo get_stylesheet_directory_uri()?>/checkdomain_tool/images/search_bt.png" name="checkdm" class="btn-primary" value="Kiem tra"/></p>
<div class="clear"></div>
</div>

<div class="first-popular-tlds">
	<?php foreach(explode(',',$config['popularTLD']) as $tld){?>
	<div class="tld">
		<label><input type="checkbox" name="tlds[]" <?php if(is_tld_default($tld)) echo ' checked="checked" '?> value="<?php echo $tld?>"/> .<?php echo $tld?></label>
		</div>
	<?php }?>
	<div class="clear"></div>
</div>

</form>
<ul>
	<li><a href="<?php echo site_url('dang-ky-ten-mien')?>">Kiểm tra nhiều tên miền</a></li>
	<li><a href="<?php echo site_url('chuyen-doi-nha-cung-cap-ten-mien')?>">Transfer tên miền về HOANGWEB</a></li>
</ul>
</div>