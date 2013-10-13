<?php
/*
	Template Name: Service Request
*/
?>
<?php get_header(); ?>
<!-- product page -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">
			<h1 class="pageTitle"><?php the_title(); ?></h1>
			<?php
					  if($post->post_parent)
					  $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&exclude=151");
					  else
					  $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&exclude=151");
					  if ($children) { ?>
					  <ul class="childPages">
					  	<?php echo $children; ?>
					  </ul>
					  
				<?php } ?>
				
			
			<div class="pageContent clearfix">
				
				<div class="content">	
					<?php //get any variables passed from other pages
					$complete = $_GET["requestComplete"];
					$machineSelected = $_GET['machineName'];
					if (isset($machineSelected)) {
					$machineNames = array(
						'VerticalBalers' => 'Vertical Balers',
						'HSO' => 'the HSO Baler',
						'HLO' => 'the HLO Baler',
						'HCB' => 'the HCB Baler',
						'HPSeries' => 'the HP Series',
						'HL' => 'the HL Baler',
						'HAL' => 'the HAL Baler',
						'Piranha' => 'the Piranha',
						'Barracuda' => 'the Barracuda',
						'Badger' => 'the Badger',
						'Gorilla' => 'the Gorilla',
						'HRB' => 'the HRB',
						'HRBCenturion' => 'the HRB Centurion',
						'Wolverine' => 'the Wolverine',
						'TGFerrousBaler' => 'the TG Ferrous Baler',
						'TGSFerrousBaler' => 'the TGS Ferrous Baler',
						'TransPakPrecompactionSystem' => 'the TransPak',
						'ABSShear' => 'the ABS Shear',
						'BSHShear' => 'the BSH Shear',
						'Side-CompressionShear' => 'the SC Shear',
						'PBL' => 'the PBL',
						'GSBaler/Logger/Shear' => 'the GS Shear',
						'H562' => 'the H562',
						'Shredders' => 'Harris Shredders',
						'TwoRamBalers' => 'Two Ram Balers',
						'HorizontalBalers' => 'Horizontal Balers',
						'ThreeCompressionBalers' => 'Ferrous Balers',
						'Shears' => 'Harris Shears',
						'Baler/Logger' => 'Baler/Loggers',
						'Baler/Logger/Shears' => 'Baler/Logger/Shears',
						'EcotecnicaLine' => 'the Ecotecnica Line',
						'Katana' => 'the Ecotecnica Katana',
						'Manta54' => 'the Ecotecnica Manta',
						'Orca' => 'the Ecotecnica Orca', 
						'Katana266SpecialAvailability' => 'the Katana 266'
					);
					
					}
					?>
					<div id="serviceForm">
					<?php //
					if (!$complete) { ?>
						<h3>Service Request Form</h3>
						<?php if ($machineSelected) { ?><h4 id="machineAnnouncement">You were looking at <?php echo $machineNames["$machineSelected"]; ?> <a class="remove" href="http://www.harrisequip.com/sales/machine-information">Remove Option</a></h4> <?php } ?> 
						
					<?php $templateURL = get_bloginfo("template_url"); ?>
					<form class="form" method="post" action="<?php echo $templateURL ?>/includes/serviceRequest-process.php">
					<fieldset>
						<label id="name_error" class="error formError" for="name">This field is required.</label>
						<label id="name_label" for="name">Name<span class="required">*</span></label>
						<input id="name" class="formInput" name="name" size="18" type="text" />
						
						<label id="company_error" class="error formError" for="company">This field is required.</label>
						<label id="company_label" for="company">Company<span class="required">*</span></label>
						<input id="company" class="formInput" name="company" size="18" type="text" />
						
						<label id="email_error" class="error formError" for="email">This field is required.</label>
						<label id="email_label" for="email">Email<span class="required">*</span></label>
						<input id="email" class="formInput" name="email" size="18" type="email" />
						
						<label id="phone_error" class="error formError" for="phone">This field is required.</label>
						<label id="phone_label" for="phone">Phone<span class="required">*</span></label>
						<input id="phone" class="formInput" name="phone" size="18" type="text" />
						
						<label id="address_error" class="error formError" for="address">This field is required.</label>
						<label id="address_label" for="address">Address<span class="required">*</span></label>
						<input id="address" class="formInput" name="address" size="18" type="text" />
						
						<label id="city_error" class="error formError" for="city">This field is required.</label>
						<label id="city_label" for="city">City<span class="required">*</span></label>
						<input id="city" class="formInput" name="city" size="18" type="text" />
						
						<label id="state_error" class="error formError" for="state">This field is required.</label>
						<label id="state_label" for="state">State/Province<span class="required">*</span> (letters only)</label>
						<input id="state" class="formInput" name="state" size="18" type="text" />
						
						<label id="zip_error" class="error formError" for="zip">This field is required.</label>
						<label id="zip_label" for="zip">Zip/Postal Code<span class="required">*</span></label>
						<input id="zip" class="formInput" name="zip" size="18" type="text" />
						
						<label id="country_error" class="error formError" for="country">Please select your country.</label>
						<label id="country_label" for="country">Country<span class="required">*</span></label>
						<select id="country" class="select" name="country"> <option selected="selected">Please Choose</option> <option>United States</option>
<option>Abkhazia</option> <option>Afghanistan</option> <option>Aland</option> <option>Albania</option> <option>Algeria</option> <option>American Samoa</option> <option>Andorra</option> <option>Angola</option> <option>Anguilla</option> <option>Antigua &amp; Barbuda</option> <option>Argentina</option> <option>Armenia</option> <option>Aruba</option> <option>Australia</option> <option>Austria</option> <option>Azerbaijan</option> <option>The Bahamas</option> <option>Bahrain</option> <option>Bangladesh</option> <option>Barbados</option> <option>Belarus</option> <option>Belgium</option> <option>Belize</option> <option>Benin</option> <option>Bermuda</option> <option>Bhutan</option> <option>Bolivia</option> <option>Botswana</option> <option>Brazil</option> <option>Brunei</option> <option>Bulgaria</option> <option>Burkina Faso</option> <option>Burundi</option> <option>Cambodia</option> <option>Cameroon</option> <option>Canada</option> <option>Cape Verde</option> <option>Cayman Islands</option> <option>Chad</option> <option>Chile</option> <option>China</option> <option>Republic of China</option> <option>Christmas Island</option> <option>Colombia</option> <option>Comoros</option> <option>Congo</option> <option>Cook Islands</option> <option>Costa Rica</option> <option>Croatia</option> <option>Cuba</option> <option>Cyprus</option> <option>Czech Republic</option> <option>Denmark</option> <option>Djibouti</option> <option>Dominica</option> <option>Dominican Republic</option> <option>Ecuador</option> <option>Egypt</option> <option>El Salvador</option> <option>Equatorial Guinea</option> <option>Eritrea</option> <option>Estonia</option> <option>Ethiopia</option> <option>Falkland Islands</option> <option>Faroe Islands</option> <option>Fiji</option> <option>Finland</option> <option>France</option> <option>French Polynesia</option> <option>Gabon</option> <option>The Gambia</option> <option>Georgia</option> <option>Germany</option> <option>Ghana</option> <option>Gibraltar</option> <option>Greece</option> <option>Greenland</option> <option>Grenada</option> <option>Guam</option> <option>Guatemala</option> <option>Guernsey</option> <option>Guinea</option> <option>Guinea-Bissau</option> <option>Guyana Guyana</option> <option>Haiti Haiti</option> <option>Honduras</option> <option>Hong Kong</option> <option>Hungary</option> <option>Iceland</option> <option>India</option> <option>Indonesia</option> <option>Iran</option> <option>Iraq</option> <option>Ireland</option> <option>Israel</option> <option>Italy</option> <option>Jamaica</option> <option>Japan</option> <option>Jersey</option> <option>Jordan</option> <option>Kazakhstan</option> <option>Kenya</option> <option>Kiribati</option> <option>North Korea</option> <option>South Korea</option> <option>Kosovo</option> <option>Kuwait</option> <option>Kyrgyzstan</option> <option>Laos</option> <option>Latvia</option> <option>Lebanon</option> <option>Lesotho</option> <option>Liberia</option> <option>Libya</option> <option>Liechtenstein</option> <option>Lithuania</option> <option>Luxembourg</option> <option>Macau</option> <option>Macedonia</option> <option>Madagascar</option> <option>Malawi</option> <option>Malaysia</option> <option>Maldives</option> <option>Mali</option> <option>Malta</option> <option>Mauritania</option> <option>Mauritius</option> <option>Mayotte</option> <option>Mexico</option> <option>Micronesia</option> <option>Moldova</option> <option>Monaco</option> <option>Mongolia</option> <option>Montenegro</option> <option>Montserrat</option> <option>Morocco</option> <option>Mozambique</option> <option>Myanmar</option> <option>Nagorno-Karabakh</option> <option>Namibia</option> <option>Nauru</option> <option>Nepal</option> <option>Netherlands</option> <option>New Caledonia</option> <option>New Zealand</option> <option>Nicaragua</option> <option>Niger</option> <option>Nigeria</option> <option>Niue</option> <option>Norfolk Island</option> <option>Northern Mariana</option> <option>Norway</option> <option>Pakistan</option> <option>Palau</option> <option>Palestine</option> <option>Panama</option> <option>Papua New Guinea</option> <option>Paraguay</option> <option>Peru</option> <option>Philippines</option> <option>Poland</option> <option>Portugal</option> <option>Puerto Rico</option> <option>Qatar</option> <option>Romania</option> <option>Russia</option> <option>Rwanda</option> <option>Samoa</option> <option>San Marino</option> <option>Saudi Arabia</option> <option>Senegal</option> <option>Serbia</option> <option>Seychelles</option> <option>Sierra Leone</option> <option>Singapore</option> <option>Slovakia</option> <option>Slovenia</option> <option>Solomon Islands</option> <option>Somalia</option> <option>Somaliland</option> <option>South Africa</option> <option>South Ossetia</option> <option>Spain</option> <option>Sri Lanka</option> <option>Sudan</option> <option>Suriname</option> <option>Svalbard</option> <option>Swaziland</option> <option>Sweden</option> <option>Switzerland</option> <option>Syria</option> <option>Tajikistan</option> <option>Tanzania</option> <option>Thailand</option> <option>Timor-Leste</option> <option>Togo</option> <option>Tokelau</option> <option>Tonga</option> <option>Trinidad and Tobago</option> <option>Tristan da Cunha</option> <option>Tunisia</option> <option>Turkey</option> <option>Turkmenistan</option> <option>Tuvalu</option> <option>Uganda</option> <option>Ukraine</option> <option>United Arab Emirates</option> <option>United Kingdom</option>  <option>Uruguay</option> <option>Uzbekistan</option> <option>Vanuatu</option> <option>Vatican City</option> <option>Venezuela</option> <option>Vietnam</option> <option>Virgin Islands</option> <option>Western Sahara</option> <option>Yemen</option> <option>Zambia</option> <option>Zimbabwe</option> </select>
						
						<label id="machine_error" class="error formError" for="machine">This field is required.</label>
						<label id="machine_label" for="machine">Machine<span class="required">*</span></label>
							<select id="machine" class="select" name="machine"> 
							<option id="choose" value="Pick your machine">Pick your machine</option> 
							<option <?php if ( $machineSelected == VerticalBalers ) { echo 'selected="selected" '; } ?> value="Vertical Balers">Vertical Balers</option> 
							<option <?php if ( $machineSelected == HSO ) { echo 'selected="selected" '; } ?> value="HSO">HSO Baler</option> 
							<option <?php if ( $machineSelected == HLO ) { echo 'selected="selected" '; } ?> value="HLO">HLO Baler</option> 
							<option <?php if ( $machineSelected == HCB ) { echo 'selected="selected" '; } ?> value="HLO">HCB Baler</option>
							<option <?php if ( $machineSelected == HPSeries ) { echo 'selected="selected" '; } ?> value="HP Series">HP Series</option> 
							<option <?php if ( $machineSelected == HL ) { echo 'selected="selected" '; } ?> value="HL">HL Baler</option> 
							<option <?php if ( $machineSelected == HAL ) { echo 'selected="selected" '; } ?>value="HAL">HAL Baler</option> 
							<option <?php if ( $machineSelected == Piranha ) { echo 'selected="selected" '; } ?> value="Piranha">Piranha</option> 
							<option <?php if ( $machineSelected == Barracuda ) { echo 'selected="selected" '; } ?> value="Barracuda">Barracuda</option> 
							<option <?php if ( $machineSelected == Badger ) { echo 'selected="selected" '; } ?> value="Badger">Badger</option> 
							<option <?php if ( $machineSelected == Gorilla ) { echo 'selected="selected" '; } ?>value="Gorilla">Gorilla</option> 
							<option <?php if ( $machineSelected == HRB ) { echo 'selected="selected" '; } ?> value="HRB">HRB</option> 
							<option <?php if ( $machineSelected == HRBCenturion ) { echo 'selected="selected" '; } ?> value="Centurion">HRB Centurion</option> 
							<option <?php if ( $machineSelected == Wolverine ) { echo 'selected="selected" '; } ?> value="Wolverine">Wolverine</option> 
							<option <?php if ( $machineSelected == TGFerrousBaler ) { echo 'selected="selected" '; } ?> value="TG">TG Ferrous Baler</option> 
							<option <?php if ( $machineSelected == TGSFerrousBaler ) { echo 'selected="selected" '; } ?> value="TGS">TGS Ferrous Baler</option> 
							<option <?php if ( $machineSelected == TransPakPrecompactionSystem ) { echo 'selected="selected" '; } ?> value="TransPak">TransPak</option> 
							<option <?php if ( $machineSelected == "Shears" ) { echo 'selected="selected" '; } ?> value="Shears">Shears</option> 

							<option <?php if ( $machineSelected == ABSShear ) { echo 'selected="selected" '; } ?> value="ABS Shear">ABS Shear</option> 
							<option <?php if ( $machineSelected == BSHShear ) { echo 'selected="selected" '; } ?> value="BSH Shear">BSH Shear</option> 
							<option <?php if ( $machineSelected == "Baler/Logger" ) { echo 'selected="selected" '; } ?>value="Baler/Loggers"><strong>Baler/Loggers</strong></option>
							<option <?php if ( $machineSelected == "Side-CompressionShear" ) { echo 'selected="selected" '; } ?>value="SC Shear">Side-Compression Shear</option> 
							<option <?php if ( $machineSelected == "Baler/Logger/Shears" ) { echo 'selected="selected" '; } ?> value="Baler/Logger/Shears">Baler/Logger/Shears</option> 

							<option <?php if ( $machineSelected == "GSBaler/Logger/Shear" ) { echo 'selected="selected" '; } ?> value="GS">GS Series</option> 
							<option <?php if ( $machineSelected == Shredders ) { echo 'selected="selected" '; } ?> value="Shredders">Shredders</option>
							<option <?php if ( $machineSelected == Katana || $machineSelected == "Katana266SpecialAvailability" ) { echo 'selected="selected" '; } ?> value="Katana">Katana</option>
							<option <?php if ( $machineSelected == Manta54 ) { echo 'selected="selected" '; } ?> value="Manta">Manta</option>
							<option <?php if ( $machineSelected == Orca ) { echo 'selected="selected" '; } ?> value="Orca">Orca</option>
						</select>
						
						<label id="serial_error" class="error formError" for="source">This field is required.</label>
						<label id="serial_label" for="source">Serial Number<span class="required">*</span></label>
						<input id="serial" class="formInput" name="serial" size="18" type="text" />
						
						<label id="issue_error" class="error formError" for="formcomments">Briefly describe what you are looking for.</label>
						<label id="issue_label" for="comments">Machine Issue<span class="required">*</span></label>
						<textarea id="issue" class="formInput" cols="17" rows="4" name="issue"></textarea>
						
						<input id="submit_btn" class="button" name="submit" type="submit" value="Send" /></fieldset>
						</form>
					
					<?php } ?>
					
					<?php //
						if ($complete == no) { ?>
						<h3>Service Request Form</h3>
						<?php if ($machineSelected) { ?><h4 id="machineAnnouncement">You were looking at <?php echo $machineNames["$machineSelected"]; ?> <a class="remove" href="http://www.harrisequip.com/sales/machine-information">Remove Option</a></h4> <?php } ?> 
						
					<?php $templateURL = get_bloginfo("template_url"); ?>
					<form class="form" method="post" action="<?php echo $templateURL ?>/includes/serviceRequest-process.php">
					<fieldset>
						<label id="name_error" class="error formError" for="name">This field is required.</label>
						<label id="name_label" for="name">Name<span class="required">*</span></label>
						<input id="name" class="formInput" name="name" size="18" type="text" />
						
						<label id="company_error" class="error formError" for="company">This field is required.</label>
						<label id="company_label" for="company">Company<span class="required">*</span></label>
						<input id="company" class="formInput" name="company" size="18" type="text" />
						
						<label id="email_error" class="error formError" for="email">This field is required.</label>
						<label id="email_label" for="email">Email<span class="required">*</span></label>
						<input id="email" class="formInput" name="email" size="18" type="email" />
						
						<label id="phone_error" class="error formError" for="phone">This field is required.</label>
						<label id="phone_label" for="phone">Phone<span class="required">*</span></label>
						<input id="phone" class="formInput" name="phone" size="18" type="text" />
						
						<label id="address_error" class="error formError" for="address">This field is required.</label>
						<label id="address_label" for="address">Address<span class="required">*</span></label>
						<input id="address" class="formInput" name="address" size="18" type="text" />
						
						<label id="city_error" class="error formError" for="city">This field is required.</label>
						<label id="city_label" for="city">City<span class="required">*</span></label>
						<input id="city" class="formInput" name="city" size="18" type="text" />
						
						<label id="state_error" class="error formError" for="state">This field is required.</label>
						<label id="state_label" for="state">State/Province<span class="required">*</span> (letters only)</label>
						<input id="state" class="formInput" name="state" size="18" type="text" />
						
						<label id="zip_error" class="error formError" for="zip">This field is required.</label>
						<label id="zip_label" for="zip">Zip/Postal Code<span class="required">*</span></label>
						<input id="zip" class="formInput" name="zip" size="18" type="text" />
						
						<label id="country_error" class="error formError" for="country">Please select your country.</label>
						<label id="country_label" for="country">Country<span class="required">*</span></label>
						<select id="country" class="select" name="country"> <option selected="selected">Please Choose</option> <option>United States</option>
<option>Abkhazia</option> <option>Afghanistan</option> <option>Aland</option> <option>Albania</option> <option>Algeria</option> <option>American Samoa</option> <option>Andorra</option> <option>Angola</option> <option>Anguilla</option> <option>Antigua &amp; Barbuda</option> <option>Argentina</option> <option>Armenia</option> <option>Aruba</option> <option>Australia</option> <option>Austria</option> <option>Azerbaijan</option> <option>The Bahamas</option> <option>Bahrain</option> <option>Bangladesh</option> <option>Barbados</option> <option>Belarus</option> <option>Belgium</option> <option>Belize</option> <option>Benin</option> <option>Bermuda</option> <option>Bhutan</option> <option>Bolivia</option> <option>Botswana</option> <option>Brazil</option> <option>Brunei</option> <option>Bulgaria</option> <option>Burkina Faso</option> <option>Burundi</option> <option>Cambodia</option> <option>Cameroon</option> <option>Canada</option> <option>Cape Verde</option> <option>Cayman Islands</option> <option>Chad</option> <option>Chile</option> <option>China</option> <option>Republic of China</option> <option>Christmas Island</option> <option>Colombia</option> <option>Comoros</option> <option>Congo</option> <option>Cook Islands</option> <option>Costa Rica</option> <option>Croatia</option> <option>Cuba</option> <option>Cyprus</option> <option>Czech Republic</option> <option>Denmark</option> <option>Djibouti</option> <option>Dominica</option> <option>Dominican Republic</option> <option>Ecuador</option> <option>Egypt</option> <option>El Salvador</option> <option>Equatorial Guinea</option> <option>Eritrea</option> <option>Estonia</option> <option>Ethiopia</option> <option>Falkland Islands</option> <option>Faroe Islands</option> <option>Fiji</option> <option>Finland</option> <option>France</option> <option>French Polynesia</option> <option>Gabon</option> <option>The Gambia</option> <option>Georgia</option> <option>Germany</option> <option>Ghana</option> <option>Gibraltar</option> <option>Greece</option> <option>Greenland</option> <option>Grenada</option> <option>Guam</option> <option>Guatemala</option> <option>Guernsey</option> <option>Guinea</option> <option>Guinea-Bissau</option> <option>Guyana Guyana</option> <option>Haiti Haiti</option> <option>Honduras</option> <option>Hong Kong</option> <option>Hungary</option> <option>Iceland</option> <option>India</option> <option>Indonesia</option> <option>Iran</option> <option>Iraq</option> <option>Ireland</option> <option>Israel</option> <option>Italy</option> <option>Jamaica</option> <option>Japan</option> <option>Jersey</option> <option>Jordan</option> <option>Kazakhstan</option> <option>Kenya</option> <option>Kiribati</option> <option>North Korea</option> <option>South Korea</option> <option>Kosovo</option> <option>Kuwait</option> <option>Kyrgyzstan</option> <option>Laos</option> <option>Latvia</option> <option>Lebanon</option> <option>Lesotho</option> <option>Liberia</option> <option>Libya</option> <option>Liechtenstein</option> <option>Lithuania</option> <option>Luxembourg</option> <option>Macau</option> <option>Macedonia</option> <option>Madagascar</option> <option>Malawi</option> <option>Malaysia</option> <option>Maldives</option> <option>Mali</option> <option>Malta</option> <option>Mauritania</option> <option>Mauritius</option> <option>Mayotte</option> <option>Mexico</option> <option>Micronesia</option> <option>Moldova</option> <option>Monaco</option> <option>Mongolia</option> <option>Montenegro</option> <option>Montserrat</option> <option>Morocco</option> <option>Mozambique</option> <option>Myanmar</option> <option>Nagorno-Karabakh</option> <option>Namibia</option> <option>Nauru</option> <option>Nepal</option> <option>Netherlands</option> <option>New Caledonia</option> <option>New Zealand</option> <option>Nicaragua</option> <option>Niger</option> <option>Nigeria</option> <option>Niue</option> <option>Norfolk Island</option> <option>Northern Mariana</option> <option>Norway</option> <option>Pakistan</option> <option>Palau</option> <option>Palestine</option> <option>Panama</option> <option>Papua New Guinea</option> <option>Paraguay</option> <option>Peru</option> <option>Philippines</option> <option>Poland</option> <option>Portugal</option> <option>Puerto Rico</option> <option>Qatar</option> <option>Romania</option> <option>Russia</option> <option>Rwanda</option> <option>Samoa</option> <option>San Marino</option> <option>Saudi Arabia</option> <option>Senegal</option> <option>Serbia</option> <option>Seychelles</option> <option>Sierra Leone</option> <option>Singapore</option> <option>Slovakia</option> <option>Slovenia</option> <option>Solomon Islands</option> <option>Somalia</option> <option>Somaliland</option> <option>South Africa</option> <option>South Ossetia</option> <option>Spain</option> <option>Sri Lanka</option> <option>Sudan</option> <option>Suriname</option> <option>Svalbard</option> <option>Swaziland</option> <option>Sweden</option> <option>Switzerland</option> <option>Syria</option> <option>Tajikistan</option> <option>Tanzania</option> <option>Thailand</option> <option>Timor-Leste</option> <option>Togo</option> <option>Tokelau</option> <option>Tonga</option> <option>Trinidad and Tobago</option> <option>Tristan da Cunha</option> <option>Tunisia</option> <option>Turkey</option> <option>Turkmenistan</option> <option>Tuvalu</option> <option>Uganda</option> <option>Ukraine</option> <option>United Arab Emirates</option> <option>United Kingdom</option>  <option>Uruguay</option> <option>Uzbekistan</option> <option>Vanuatu</option> <option>Vatican City</option> <option>Venezuela</option> <option>Vietnam</option> <option>Virgin Islands</option> <option>Western Sahara</option> <option>Yemen</option> <option>Zambia</option> <option>Zimbabwe</option> </select>
						
						<label id="machine_error" class="error formError" for="machine">This field is required.</label>
						<label id="machine_label" for="machine">Machine<span class="required">*</span></label>
							<select id="machine" class="select" name="machine"> 
							<option id="choose" value="Pick your machine">Pick your machine</option> 
							<option <?php if ( $machineSelected == VerticalBalers ) { echo 'selected="selected" '; } ?> value="Vertical Balers">Vertical Balers</option> 
							<option <?php if ( $machineSelected == HSO ) { echo 'selected="selected" '; } ?> value="HSO">HSO Baler</option> 
							<option <?php if ( $machineSelected == HLO ) { echo 'selected="selected" '; } ?> value="HLO">HLO Baler</option> 
							<option <?php if ( $machineSelected == HCB ) { echo 'selected="selected" '; } ?> value="HLO">HCB Baler</option>
							<option <?php if ( $machineSelected == HPSeries ) { echo 'selected="selected" '; } ?> value="HP Series">HP Series</option> 
							<option <?php if ( $machineSelected == HL ) { echo 'selected="selected" '; } ?> value="HL">HL Baler</option> 
							<option <?php if ( $machineSelected == HAL ) { echo 'selected="selected" '; } ?>value="HAL">HAL Baler</option> 
							<option <?php if ( $machineSelected == Piranha ) { echo 'selected="selected" '; } ?> value="Piranha">Piranha</option> 
							<option <?php if ( $machineSelected == Barracuda ) { echo 'selected="selected" '; } ?> value="Barracuda">Barracuda</option> 
							<option <?php if ( $machineSelected == Badger ) { echo 'selected="selected" '; } ?> value="Badger">Badger</option> 
							<option <?php if ( $machineSelected == Gorilla ) { echo 'selected="selected" '; } ?>value="Gorilla">Gorilla</option> 
							<option <?php if ( $machineSelected == HRB ) { echo 'selected="selected" '; } ?> value="HRB">HRB</option> 
							<option <?php if ( $machineSelected == HRBCenturion ) { echo 'selected="selected" '; } ?> value="Centurion">HRB Centurion</option> 
							<option <?php if ( $machineSelected == Wolverine ) { echo 'selected="selected" '; } ?> value="Wolverine">Wolverine</option> 
							<option <?php if ( $machineSelected == TGFerrousBaler ) { echo 'selected="selected" '; } ?> value="TG">TG Ferrous Baler</option> 
							<option <?php if ( $machineSelected == TGSFerrousBaler ) { echo 'selected="selected" '; } ?> value="TGS">TGS Ferrous Baler</option> 
							<option <?php if ( $machineSelected == TransPakPrecompactionSystem ) { echo 'selected="selected" '; } ?> value="TransPak">TransPak</option> 
							<option <?php if ( $machineSelected == "Shears" ) { echo 'selected="selected" '; } ?> value="Shears">Shears</option> 

							<option <?php if ( $machineSelected == ABSShear ) { echo 'selected="selected" '; } ?> value="ABS Shear">ABS Shear</option> 
							<option <?php if ( $machineSelected == BSHShear ) { echo 'selected="selected" '; } ?> value="BSH Shear">BSH Shear</option> 
							<option <?php if ( $machineSelected == "Baler/Logger" ) { echo 'selected="selected" '; } ?>value="Baler/Loggers"><strong>Baler/Loggers</strong></option>
							<option <?php if ( $machineSelected == "Side-CompressionShear" ) { echo 'selected="selected" '; } ?>value="SC Shear">Side-Compression Shear</option> 
							<option <?php if ( $machineSelected == "Baler/Logger/Shears" ) { echo 'selected="selected" '; } ?> value="Baler/Logger/Shears">Baler/Logger/Shears</option> 

							<option <?php if ( $machineSelected == "GSBaler/Logger/Shear" ) { echo 'selected="selected" '; } ?> value="GS">GS Series</option> 
							<option <?php if ( $machineSelected == Shredders ) { echo 'selected="selected" '; } ?> value="Shredders">Shredders</option>
							<option <?php if ( $machineSelected == Katana || $machineSelected == "Katana266SpecialAvailability" ) { echo 'selected="selected" '; } ?> value="Katana">Katana</option>
							<option <?php if ( $machineSelected == Manta54 ) { echo 'selected="selected" '; } ?> value="Manta">Manta</option>
							<option <?php if ( $machineSelected == Orca ) { echo 'selected="selected" '; } ?> value="Orca">Orca</option>
						</select>
						
						<label id="serial_error" class="error formError" for="source">This field is required.</label>
						<label id="serial_label" for="source">Serial Number<span class="required">*</span></label>
						<input id="serial" class="formInput" name="serial" size="18" type="text" />
						
						<label id="issue_error" class="error formError" for="formcomments">Briefly describe what you are looking for.</label>
						
						<label id="issue_error" class="error formError" for="source">This field is required.</label>
						<label id="issue_label" for="comments">Machine Issue<span class="required">*</span></label>
						<textarea id="issue" class="formInput" cols="17" rows="4" name="issue"></textarea>
						
						<input id="submit_btn" class="button" name="submit" type="submit" value="Send" /></fieldset>
						</form>
					
						<?php } ?>
						
					</div><!-- end Machine Request Info form -->
					
					<div class="formExplanation">  
						<?php the_content(); ?>
					</div>
				</div>

			</div>
		
		</div>
	

<?php endwhile; endif; ?>
<!-- content stuff -->


<?php get_footer(); ?>