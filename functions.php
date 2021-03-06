<?php
/**
get tld price
*/
function get_tld_price($tld){
	$tld = trim($tld,'.');
	$tlds_price =array(
		'com,net'=>array('year_fee'=>'250.000','start_fee'=>'0'),
		'vn' =>array('year_fee'=>'480.000','start_fee'=>'350.000'),
		//".+\.vn" =>array('year_fee'=>'350.000','start_fee'=>'350.000'),
		'mobi' => array('year_fee'=>'445.000','start_fee'=>'0'),
		'org,info,link'=> array('year_fee'=>'258.000','start_fee'=>'0'),
		'com.vn,net.vn,biz.vn'=> array('year_fee'=>'350.000','start_fee'=>'350.000'),
		'org.vn,gov.vn,edu.vn,pro.vn,info.vn,int.vn,ac.vn,health.vn'=> array('year_fee'=>'200.000','start_fee'=>'200.000'),
		'name.vn'=> array('year_fee'=>'30.000','start_fee'=>'30.000'),
		'us,name,pw'=> array('year_fee'=>'323.000','start_fee'=>'0'),
		'co.uk,eu'=> array('year_fee'=>'265.000','start_fee'=>'0'),
		'biz'=> array('year_fee'=>'250.000','start_fee'=>'0'),
		'bz,ws,tv,me'=> array('year_fee'=>'666.000','start_fee'=>'0'),
		'agency,report,supply,supplies,exposed,photography,technology,photos,equipment,gallery,graphics,lighting,directory,today,tips,company,systems,management,center,support,email,solutions,education,institute,international,schule,gratis,website,city,reisen,desi,hiphop,network'=> array('year_fee'=>'484.000','start_fee'=>'30.000'),
		'bargains,cheap,zone,boutique,farm,cc,services,vision,fish,tools,parts,industries,pub,community,cleaning,catering,cards,marketing,photo,gift,guitars,webcam,trade,bid,events,productions,democrat,foundation,co,properties,social,rentals,vacations,immobilien,works,watch,cool,guru,land,bike,clothing,plumbing,singles,camera,estate,contractors,construction,kitchen,enterprises,tattoo,shoes,sexy,domains,academy,computer,training,builders,repair,camp,glass,coffee,florist,house,solar,exchange,gripe,moda,cash,discount,fitness,digital,church,life,guide,surf,beer,direct,place,deals,associates,media,kaufen,consulting,town,toys,nyc,fail,limited,wtf,care,cooking,country,fishing,horse,rodeo,vodka,republican,vet,soy'=> array('year_fee'=>'737.000','start_fee'=>'0'),
		'pink,blue,red,de'=> array('year_fee'=>'430.000','start_fee'=>'0'),
		'viajes,limo,codes,partners,holiday,condos,maison,tienda,flights,cruises,villas,expert,holdings,ventures,diamonds,voyage,recipes,careers,dating,capital,engineering,tax,fund,furniture,claims,finance,insure,bayern,lease,university,financial,healthcare,clinic,dental,surgery'=> array('year_fee'=>'1.161.000','start_fee'=>'0'),
		'mobi,ninja,in,com.co,net.co,nom.co,ca'=> array('year_fee'=>'452.000','start_fee'=>'0'),
		'ink,wiki,cn,com.cn'=> array('year_fee'=>'968.000','start_fee'=>'0'),
		'christmas,blackfriday,rest,buzz,kiwi,menu,actor,haus'=> array('year_fee'=>'903.000','start_fee'=>'0'),
		'pics,reviews,dance'=> array('year_fee'=>'548.000','start_fee'=>'0'),
		'futbol,xyz,pictures,rocks,audio,juegos'=> array('year_fee'=>'290.000','start_fee'=>'0'),
		'asia,tel,pro'=> array('year_fee'=>'366.000','start_fee'=>'0'),
		'tw,com.tw,net.tw,org.tw'=> array('year_fee'=>'1.118.000','start_fee'=>'0'),
		'xxx,jp'=> array('year_fee'=>'2.494.000','start_fee'=>'0'),
		'club,nagoya,tokyo,yokohama'=> array('year_fee'=>'387.000','start_fee'=>'0'),
		'build,bar,global,press'=> array('year_fee'=>'1.838.000','start_fee'=>'0'),
		'ceo,investments,credit,accountants,host,loans'=> array('year_fee'=>'2.387.000','start_fee'=>'0'),
		'creditcard'=> array('year_fee'=>'3.634.000','start_fee'=>'0'),
		'scot,london,vegas'=> array('year_fee'=>'1.441.000','start_fee'=>'0'),
		
	);
	if(is_string($tld) && valid_tld($tld)){
		if(isset($tlds_price[$tld])) return $tlds_price[$tld];
		foreach($tlds_price as $pattern_tld => $price){
			$tlds = explode(',',$pattern_tld);
			if(in_array($tld,$tlds)) return $price;
			if(preg_match("|^$pattern_tld$|",$tld)) return $price;
		}
		
	}
	return array('year_fee'=>'X','start_fee'=>'X');
}
function ajaxCheckDomain($domain,$name,$tld){
	?>
	<script>
	(function(){
		var current;  
		$(document).ready(function(){
			current = paAPI.domain_result_ui({
					domain:'<?php echo $domain?>',
					name : '<?php echo $name?>',
					tld : '<?php echo $tld?>'
				});
		});
	paAPI.checkDomain('<?php echo $domain?>',{name:'<?php echo $name?>',tld :'<?php echo $tld?>'},
		function(data){
		if(data && data.result){
			current.ui.removeClass('checking');
			current.init();
			switch(data.result)
			{
			case 'avaiable':
				//current.ui.addClass('avaiable');
				current.setBuyable(false);
				
				//display price
				current.displayPrice(data.prices);
			break;
			
			case 'unavaiable':
				//current.ui.addClass('unavaiable');
				current.setBuyable(true);
				
				//display price
				current.displayPrice(data.prices);
			break;
			default:
				current.setBuyable(false);
				current.displayPrice(null);
				current.ui.addClass('error');
			break;
			}
		}
	},function(e){console.log(e.message);});
	})();
	</script>
	<?php
}
/**
save whois info
*/
function cacheWhoisDomain($domain,$info = ''){
	if(!isset($_SESSION['pavn']['cache_whois_domains'])) {
		$_SESSION['pavn']['cache_whois_domains'] = array();
	}
	if($info) $_SESSION['pavn']['cache_whois_domains'][$domain] = $info;
	if(isset($_SESSION['pavn']['cache_whois_domains'][$domain])) 
		return $_SESSION['pavn']['cache_whois_domains'][$domain];
}
/*history domains*/
function HistoryDomains($data = array()){
	//prepare
	if(!isset($_SESSION['pavn']['histories'])) $_SESSION['pavn']['histories'] = array();
	if(is_array($data) && isset($data['domain']) ) {
		$_SESSION['pavn']['histories'][$data['domain']] = $data;
	}
	//save tlds
	if(!isset($_SESSION['pavn']['tlds_histories'])) $_SESSION['pavn']['tlds_histories'] = array();
	if(isset($data['tld'])) $_SESSION['pavn']['tlds_histories'][$data['tld']]=$data['tld'];
	
	if(is_string($data) && isset($_SESSION['pavn']['histories'][$data])){
		return $_SESSION['pavn']['histories'][$data];
	}
}
function mergeHistoryDomainTlds(&$new_dnames,&$new_tlds){
	//$result = array();
	if(isset($_SESSION['pavn']['histories'])){
		//filter domains name
		$names = array();
		foreach($_SESSION['pavn']['histories'] as $item){
			$names[$item['name']] = 1;
		}
		$names = array_keys($names);	//unique domains name
		$t1=array_diff(array_reverse($names),$new_dnames);
		$t2=array_merge($new_dnames,$t1);
		$new_dnames = array_flip(array_flip($t2));	//final domains name
		
	}
	if(isset($_SESSION['pavn']['tlds_histories'])){
		$tlds = array_keys($_SESSION['pavn']['tlds_histories']);
		$new_tlds = array_flip(array_flip(array_merge($tlds,$new_tlds)));	//final domains name
	}
}
/*clear histories domains*/
function clearHistory(){
	if(isset($_SESSION['pavn']['histories'])) {
		$_SESSION['pavn']['histories']=null;
		unset($_SESSION['pavn']['histories']);
	}
	if(isset($_SESSION['pavn']['tlds_histories'])) {
		$_SESSION['pavn']['tlds_histories']=null;
		unset($_SESSION['pavn']['tlds_histories']);
	}
}
/*validate domain*/
function valid_domain($myString){
	if (preg_match("#^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$#", $myString)) 
    {
       //valid url
	   return true;
    }
	return false;
}
/*validate domain extension short of tld*/
function valid_tld($tld){
	global $config;
	$popularTLD = explode(',',$config['popularTLD']);
	$vnTLD = explode(',',$config['vnTLD']);
	$nationalTLD = explode(',',$config['nationalTLD']);
	$newTLD = explode(',',$config['newTLD']);
	return (in_array($tld,$popularTLD) || in_array($tld,$vnTLD) || in_array($tld,$nationalTLD) || in_array($tld,$newTLD));
	
}
/*checked attribute*/
function hw_checked($item,$val){
	return ($item == $val)? ' checked="checked" ':'';
}
//parse all domains from text
function parse_all_domains($str){
	global $config;
	$allTLDs = array_merge(explode(',',$config['popularTLD']),
		explode(',',$config['vnTLD']),
		explode(',',$config['nationalTLD']),
		explode(',',$config['newTLD']));
	$allTLDs = trim(join('|',array_unique($allTLDs)));
	
	$result = array();
	$t=explode(/*PHP_EOL*/"\n" ,trim($str));
	foreach($t as $d){
		$result = array_merge($result,array_map(function($tld) use ($allTLDs){
			return preg_replace("#\.($allTLDs)#","",$tld);
		},preg_split('|[\s]+|',$d)));
	}
	return array_flip(array_flip($result));
}
if(!function_exists('_print')){
function _print($tt){
	echo '<textarea>';
	print_r($tt);
	echo '</textarea>';
}
}
/*check multi-domains*/
function check_domains($multi_domains,$listTlds2check){
	//start
	foreach((array)$multi_domains as $name){
		foreach((array)$listTlds2check as $tld){
			if($name && $tld){
				$domain = trim(rtrim($name,'.')).'.'.ltrim($tld,'.');	//this domain need being check
				ajaxCheckDomain($domain,$name,$tld);
			}
		}
	}
}
/**
whether tld is default?
*/
function is_tld_default($tld){
	global $config;
	if(in_array($tld,explode(',',$config['default']))) return true;
	return false;
}
?>