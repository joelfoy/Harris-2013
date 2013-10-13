<?php

// Enque jQuery
function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method');

//Register Sidebars
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'sidebar1',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'sidebar2',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'sidebar3',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));


//test to see if the page you are on is a sub_page
function is_subpage() {
	global $post;                                 	  // load details about this page
        if ( is_page() && $post->post_parent ) {      // test to see if the page has a parent
               $parentID = $post->post_parent;        // the ID of the parent is this
               return $parentID;                      // return the ID
        } else {                                      // there is no parent so...
               return false;                          // ...the answer to the question is false
        };
};

// Add support for thumbnails
add_theme_support('post-thumbnails');



function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');

//excerpt length 
//add_filter('excerpt_length', 'my_excerpt_length');
//function my_excerpt_length($length) {
//return 20; }

// SHORTCODES
////////////////////////////////////////////////////////////

// Style Shortcodes
// Paragraph Column Styles

// One Quarter Width Column
function cs_one_quarter( $atts, $content = null ) {
	return '<div class="one-quarter-width">'.$content.'</div>'; 
}
add_shortcode('one_quarter','cs_one_quarter');

// One Quarter Width Column - LAST
function cs_one_quarter_last( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="one-quarter-width last">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="one-quarter-width last">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('one_quarter_last','cs_one_quarter_last');

// One Third Width Column 
function cs_one_third( $atts, $content = null ) {
	return '<div class="one-third-width">'.$content.'</div>';
}
add_shortcode('one_third','cs_one_third');

// One Third Width Column - LAST
function cs_one_third_last( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="one-third-width last">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="one-third-width last">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('one_third_last','cs_one_third_last');

// One Half Width Column
function cs_one_half( $atts, $content = null ) {
	return '<div class="one-half-width">'.$content.'</div>';
}
add_shortcode('one_half','cs_one_half');

// One Half Width Column - LAST
function cs_one_half_last( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="one-half-width last">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="one-half-width last">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('one_half_last','cs_one_half_last');

// Two Thirds Width Column
function cs_two_thirds( $atts, $content = null ) {
	return '<div class="two-thirds-width">'.$content.'</div>';
}
add_shortcode('two_thirds','cs_two_thirds');

// Two Thirds Width Column - LAST
function cs_two_thirds_last( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="two-thirds-width last">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="two-thirds-width last">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('two_thirds_last','cs_two_thirds_last');

// Three Quarter Width Column
function cs_three_quarter( $atts, $content = null ) {
	return '<div class="three-quarter-width">'.$content.'</div>';
}
add_shortcode('three_quarter','cs_three_quarter');

// Three Quarter Width Column - LAST
function cs_three_quarter_last( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="three-quarter-width last">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="three-quarter-width last">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('three_quarter_last','cs_three_quarter_last');

// Full Width Column
function cs_full( $atts, $content = null) {
	extract( shortcode_atts( array(
			'space' => '',
		), $atts ) );
		if ($space == 'yes') {
	return '<div class="full">'.$content.'</div><div class="clearfix space"></div>';
	} else {
	return '<div class="full">'.$content.'</div><div class="clearfix"></div>';
	}
}
add_shortcode('full','cs_full');


//permalink shortcut from Digging into Wordpress
function permalink_thingy($atts) {
	extract(shortcode_atts(array(
	'id' => 1,
	'text' => "" // default value if none supplied
	), $atts));
	if ($text) {
		$url = get_permalink($id);
		return "<a href='$url'>$text</a>";
	} else {
		return get_permalink($id);
	}
}
add_shortcode('permalink', 'permalink_thingy');

//my url for the website
function my_url($atts, $content = null) {
  return get_bloginfo('url'); 
}
add_shortcode("url", "my_url");  

//template url 
function my_template_url($atts, $content = null) {
  return get_bloginfo('template_url'); 
}
add_shortcode("template_url", "my_template_url");  

//images url
function my_images_url($atts, $content = null) {
  return get_bloginfo('url') . '/wp-content/images/'; 
}
add_shortcode("images_url", "my_images_url");

//brochure url
function my_brochures_url($atts, $content = null) {
	return get_bloginfo('url') . '/wp-content/assets/brochures/';
}
add_shortcode("brochure_url", "my_brochure_url");

// content limit 
function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

   if (strlen($_GET['p']) > 0) {
      echo $content;
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo $content;
        echo "... <a href='";
        the_permalink();
        echo "'>".$more_link_text." &raquo;</a></p>";
   }
   else {
      echo $content;
   }
}

remove_action('wp_head', 'wp_generator');

//////////////////////////////////////////////////////
//BREADCRUMBS START
//////////////////////////////////////////////////////
function dimox_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<li class="page_item current_page_item">';
  $currentAfter = '</span></li>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    //echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    //echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive by category &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a> <span>&laquo;</span></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb;
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    //echo '</div>';
 
  }
}
//////////////////////////////////////////////////////
//BREADCRUMBS END
//////////////////////////////////////////////////////

//////////////////////////////////////////////////////
//Machine Information Request Form

function machineRequest() {
	//get URL requestComplete variable
	$complete = $_GET["requestComplete"];
	$machineSelected = $_GET['machineName'];
	
	//if there is no requestComplete variable
	if (!$complete) {
	echo '<div id="questionsForm">';
	echo '<h3>Machine Information Request Form</h3>';
	$templateURL = get_bloginfo("template_url");
	echo '<form class="form" method="post" action="'. $templateURL . '/includes/machineInfo-process.php">';
	//<!--http://www.harrisequip.com/processForms/hubspotForm1.php-->
	echo '<fieldset>';
	
	echo '<label id="name_error" class="error formError" for="name">This field is required.</label>
	<label id="name_label" for="name">Name<span class="required">*</span></label>
	<input id="name" class="formInput" name="name" size="18" type="text" />';
	
	echo '<label id="company_error" class="error formError" for="company">This field is required.</label>
	<label id="company_label" for="company">Company<span class="required">*</span></label>
	<input id="company" class="formInput" name="company" size="18" type="text" />';
	
	echo '<label id="email_error" class="error formError" for="email">This field is required.</label>
	<label id="email_label" for="email">Email<span class="required">*</span></label>
	<input id="email" class="formInput" name="email" size="18" type="text" />';
	
	echo '<label id="phone_error" class="error formError" for="phone">This field is required.</label>
	<label id="phone_label" for="phone">Phone<span class="required">*</span></label>
	<input id="phone" class="formInput" name="phone" size="18" type="text" />';
	
	echo '<label id="address_error" class="error formError" for="address">This field is required.</label>
	<label id="address_label" for="address">Address<span class="required">*</span></label>
	<input id="address" class="formInput" name="address" size="18" type="text" />';
	
	echo '<label id="city_error" class="error formError" for="city">This field is required.</label>
	<label id="city_label" for="city">City<span class="required">*</span></label>
	<input id="city" class="formInput" name="city" size="18" type="text" />';
	
	echo '<label id="state_error" class="error formError" for="state">This field is required.</label>
	<label id="state_label" for="state">State<span class="required">*</span></label>
	<input id="state" class="formInput" name="state" size="18" type="text" />';
	
	echo '<label id="zip_error" class="error formError" for="zip">This field is required.</label>
	<label id="zip_label" for="zip">Zip Code<span class="required">*</span></label>
	<input id="zip" class="formInput" name="zip" size="18" type="text" />';
	
	echo '<label id="country_label" for="country">Country</label>
	<select id="country" class="select" name="country"> <option selected="selected">Please Choose</option> <option>Abkhazia</option> <option>Afghanistan</option> <option>Aland</option> <option>Albania</option> <option>Algeria</option> <option>American Samoa</option> <option>Andorra</option> <option>Angola</option> <option>Anguilla</option> <option>Antigua &amp; Barbuda</option> <option>Argentina</option> <option>Armenia</option> <option>Aruba</option> <option>Australia</option> <option>Austria</option> <option>Azerbaijan</option> <option>The Bahamas</option> <option>Bahrain</option> <option>Bangladesh</option> <option>Barbados</option> <option>Belarus</option> <option>Belgium</option> <option>Belize</option> <option>Benin</option> <option>Bermuda</option> <option>Bhutan</option> <option>Bolivia</option> <option>Botswana</option> <option>Brazil</option> <option>Brunei</option> <option>Bulgaria</option> <option>Burkina Faso</option> <option>Burundi</option> <option>Cambodia</option> <option>Cameroon</option> <option>Canada</option> <option>Cape Verde</option> <option>Cayman Islands</option> <option>Chad</option> <option>Chile</option> <option>China</option> <option>Republic of China</option> <option>Christmas Island</option> <option>Colombia</option> <option>Comoros</option> <option>Congo</option> <option>Cook Islands</option> <option>Costa Rica</option> <option>Croatia</option> <option>Cuba</option> <option>Cyprus</option> <option>Czech Republic</option> <option>Denmark</option> <option>Djibouti</option> <option>Dominica</option> <option>Dominican Republic</option> <option>Ecuador</option> <option>Egypt</option> <option>El Salvador</option> <option>Equatorial Guinea</option> <option>Eritrea</option> <option>Estonia</option> <option>Ethiopia</option> <option>Falkland Islands</option> <option>Faroe Islands</option> <option>Fiji</option> <option>Finland</option> <option>France</option> <option>French Polynesia</option> <option>Gabon</option> <option>The Gambia</option> <option>Georgia</option> <option>Germany</option> <option>Ghana</option> <option>Gibraltar</option> <option>Greece</option> <option>Greenland</option> <option>Grenada</option> <option>Guam</option> <option>Guatemala</option> <option>Guernsey</option> <option>Guinea</option> <option>Guinea-Bissau</option> <option>Guyana Guyana</option> <option>Haiti Haiti</option> <option>Honduras</option> <option>Hong Kong</option> <option>Hungary</option> <option>Iceland</option> <option>India</option> <option>Indonesia</option> <option>Iran</option> <option>Iraq</option> <option>Ireland</option> <option>Israel</option> <option>Italy</option> <option>Jamaica</option> <option>Japan</option> <option>Jersey</option> <option>Jordan</option> <option>Kazakhstan</option> <option>Kenya</option> <option>Kiribati</option> <option>North Korea</option> <option>South Korea</option> <option>Kosovo</option> <option>Kuwait</option> <option>Kyrgyzstan</option> <option>Laos</option> <option>Latvia</option> <option>Lebanon</option> <option>Lesotho</option> <option>Liberia</option> <option>Libya</option> <option>Liechtenstein</option> <option>Lithuania</option> <option>Luxembourg</option> <option>Macau</option> <option>Macedonia</option> <option>Madagascar</option> <option>Malawi</option> <option>Malaysia</option> <option>Maldives</option> <option>Mali</option> <option>Malta</option> <option>Mauritania</option> <option>Mauritius</option> <option>Mayotte</option> <option>Mexico</option> <option>Micronesia</option> <option>Moldova</option> <option>Monaco</option> <option>Mongolia</option> <option>Montenegro</option> <option>Montserrat</option> <option>Morocco</option> <option>Mozambique</option> <option>Myanmar</option> <option>Nagorno-Karabakh</option> <option>Namibia</option> <option>Nauru</option> <option>Nepal</option> <option>Netherlands</option> <option>New Caledonia</option> <option>New Zealand</option> <option>Nicaragua</option> <option>Niger</option> <option>Nigeria</option> <option>Niue</option> <option>Norfolk Island</option> <option>Northern Mariana</option> <option>Norway</option> <option>Pakistan</option> <option>Palau</option> <option>Palestine</option> <option>Panama</option> <option>Papua New Guinea</option> <option>Paraguay</option> <option>Peru</option> <option>Philippines</option> <option>Poland</option> <option>Portugal</option> <option>Puerto Rico</option> <option>Qatar</option> <option>Romania</option> <option>Russia</option> <option>Rwanda</option> <option>Samoa</option> <option>San Marino</option> <option>Saudi Arabia</option> <option>Senegal</option> <option>Serbia</option> <option>Seychelles</option> <option>Sierra Leone</option> <option>Singapore</option> <option>Slovakia</option> <option>Slovenia</option> <option>Solomon Islands</option> <option>Somalia</option> <option>Somaliland</option> <option>South Africa</option> <option>South Ossetia</option> <option>Spain</option> <option>Sri Lanka</option> <option>Sudan</option> <option>Suriname</option> <option>Svalbard</option> <option>Swaziland</option> <option>Sweden</option> <option>Switzerland</option> <option>Syria</option> <option>Tajikistan</option> <option>Tanzania</option> <option>Thailand</option> <option>Timor-Leste</option> <option>Togo</option> <option>Tokelau</option> <option>Tonga</option> <option>Trinidad and Tobago</option> <option>Tristan da Cunha</option> <option>Tunisia</option> <option>Turkey</option> <option>Turkmenistan</option> <option>Tuvalu</option> <option>Uganda</option> <option>Ukraine</option> <option>United Arab Emirates</option> <option>United Kingdom</option> <option>United States</option> <option>Uruguay</option> <option>Uzbekistan</option> <option>Vanuatu</option> <option>Vatican City</option> <option>Venezuela</option> <option>Vietnam</option> <option>Virgin Islands</option> <option>Western Sahara</option> <option>Yemen</option> <option>Zambia</option> <option>Zimbabwe</option> </select>';
	

	echo '<label id="machine_label" for="machine">Machine</label>
		<select id="machine" class="select" name="machine"> 
		<option value="Pick your machine...">Pick your machine</option> 
		<option value="Vertical Balers">Vertical Balers</option> 
		<option value="HP Series">HP Series</option> 
		<option value="Horizontal Close Door">Horizontal Closed Door</option> 
		<option value="Horizontal Open End">Horizontal Open-end</option> 
		<option value="Wolverine">Wolverine</option> 
		<option value="Badger">Badger</option> 
		<option value="Gorilla">Gorilla</option> 
		<option value="Grizzly">Grizzly</option> 
		<option value="Centurion">HRB Centurion</option> 
		<option value="HRB">HRB</option> 
		<option value="TransPak">TransPak</option> 
		<option value="Harris Shredders">Harris Shredders</option> 
		<option value="TGS">TGS</option> 
		<option value="TG">TG</option> 
		<option value="SS Shear">Side Squeeze Shear</option> 
		<option value="ABS">ABS Shear</option> 
		<option value="BSH">BSH Shear</option> 
		<option value="H7E">H7E Series</option> 
		<option value="H562">H562 Series</option> 
		<option value="HBL66-16">HBL66-16</option> 
		<option value="PBL">PBL</option> 
		<option value="GS">GS Series</option> 
		<option value="BLS-622">BLS-622</option> 
	</select>';
	
	
	echo '<label id="source_label" for="source">How did you find us?</label>';
	
	echo '<select id="source" class="select" name="source"> <option selected="selected" value="none">Please Choose</option> <option value="Current Customer">I am a customer</option> <option value="Referral">Customer Referral</option> <option value="Google">Google</option> <option value="Yahoo">Yahoo!</option> <option value="Other Engine">Other Search Engine</option> <option value="Waste News">Waste News </option> <option value="Rec. Today">Recycling Today </option> <option value="Scrap">Scrapsite</option> <option value="AMM">AMM </option> <option value="American Recycler">American Recycler</option> <option value="Rec. Prod. News">Recycling Product News</option> <option value="Wastec/Waste Age">Wastec/Waste Age</option> <option value="Thomasnet.com">Thomasnet.com</option> </select>';
	echo '<label id="formcomments_label" for="comments">Comments</label><textarea id="formcomments" class="formInput" cols="17" rows="4" name="comments"></textarea>';
	
	echo '<input id="submit_btn" class="button" name="submit" type="submit" value="Send" /></fieldset>';
	echo '</form>';
	
	
	echo '</div>'; //end of form 
	
	}
	if ($complete == no) {
	echo '<div id="questionsForm">';
	echo '<h3>Machine Information Request Form</h3>';
	echo '<h4 class="contactError">Please fill out all required<span class="required">*</span> fields</h4>';
	$templateURL = get_bloginfo("template_url");
	echo '<form class="form" method="post" action="'. $templateURL . '/includes/machineInfo-process.php">';
	//<!--http://www.harrisequip.com/processForms/hubspotForm1.php-->
	echo '<fieldset>';
	
	echo '<label id="name_error" class="error formError" for="name">This field is required.</label>
	<label id="name_label" for="name">Name<span class="required">*</span></label>
	<input id="name" class="formInput" name="name" size="18" type="text" />';
	
	echo '<label id="company_error" class="error formError" for="company">This field is required.</label>
	<label id="company_label" for="company">Company<span class="required">*</span></label>
	<input id="company" class="formInput" name="company" size="18" type="text" />';
	
	echo '<label id="email_error" class="error formError" for="email">This field is required.</label>
	<label id="email_label" for="email">Email<span class="required">*</span></label>
	<input id="email" class="formInput" name="email" size="18" type="text" />';
	
	echo '<label id="phone_error" class="error formError" for="phone">This field is required.</label>
	<label id="phone_label" for="phone">Phone<span class="required">*</span></label>
	<input id="phone" class="formInput" name="phone" size="18" type="text" />';
	
	echo '<label id="address_error" class="error formError" for="address">This field is required.</label>
	<label id="address_label" for="address">Address<span class="required">*</span></label>
	<input id="address" class="formInput" name="address" size="18" type="text" />';
	
	echo '<label id="city_error" class="error formError" for="city">This field is required.</label>
	<label id="city_label" for="city">City<span class="required">*</span></label>
	<input id="city" class="formInput" name="city" size="18" type="text" />';
	
	echo '<label id="state_error" class="error formError" for="state">This field is required.</label>
	<label id="state_label" for="state">State<span class="required">*</span></label>
	<input id="state" class="formInput" name="state" size="18" type="text" />';
	
	echo '<label id="zip_error" class="error formError" for="zip">This field is required.</label>
	<label id="zip_label" for="zip">Zip Code<span class="required">*</span></label>
	<input id="zip" class="formInput" name="zip" size="18" type="text" />';
	
	echo '<label id="country_label" for="country">Country</label>
	<select id="country" class="select" name="country"> <option selected="selected">Please Choose</option> <option>Abkhazia</option> <option>Afghanistan</option> <option>Aland</option> <option>Albania</option> <option>Algeria</option> <option>American Samoa</option> <option>Andorra</option> <option>Angola</option> <option>Anguilla</option> <option>Antigua &amp; Barbuda</option> <option>Argentina</option> <option>Armenia</option> <option>Aruba</option> <option>Australia</option> <option>Austria</option> <option>Azerbaijan</option> <option>The Bahamas</option> <option>Bahrain</option> <option>Bangladesh</option> <option>Barbados</option> <option>Belarus</option> <option>Belgium</option> <option>Belize</option> <option>Benin</option> <option>Bermuda</option> <option>Bhutan</option> <option>Bolivia</option> <option>Botswana</option> <option>Brazil</option> <option>Brunei</option> <option>Bulgaria</option> <option>Burkina Faso</option> <option>Burundi</option> <option>Cambodia</option> <option>Cameroon</option> <option>Canada</option> <option>Cape Verde</option> <option>Cayman Islands</option> <option>Chad</option> <option>Chile</option> <option>China</option> <option>Republic of China</option> <option>Christmas Island</option> <option>Colombia</option> <option>Comoros</option> <option>Congo</option> <option>Cook Islands</option> <option>Costa Rica</option> <option>Croatia</option> <option>Cuba</option> <option>Cyprus</option> <option>Czech Republic</option> <option>Denmark</option> <option>Djibouti</option> <option>Dominica</option> <option>Dominican Republic</option> <option>Ecuador</option> <option>Egypt</option> <option>El Salvador</option> <option>Equatorial Guinea</option> <option>Eritrea</option> <option>Estonia</option> <option>Ethiopia</option> <option>Falkland Islands</option> <option>Faroe Islands</option> <option>Fiji</option> <option>Finland</option> <option>France</option> <option>French Polynesia</option> <option>Gabon</option> <option>The Gambia</option> <option>Georgia</option> <option>Germany</option> <option>Ghana</option> <option>Gibraltar</option> <option>Greece</option> <option>Greenland</option> <option>Grenada</option> <option>Guam</option> <option>Guatemala</option> <option>Guernsey</option> <option>Guinea</option> <option>Guinea-Bissau</option> <option>Guyana Guyana</option> <option>Haiti Haiti</option> <option>Honduras</option> <option>Hong Kong</option> <option>Hungary</option> <option>Iceland</option> <option>India</option> <option>Indonesia</option> <option>Iran</option> <option>Iraq</option> <option>Ireland</option> <option>Israel</option> <option>Italy</option> <option>Jamaica</option> <option>Japan</option> <option>Jersey</option> <option>Jordan</option> <option>Kazakhstan</option> <option>Kenya</option> <option>Kiribati</option> <option>North Korea</option> <option>South Korea</option> <option>Kosovo</option> <option>Kuwait</option> <option>Kyrgyzstan</option> <option>Laos</option> <option>Latvia</option> <option>Lebanon</option> <option>Lesotho</option> <option>Liberia</option> <option>Libya</option> <option>Liechtenstein</option> <option>Lithuania</option> <option>Luxembourg</option> <option>Macau</option> <option>Macedonia</option> <option>Madagascar</option> <option>Malawi</option> <option>Malaysia</option> <option>Maldives</option> <option>Mali</option> <option>Malta</option> <option>Mauritania</option> <option>Mauritius</option> <option>Mayotte</option> <option>Mexico</option> <option>Micronesia</option> <option>Moldova</option> <option>Monaco</option> <option>Mongolia</option> <option>Montenegro</option> <option>Montserrat</option> <option>Morocco</option> <option>Mozambique</option> <option>Myanmar</option> <option>Nagorno-Karabakh</option> <option>Namibia</option> <option>Nauru</option> <option>Nepal</option> <option>Netherlands</option> <option>New Caledonia</option> <option>New Zealand</option> <option>Nicaragua</option> <option>Niger</option> <option>Nigeria</option> <option>Niue</option> <option>Norfolk Island</option> <option>Northern Mariana</option> <option>Norway</option> <option>Pakistan</option> <option>Palau</option> <option>Palestine</option> <option>Panama</option> <option>Papua New Guinea</option> <option>Paraguay</option> <option>Peru</option> <option>Philippines</option> <option>Poland</option> <option>Portugal</option> <option>Puerto Rico</option> <option>Qatar</option> <option>Romania</option> <option>Russia</option> <option>Rwanda</option> <option>Samoa</option> <option>San Marino</option> <option>Saudi Arabia</option> <option>Senegal</option> <option>Serbia</option> <option>Seychelles</option> <option>Sierra Leone</option> <option>Singapore</option> <option>Slovakia</option> <option>Slovenia</option> <option>Solomon Islands</option> <option>Somalia</option> <option>Somaliland</option> <option>South Africa</option> <option>South Ossetia</option> <option>Spain</option> <option>Sri Lanka</option> <option>Sudan</option> <option>Suriname</option> <option>Svalbard</option> <option>Swaziland</option> <option>Sweden</option> <option>Switzerland</option> <option>Syria</option> <option>Tajikistan</option> <option>Tanzania</option> <option>Thailand</option> <option>Timor-Leste</option> <option>Togo</option> <option>Tokelau</option> <option>Tonga</option> <option>Trinidad and Tobago</option> <option>Tristan da Cunha</option> <option>Tunisia</option> <option>Turkey</option> <option>Turkmenistan</option> <option>Tuvalu</option> <option>Uganda</option> <option>Ukraine</option> <option>United Arab Emirates</option> <option>United Kingdom</option> <option>United States</option> <option>Uruguay</option> <option>Uzbekistan</option> <option>Vanuatu</option> <option>Vatican City</option> <option>Venezuela</option> <option>Vietnam</option> <option>Virgin Islands</option> <option>Western Sahara</option> <option>Yemen</option> <option>Zambia</option> <option>Zimbabwe</option> </select><label id="machine_label" for="machine">Machine</label>';
	
	
	echo '<select id="machine" class="select" name="machine"> <option selected="selected" value="Pick your machine...">Pick your machine</option> <option value="Vertical Balers">Vertical Balers</option> <option value="HP Series">HP Series</option> <option value="Horizontal Close Door">Horizontal Closed Door</option> <option value="Horizontal Open End">Horizontal Open-end</option> <option value="Wolverine">Wolverine</option> <option value="Badger">Badger</option> <option value="Gorilla">Gorilla</option> <option value="Grizzly">Grizzly</option> <option value="Centurion">HRB Centurion</option> <option value="HRB">HRB</option> <option value="TransPak">TransPak</option> <option value="Harris Shredders">Harris Shredders</option> <option value="TGS">TGS</option> <option value="TG">TG</option> <option value="SS Shear">Side Squeeze Shear</option> <option value="ABS">ABS Shear</option> <option value="BSH">BSH Shear</option> <option value="H7E">H7E Series</option> <option value="H562">H562 Series</option> <option value="HBL66-16">HBL66-16</option> <option value="PBL">PBL</option> <option value="GS">GS Series</option> <option value="BLS-622">BLS-622</option> </select><label id="source_label" for="source">How did you find us?</label>';
	
	echo '<select id="source" class="select" name="source"> <option selected="selected" value="none">Please Choose</option> <option value="Current Customer">I am a customer</option> <option value="Referral">Customer Referral</option> <option value="Google">Google</option> <option value="Yahoo">Yahoo!</option> <option value="Other Engine">Other Search Engine</option> <option value="Waste News">Waste News </option> <option value="Rec. Today">Recycling Today </option> <option value="Scrap">Scrapsite</option> <option value="AMM">AMM </option> <option value="American Recycler">American Recycler</option> <option value="Rec. Prod. News">Recycling Product News</option> <option value="Wastec/Waste Age">Wastec/Waste Age</option> <option value="Thomasnet.com">Thomasnet.com</option> </select>';
	echo '<label id="formcomments_label" for="comments">Comments</label><textarea id="formcomments" class="formInput" cols="17" rows="4" name="comments"></textarea>';
	
	echo '<input id="submit_btn" class="button" name="submit" type="submit" value="Send" /></fieldset>';
	
	
	
	echo '</form>';
	echo '</div>'; //end of form 
	}
	
	if ($complete == yes) {
	echo '<div id="questionsForm">';
	echo '<h3>Information Received</h3>';
	echo '<p>Thank you for showing interest in Harris products. We have received your information request and someone from Harris will be in touch with you soon. If you want, at any point, to contact Harris directly you can reach us at 800.373.9131 or 770.631.7290</p>';
	echo '<h4 class="thankYou">Thank You</h4>';
	echo '</div>'; //end of form 
	}

} 
add_shortcode("machineRequest", "machineRequest");

//END Machine Info Request Form
//////////////////////////////////////////////////


//Extra Meta Boxes

	//Main Image Boxes
	/*add_action("admin_init", "mainImage_box");
	add_action("save_post", "save_image");
	
	function mainImage_box() {
		add_meta_box("mainImage_meta", "Main Image", "image_options", "page", "advanced", "low");
	}
	
	function image_options() {
		global $post;
		$custom = get_post_custom($post->ID);
		$image = $custom["main_image"][0];
	?>
		<label>Main Product Image: </label><input name="main_image" value="<?php echo $image; ?>" />
	<?php 
	}
	
	function save_image() {
		global $post;
		update_post_meta($post->ID, "main_image", $_POST["main_image"]);
	}
	*/

/*******************************************
function language_redirect() {
	// Detect Language
	$language = ($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	
	// Redirect
	if (ereg("es", $language)) {
		header("location: http://es.harrisequip.com");
	} 
}
language_redirect();
********************************************/

?>