<div class="contactSidebar">
<h3 class="subHeader">Contact <span>Harris</span></h3>
	<div id="contactForm">
			<?php $complete = $_GET["contactComplete"]; ?>
			
			<?php if (!$complete) { ?>
			
          	<form class="form" action="<?php echo bloginfo('template_url')?>/includes/contact-process.php" method="post">
          
            <fieldset>
            
            		<label class="error formError" for="name" id="name_error">This field is required.</label>
            		<label for="name" id="name_label">Name<span class="required">*</span></label>  
                  	<input type="text" name="name" id="name" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="company" id="company_error">This field is required.</label>
                    <label for="company" id="company_label">Company<span class="required">*</span></label>  
                  	<input type="text" name="company" id="company" size="18" value="" class="formInput" />  
                                            
                    <label class="error formError" for="email" id="email_error">This field is required.</label>
                    <label for="email" id="email_label">Email<span class="required">*</span></label>  
                  	<input type="email" name="email" id="email" size="18" value="" class="formInput" />  
                	
                	<label class="error formError" for="phone" id="phone_error">This field is required.</label>
                	<label for="phone" id="phone_label">Phone<span class="required">*</span></label>  
                  	<input type="text" name="phone" id="phone" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="address" id="address_error">This field is required.</label>
                    <label for="address" id="address_label">Address<span class="required">*</span></label>
                    <input type="text" name="address" id="address" size="18" value="" class="formInput" />
                    
                    <label class="error formError" for="city" id="city_error">This field is required.</label>
                    <label for="city" id="city_label">City<span class="required">*</span></label>  
                  	<input type="text" name="city" id="city" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="state" id="state_error">This field is required.</label>
                    <label for="state" id="state_label">State/Province<span class="required">*</span> (letters only)</label>  
                  	<input type="text" name="state" id="state" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="zip" id="zip_error">This field is required.</label>
                    <label for="zip" id="zip_label">Zip/Postal Code<span class="required">*</span></label>  
                  	<input type="text" name="zip" id="zip" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="country" id="country_error">This field is required.</label>
                    <label for="country" id="country_label">Country<span class="required">*</span></label>
                    <select class="select" name="country" id="country" >
                    	<option <?php if (!is_page('North American Sales')) { ?>selected="selected" <?php } ?>>Please Choose</option>
                    	<option <?php if (is_page('North American Sales')) { ?>selected="selected" <?php } ?>>United States</option>
                        <option>Abkhazia</option>
                        <option>Afghanistan</option>
                        <option>Aland</option>
                        <option>Albania</option>
                        <option>Algeria</option>
                        <option>American Samoa</option>
                        <option>Andorra</option>
                        <option>Angola</option>
                        <option>Anguilla</option>
                        <option>Antigua &amp; Barbuda</option>
                        <option>Argentina</option>
                        <option>Armenia</option>
                        <option>Aruba</option>
                        <option>Australia</option>
                        <option>Austria</option>
                        <option>Azerbaijan</option>
                        <option>The Bahamas</option>
                        <option>Bahrain</option>
                        <option>Bangladesh</option>
                        <option>Barbados</option>
                        <option>Belarus</option>
                        <option>Belgium</option>
                        <option>Belize</option>
                        <option>Benin</option>
                        <option>Bermuda</option>
                        <option>Bhutan</option>
                        <option>Bolivia</option>
                        <option>Botswana</option>
                        <option>Brazil</option>
                        <option>Brunei</option>
                        <option>Bulgaria</option>
                        <option>Burkina Faso</option>
                        <option>Burundi</option>
                        <option>Cambodia</option>
                        <option>Cameroon</option>
                        <option>Canada</option>
                        <option>Cape Verde</option>
                        <option>Cayman Islands</option>
                        <option>Chad</option>
                        <option>Chile</option>
                        <option>China</option>
                        <option>Republic of China</option>
                        <option>Christmas Island</option>
                        <option>Colombia</option>
                        <option>Comoros</option>
                        <option>Congo</option>
                        <option>Cook Islands</option>
                        <option>Costa Rica</option>
                        <option>Cote d'Ivoire</option>
                        <option>Croatia</option>
                        <option>Cuba</option>
                        <option>Cyprus</option>
                        <option>Czech Republic</option>
                        <option>Denmark</option>
                        <option>Djibouti</option>
                        <option>Dominica</option>
                        <option>Dominican Republic</option>
                        <option>Ecuador</option>
                        <option>Egypt</option>
                        <option>El Salvador</option>
                        <option>Equatorial Guinea</option>
                        <option>Eritrea</option>
                        <option>Estonia</option>
                        <option>Ethiopia</option>
                        <option>Falkland Islands</option>
                        <option>Faroe Islands</option>
                        <option>Fiji</option>
                        <option>Finland</option>
                        <option>France</option>
                        <option>French Polynesia</option>
                        <option>Gabon</option>
                        <option>The Gambia</option>
                        <option>Georgia</option>
                        <option>Germany</option>
                        <option>Ghana</option>
                        <option>Gibraltar</option>
                        <option>Greece</option>
                        <option>Greenland</option>
                        <option>Grenada</option>
                        <option>Guam</option>
                        <option>Guatemala</option>
                        <option>Guernsey</option>
                        <option>Guinea</option>
                        <option>Guinea-Bissau</option>
                        <option>Guyana Guyana</option>
                        <option>Haiti Haiti</option>
                        <option>Honduras</option>
                        <option>Hong Kong</option>
                        <option>Hungary</option>
                        <option>Iceland</option>
                        <option>India</option>
                        <option>Indonesia</option>
                        <option>Iran</option>
                        <option>Iraq</option>
                        <option>Ireland</option>
                        <option>Israel</option>
                        <option>Italy</option>
                        <option>Jamaica</option>
                        <option>Japan</option>
                        <option>Jersey</option>
                        <option>Jordan</option>
                        <option>Kazakhstan</option>
                        <option>Kenya</option>
                        <option>Kiribati</option>
                        <option>North Korea</option>
                        <option>South Korea</option>
                        <option>Kosovo</option>
                        <option>Kuwait</option>
                        <option>Kyrgyzstan</option>
                        <option>Laos</option>
                        <option>Latvia</option>
                        <option>Lebanon</option>
                        <option>Lesotho</option>
                        <option>Liberia</option>
                        <option>Libya</option>
                        <option>Liechtenstein</option>
                        <option>Lithuania</option>
                        <option>Luxembourg</option>
                        <option>Macau</option>
                        <option>Macedonia</option>
                        <option>Madagascar</option>
                        <option>Malawi</option>
                        <option>Malaysia</option>
                        <option>Maldives</option>
                        <option>Mali</option>
                        <option>Malta</option>
                        <option>Mauritania</option>
                        <option>Mauritius</option>
                        <option>Mayotte</option>
                        <option>Mexico</option>
                        <option>Micronesia</option>
                        <option>Moldova</option>
                        <option>Monaco</option>
                        <option>Mongolia</option>
                        <option>Montenegro</option>
                        <option>Montserrat</option>
                        <option>Morocco</option>
                        <option>Mozambique</option>
                        <option>Myanmar</option>
                        <option>Nagorno-Karabakh</option>
                        <option>Namibia</option>
                        <option>Nauru</option>
                        <option>Nepal</option>
                        <option>Netherlands</option>
                        <option>New Caledonia</option>
                        <option>New Zealand</option>
                        <option>Nicaragua</option>
                        <option>Niger</option>
                        <option>Nigeria</option>
                        <option>Niue</option>
                        <option>Norfolk Island</option>
                        <option>Northern Mariana</option>
                        <option>Norway</option>
                        <option>Pakistan</option>
                        <option>Palau</option>
                        <option>Palestine</option>
                        <option>Panama</option>
                        <option>Papua New Guinea</option>
                        <option>Paraguay</option>
                        <option>Peru</option>
                        <option>Philippines</option>
                        <option>Poland</option>
                        <option>Portugal</option>
                        <option>Puerto Rico</option>
                        <option>Qatar</option>
                        <option>Romania</option>
                        <option>Russia</option>
                        <option>Rwanda</option>
                        <option>Samoa</option>
                        <option>San Marino</option>
                        <option>Saudi Arabia</option>
                        <option>Senegal</option>
                        <option>Serbia</option>
                        <option>Seychelles</option>
                        <option>Sierra Leone</option>
                        <option>Singapore</option>
                        <option>Slovakia</option>
                        <option>Slovenia</option>
                        <option>Solomon Islands</option>
                        <option>Somalia</option>
                        <option>Somaliland</option>
                        <option>South Africa</option>
                        <option>South Ossetia</option>
                        <option>Spain</option>
                        <option>Sri Lanka</option>
                        <option>Sudan</option>
                        <option>Suriname</option>
                        <option>Svalbard</option>
                        <option>Swaziland</option>
                        <option>Sweden</option>
                        <option>Switzerland</option>
                        <option>Syria</option>
                        <option>Tajikistan</option>
                        <option>Tanzania</option>
                        <option>Thailand</option>
                        <option>Timor-Leste</option>
                        <option>Togo</option>
                        <option>Tokelau</option>
                        <option>Tonga</option>
                        <option>Trinidad and Tobago</option>
                        <option>Tristan da Cunha</option>
                        <option>Tunisia</option>
                        <option>Turkey</option>
                        <option>Turkmenistan</option>
                        <option>Tuvalu</option>
                        <option>Uganda</option>
                        <option>Ukraine</option>
                        <option>United Arab Emirates</option>
                        <option>United Kingdom</option>
                        <option>Uruguay</option>
                        <option>Uzbekistan</option>
                        <option>Vanuatu</option>
                        <option>Vatican City</option>
                        <option>Venezuela</option>
                        <option>Vietnam</option>
                        <option>Virgin Islands</option>
                        <option>Western Sahara</option>
                        <option>Yemen</option>
                        <option>Zambia</option>
                        <option>Zimbabwe</option>
                    </select> 
                    
                    <label class="error formError" for="machine" id="machine_error">This field is required.</label>
					<label for="machine" id="machine_label">Machine Interest<span class="required">*</span></label>
				 	<select class="select" name="machine" id="machine" >
                        <option value="Pick your machine" selected="selected" >Pick your machine</option>
                        <option value="Vertical Balers">Vertical Balers</option>
                        <option value="Piranha">Piranha</option> 
						<option value="Barracuda">Barracuda</option>
						<option value="HL">HL Baler</option>
						<option value="HAL">HAL Baler</option>
						<option value="HSO">HSO Baler</option> 
						<option value="HLO">HLO Baler</option> 
						<option value="HCB">HCB Baler</option>
						<option value="HP Series">HP Series</option>                           
						<option value="Wolverine">Wolverine</option>
                        <option value="Badger">Badger</option>
                        <option value="Gorilla">Gorilla</option>
                        <option value="Grizzly">Grizzly</option>
                        <option value="Centurion">HRB Centurion</option>
                        <option value="HRB">HRB</option>
                        <option value="TransPak">TransPak</option>
                        <option value="TGS">TGS</option>
                        <option value="TG">TG</option>
                        <option value="SS Shear">Side Squeeze Shear</option>
                        <option value="SC Shear">Side Compression Shear</option>
                        <option value="ABS">ABS Shear</option>
                        <option value="BSH">BSH Shear</option>
                        <option value="GS">GS Series</option>
                        <option value="Harris Shredders">Harris Shredders</option>
                        <option value="Orca">Orca</option>
                        <option value="Manta">Manta</option>
                        <option value="Katana">Katana</option>

                    </select>
                    
                    <label class="error formError" for="source" id="source_error">This field is required.</label>
                    <label for="source" id="source_label">How did you find us?<span class="required">*</span></label>
                    <select class="select" name="source" id="source" >
                    	<option value="Please Choose" selected="selected">Please Choose</option>
                    	<option value="Current Customer">I am a customer</option>
                        <option value="Referral">Customer Referral</option>
                        <option value="Google">Google</option>
                        <option value="Yahoo">Yahoo!</option>
                        <option value="Other Engine">Other Search Engine</option>
                        <option value="Waste News">Waste News </option>
                        <option value="Rec. Today">Recycling Today </option>
                        <option value="Scrap">Scrapsite</option>
                        <option value="AMM">AMM </option>
                        <option value="American Recycler">American Recycler</option>
                        <option value="Rec. Prod. News">Recycling Product News</option>
                        <option value="Wastec/Waste Age">Wastec/Waste Age</option>
                        <option value="Thomasnet.com">Thomasnet.com</option>
                    </select>
                    
                    <label class="error formError" for="formcomments" id="formcomments_error">This field is required.</label>
                    <label for="comments" id="formcomments_label">Comments<span class="required">*</span></label>  
                	<textarea class="formInput" name="formcomments" id="formcomments" type="text" size="14" maxlength="350" rows="6" cols="17"></textarea>
              		<label class="error" for="" id="emptyField_error">Please fill out all required fields.</label>
                	<input type="submit" name="submit" class="button" id="submit_btn" value="Send" />                  							
            </fieldset>
            
          </form>
         <?php } ?>
         
         <?php
			if ($complete == no) { ?>
			<h4 class="contactError">Please fill out all required<span class="required">*</span> fields</h4>
			<form class="form" action="<?php echo bloginfo('template_url')?>/includes/contact-process.php" method="post"><!--http://www.harrisequip.com/processForms/hubspotForm1.php-->
          
            <fieldset>
            
            		<label class="error formError" for="name" id="name_error">This field is required.</label>
            		<label for="name" id="name_label">Name<span class="required">*</span></label>  
                  	<input type="text" name="name" id="name" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="company" id="company_error">This field is required.</label>
                    <label for="company" id="company_label">Company<span class="required">*</span></label>  
                  	<input type="text" name="company" id="company" size="18" value="" class="formInput" />  
                                            
                    <label class="error formError" for="email" id="email_error">This field is required.</label>
                    <label for="email" id="email_label">Email<span class="required">*</span></label>  
                  	<input type="text" name="email" id="email" size="18" value="" class="formInput" />  
                	
                	<label class="error formError" for="phone" id="phone_error">This field is required.</label>
                	<label for="phone" id="phone_label">Phone<span class="required">*</span></label>  
                  	<input type="text" name="phone" id="phone" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="address" id="address_error">This field is required.</label>
                    <label for="address" id="address_label">Address<span class="required">*</span></label>
                    <input type="text" name="address" id="address" size="18" value="" class="formInput" />
                    
                    <label class="error formError" for="city" id="city_error">This field is required.</label>
                    <label for="city" id="city_label">City<span class="required">*</span></label>  
                  	<input type="text" name="city" id="city" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="state" id="state_error">This field is required.</label>
                    <label for="state" id="state_label">State/Province<span class="required">*</span> (letters only)</label>  
                  	<input type="text" name="state" id="state" size="18" value="" class="formInput" />  
                    
                    <label class="error formError" for="zip" id="zip_error">This field is required.</label>
                    <label for="zip" id="zip_label">Zip Code<span class="required">*</span></label>  
                  	<input type="text" name="zip" id="zip" size="18" value="" class="formInput" />  
                    
                    <label for="country" id="country_label">Country</label>
                    <select class="select" name="country" id="country" >
                    	<option selected="selected">Please Choose</option>
                        <option>Abkhazia</option>
                        <option>Afghanistan</option>
                        <option>Aland</option>
                        <option>Albania</option>
                        <option>Algeria</option>
                        <option>American Samoa</option>
                        <option>Andorra</option>
                        <option>Angola</option>
                        <option>Anguilla</option>
                        <option>Antigua &amp; Barbuda</option>
                        <option>Argentina</option>
                        <option>Armenia</option>
                        <option>Aruba</option>
                        <option>Australia</option>
                        <option>Austria</option>
                        <option>Azerbaijan</option>
                        <option>The Bahamas</option>
                        <option>Bahrain</option>
                        <option>Bangladesh</option>
                        <option>Barbados</option>
                        <option>Belarus</option>
                        <option>Belgium</option>
                        <option>Belize</option>
                        <option>Benin</option>
                        <option>Bermuda</option>
                        <option>Bhutan</option>
                        <option>Bolivia</option>
                        <option>Botswana</option>
                        <option>Brazil</option>
                        <option>Brunei</option>
                        <option>Bulgaria</option>
                        <option>Burkina Faso</option>
                        <option>Burundi</option>
                        <option>Cambodia</option>
                        <option>Cameroon</option>
                        <option>Canada</option>
                        <option>Cape Verde</option>
                        <option>Cayman Islands</option>
                        <option>Chad</option>
                        <option>Chile</option>
                        <option>China</option>
                        <option>Republic of China</option>
                        <option>Christmas Island</option>
                        <option>Colombia</option>
                        <option>Comoros</option>
                        <option>Congo</option>
                        <option>Cook Islands</option>
                        <option>Costa Rica</option>
                        <option>Cote d'Ivoire</option>
                        <option>Croatia</option>
                        <option>Cuba</option>
                        <option>Cyprus</option>
                        <option>Czech Republic</option>
                        <option>Denmark</option>
                        <option>Djibouti</option>
                        <option>Dominica</option>
                        <option>Dominican Republic</option>
                        <option>Ecuador</option>
                        <option>Egypt</option>
                        <option>El Salvador</option>
                        <option>Equatorial Guinea</option>
                        <option>Eritrea</option>
                        <option>Estonia</option>
                        <option>Ethiopia</option>
                        <option>Falkland Islands</option>
                        <option>Faroe Islands</option>
                        <option>Fiji</option>
                        <option>Finland</option>
                        <option>France</option>
                        <option>French Polynesia</option>
                        <option>Gabon</option>
                        <option>The Gambia</option>
                        <option>Georgia</option>
                        <option>Germany</option>
                        <option>Ghana</option>
                        <option>Gibraltar</option>
                        <option>Greece</option>
                        <option>Greenland</option>
                        <option>Grenada</option>
                        <option>Guam</option>
                        <option>Guatemala</option>
                        <option>Guernsey</option>
                        <option>Guinea</option>
                        <option>Guinea-Bissau</option>
                        <option>Guyana Guyana</option>
                        <option>Haiti Haiti</option>
                        <option>Honduras</option>
                        <option>Hong Kong</option>
                        <option>Hungary</option>
                        <option>Iceland</option>
                        <option>India</option>
                        <option>Indonesia</option>
                        <option>Iran</option>
                        <option>Iraq</option>
                        <option>Ireland</option>
                        <option>Israel</option>
                        <option>Italy</option>
                        <option>Jamaica</option>
                        <option>Japan</option>
                        <option>Jersey</option>
                        <option>Jordan</option>
                        <option>Kazakhstan</option>
                        <option>Kenya</option>
                        <option>Kiribati</option>
                        <option>North Korea</option>
                        <option>South Korea</option>
                        <option>Kosovo</option>
                        <option>Kuwait</option>
                        <option>Kyrgyzstan</option>
                        <option>Laos</option>
                        <option>Latvia</option>
                        <option>Lebanon</option>
                        <option>Lesotho</option>
                        <option>Liberia</option>
                        <option>Libya</option>
                        <option>Liechtenstein</option>
                        <option>Lithuania</option>
                        <option>Luxembourg</option>
                        <option>Macau</option>
                        <option>Macedonia</option>
                        <option>Madagascar</option>
                        <option>Malawi</option>
                        <option>Malaysia</option>
                        <option>Maldives</option>
                        <option>Mali</option>
                        <option>Malta</option>
                        <option>Mauritania</option>
                        <option>Mauritius</option>
                        <option>Mayotte</option>
                        <option>Mexico</option>
                        <option>Micronesia</option>
                        <option>Moldova</option>
                        <option>Monaco</option>
                        <option>Mongolia</option>
                        <option>Montenegro</option>
                        <option>Montserrat</option>
                        <option>Morocco</option>
                        <option>Mozambique</option>
                        <option>Myanmar</option>
                        <option>Nagorno-Karabakh</option>
                        <option>Namibia</option>
                        <option>Nauru</option>
                        <option>Nepal</option>
                        <option>Netherlands</option>
                        <option>New Caledonia</option>
                        <option>New Zealand</option>
                        <option>Nicaragua</option>
                        <option>Niger</option>
                        <option>Nigeria</option>
                        <option>Niue</option>
                        <option>Norfolk Island</option>
                        <option>Northern Mariana</option>
                        <option>Norway</option>
                        <option>Pakistan</option>
                        <option>Palau</option>
                        <option>Palestine</option>
                        <option>Panama</option>
                        <option>Papua New Guinea</option>
                        <option>Paraguay</option>
                        <option>Peru</option>
                        <option>Philippines</option>
                        <option>Poland</option>
                        <option>Portugal</option>
                        <option>Puerto Rico</option>
                        <option>Qatar</option>
                        <option>Romania</option>
                        <option>Russia</option>
                        <option>Rwanda</option>
                        <option>Samoa</option>
                        <option>San Marino</option>
                        <option>Saudi Arabia</option>
                        <option>Senegal</option>
                        <option>Serbia</option>
                        <option>Seychelles</option>
                        <option>Sierra Leone</option>
                        <option>Singapore</option>
                        <option>Slovakia</option>
                        <option>Slovenia</option>
                        <option>Solomon Islands</option>
                        <option>Somalia</option>
                        <option>Somaliland</option>
                        <option>South Africa</option>
                        <option>South Ossetia</option>
                        <option>Spain</option>
                        <option>Sri Lanka</option>
                        <option>Sudan</option>
                        <option>Suriname</option>
                        <option>Svalbard</option>
                        <option>Swaziland</option>
                        <option>Sweden</option>
                        <option>Switzerland</option>
                        <option>Syria</option>
                        <option>Tajikistan</option>
                        <option>Tanzania</option>
                        <option>Thailand</option>
                        <option>Timor-Leste</option>
                        <option>Togo</option>
                        <option>Tokelau</option>
                        <option>Tonga</option>
                        <option>Trinidad and Tobago</option>
                        <option>Tristan da Cunha</option>
                        <option>Tunisia</option>
                        <option>Turkey</option>
                        <option>Turkmenistan</option>
                        <option>Tuvalu</option>
                        <option>Uganda</option>
                        <option>Ukraine</option>
                        <option>United Arab Emirates</option>
                        <option>United Kingdom</option>
                        <option>United States</option>
                        <option>Uruguay</option>
                        <option>Uzbekistan</option>
                        <option>Vanuatu</option>
                        <option>Vatican City</option>
                        <option>Venezuela</option>
                        <option>Vietnam</option>
                        <option>Virgin Islands</option>
                        <option>Western Sahara</option>
                        <option>Yemen</option>
                        <option>Zambia</option>
                        <option>Zimbabwe</option>
                    </select> 
                    
					<label for="machine" id="machine_label">Machine Interest</label>
				 	<select class="select" name="machine" id="machine" >
                        <option value="Pick your machine">Pick your machine</option>
                        <option value="Vertical Balers">Vertical Balers</option>
                        <option value="Piranha">Piranha</option> 
						<option value="Barracuda">Barracuda</option>
						<option value="HL">HL Baler</option>
						<option value="HAL">HAL Baler</option>
						<option value="HSO">HSO Baler</option> 
						<option value="HLO">HLO Baler</option> 
						<option value="HCB">HCB Baler</option>
						<option value="HP Series">HP Series</option>                           
						<option value="Wolverine">Wolverine</option>
                        <option value="Badger">Badger</option>
                        <option value="Gorilla">Gorilla</option>
                        <option value="Grizzly">Grizzly</option>
                        <option value="Centurion">HRB Centurion</option>
                        <option value="HRB">HRB</option>
                        <option value="TransPak">TransPak</option>
                        <option value="TGS">TGS</option>
                        <option value="TG">TG</option>
                        <option value="SS Shear">Side Squeeze Shear</option>
                        <option value="SC Shear">Side Compression Shear</option>
                        <option value="ABS">ABS Shear</option>
                        <option value="BSH">BSH Shear</option>
                        <option value="GS">GS Series</option>
                        <option value="Harris Shredders">Harris Shredders</option>
                        <option value="Orca">Orca</option>
                        <option value="Manta">Manta</option>
                        <option <?php if (is_page(array(1768))) { ?> selected="selected" <?php } ?> value="Katana">Katana</option>

                    </select>                    
                    <label for="source" id="source_label">How did you find us?</label>
                    <select class="select" name="source" id="source" >
                    	<option value="Please Choose" selected="selected">Please Choose</option>
                    	<option value="Current Customer">I am a customer</option>
                        <option value="Referral">Customer Referral</option>
                        <option value="Google">Google</option>
                        <option value="Yahoo">Yahoo!</option>
                        <option value="Other Engine">Other Search Engine</option>
                        <option value="Waste News">Waste News </option>
                        <option value="Rec. Today">Recycling Today </option>
                        <option value="Scrap">Scrapsite</option>
                        <option value="AMM">AMM </option>
                        <option value="American Recycler">American Recycler</option>
                        <option value="Rec. Prod. News">Recycling Product News</option>
                        <option value="Wastec/Waste Age">Wastec/Waste Age</option>
                        <option value="Thomasnet.com">Thomasnet.com</option>
                    </select>
                    
                    <label for="comments" id="formcomments_label">Comments</label>  
                	<textarea class="formInput" name="formcomments" id="formcomments" type="text" size="14" maxlength="350" rows="6" cols="17"></textarea>
              		<label class="error" for="" id="emptyField_error">Please fill out all required fields.</label>
                	<input type="submit" name="submit" class="button" id="submit_btn" value="Send" />                  							
            </fieldset>
            
          </form>
			<?php } ?>
			
			<?php 
				//email sent
				if ($complete == yes) { ?>
				<div id="signupMessage">
				<h3>Information Received</h3>
				<p>We have received your information request. Someone from Harris will be in touch with you soon. If you want, at any point, to contact Harris directly you can reach us at 800.373.9131 or 770.631.7290</p>
				<p class='thankYou'>Thank You!</p>
				</div>
				<?php } ?>
          	
        </div>
</div>