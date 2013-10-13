//Front page Ad Fade in. 
$('.header, .frontIntro, .mainPage_previews, .frontPageAd').css({ opacity: 0 });
	$('.frontPageAd').delay(400).fadeTo(800, 1, function() {
      	$('.header, .frontIntro, .mainPage_previews').delay(800).fadeTo(1000, 1);
    });
    
