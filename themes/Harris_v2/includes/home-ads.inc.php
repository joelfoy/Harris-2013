<?php 
//Ferrous Ads
//setup array of ferrous ad images
$ferrousAdImages = array(
	array('file' => 'shredder',
		  'link' => '/products/shredders/?promo_id=ferrousadShredder_home',
		  'ferrAlt' => 'Harris Shredders'),
	array('file' => 'shears',
		  'link' => '/products/shears/?promo_id=ferrousadShear_home',
		  'ferrAlt' => 'Harris Shears'),
	array('file' => 'bls',
		  'link' => '/products/baler-logger-shears/?promo_id=ferrousadBLS_home',
		  'ferrAlt' => 'Harris Baler/Logger/Shears'),
	array('file' => 'orca',
		  'link' => '/products/balers-loggers-shears/harris-bl/?promo_id=ferrousadOrca_home',
		  'ferrAlt' => 'Harris BL - Baler/Logger'),
	array('file' => 'katana',
		  'link' => '/products/balers-loggers-shears/harrisbls/?promo_id=ferrousadKatana_home',
		  'ferrAlt' => 'Harris BLS - Baler/Logger/Shears'),
	array('file' => 'manta',
		  'link' => '/products/balers-loggers-shears/manta/?promo_id=ferrousadManta_home',
		  'ferrAlt' => 'Harris M54 - Baler/Logger'),
);
	//process images and links 
	$fai = rand(0, count($ferrousAdImages)-1);
	$selectedFerrousAd = "/wp-content/images/indexAds/{$ferrousAdImages[$fai]['file']}.png";
	$ferrAdLink = $ferrousAdImages[$fai]['link'];
	$ferrAltText = $ferrousAdImages[$fai]['ferrAlt'];
	
	if (file_exists($selectedFerrousAd) && is_readable($selectedFerrousAd)) {
	$ferrAdSize = getimagesize($selectedFerrousAd);
	}

//Nonferrous Ads
//setup array of nonferrous ad images
$nonferrousAdImages = array(
	//array('file' => 'hlo',
	//	  'link' => '/products/horizontal-balers/hlo',
	//	  'nonFerrAlt' => 'Harris HLO 5443 horizontal baler'),
	//array('file' => 'hso',
	//	  'link' => '/products/horizontal-balers/hso/?promo_id=nonferrousadHSO_home',
	//	  'nonFerrAlt' => 'The HSO 4529 horizontal baler'),
	array('file' => 'hrb240t',
		  'link' => '/products/two-ram-balers/hrb/hrb-240t?promo_id=hrb240t_home',
		  'nonFerrAlt' => 'Harris HRB 240T Two Ram Baler'),
	array('file' => 'hpseries',
		  'link' => '/products/horizontal-balers/hp-series/?promo_id=nonferrousadHP_home',
		  'nonFerrAlt' => 'Harris HP Series Horizontal Baler'),
);
//process images and links 
$nai = rand(0, count($nonferrousAdImages)-1);
$selectedNonFerrousAd = "/wp-content/images/indexAds/{$nonferrousAdImages[$nai]['file']}.png";
$nonFerrAdLink = $nonferrousAdImages[$nai]['link'];
$nonFerrAltText = $nonferrousAdImages[$nai]['nonFerrAlt'];

?>