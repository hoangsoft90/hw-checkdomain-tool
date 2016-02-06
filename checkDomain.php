<?php
session_start();	//start session
include('api_pavietnam/api_config.php');
include('config.php');
include('functions.php');
/*INFO*/
$cmd = isset($_GET['cmd'])? $_GET['cmd'] : 'check_whois';		#cmd 
$domain = isset($_GET['domain'])? $_GET['domain'] : '';	#domain name

if($cmd && valid_domain($domain)):
##check_whois
if($cmd == 'check_whois'){
	$result = file_get_contents(API_URL."?username=".USERNAME."&apikey=".API_KEY."&cmd=$cmd&domain=".$domain);//Gọi link thực thi thật
	$output['domain'] = $domain;
	//domain name
	if(isset($_POST['name']))
		$output['name'] = $_POST['name'];
	else{
		$t=explode('.',$domain);
		$output['name'] = reset($t);
		$output['tld'] = str_replace($output['name'].'.','',$domain);	//extract into tld
	}
	if(isset($_POST['tld'])) $output['tld'] = $_POST['tld'];
	
	if($result == '0'){	//Tên miền đã được đăng ký
		$output['result'] = 'avaiable';
	}
	elseif($result == '1')//Tên miền chưa đăng ký
	{
		$output['result'] = 'unavaiable';
	}
	else//Các trường hợp lỗi
	{
		$output['result'] = 'error';
		$output['reason'] = $result;
	}
	if($output['result'] !== 'error' && isset($output['tld'])){
		$output['prices']= get_tld_price($output['tld']);
	}
	HistoryDomains($output);	//history this domain
	echo json_encode($output);
}
##view whois
elseif($cmd == 'get_whois'){
	if(!cacheWhoisDomain($domain))
	$result = file_get_contents(API_URL."?username=".USERNAME."&apikey=".API_KEY."&cmd=get_whois&domain=".$domain);//Gọi link thực thi thật
	else $result = cacheWhoisDomain($domain);
	
	include('lib/SmartDOMDocument.class.php');
	$whois_server = 'http://www.whois.com';		//whois url which used to get domain info
	
	//$result = file_get_contents('http://www.whois.com/whois/'.$domain);
	/*$content_doc = new SmartDOMDocument();
	$content_doc->loadHTML($result);
	try {
		$parag1 = $content_doc->getElementById("registryBlk");
		$parag2 = $content_doc->getElementById("registrarBlk");
		for($i=0;$i<$parag1->getElementsByTagName()->count();$i++)
		{
			$img = $parag1->getElementsByTagName()->item($i);
			$src = $whois_server.$img->getAttribute('src');
			$img->setAttribute('src',$src);
		}
		
		$new = new SmartDOMDocument();
        $new->appendChild($new->importNode($parag1, true));
        $new->appendChild($new->importNode($parag2, true));
		
		$result = $new->saveHTMLExact();
		//_print($result);
		//cache whois
		cacheWhoisDomain($domain,$result);
		echo $result;
	} catch(Exception $e) { }*/
	cacheWhoisDomain($domain,$result);
		echo $result;
}

endif;

?>