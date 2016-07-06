<?php
require_once("common.inc.php");
(isset($_POST["country"]))? $country = strip_tags($_POST["country"]) : $country = "";
?>
					<select id="country" name="country" class="form-control" value="<?php echo $country; ?>" aria-label="Country Name">
						<option arivaluea-label="" value=" " aria-label="Please Select Your Country" default>Please Select Your Country</option>
						<option aria-label="United" value="United States of America">United States of America</option>
						<option aria-label="Afghanistan" value="Afghanistan">Afghanistan</option>
						<option aria-label="Albania" value="Albania">Albania</option>
						<option aria-label="Algeria" value="Algeria">Algeria</option>
						<option aria-label="American Samoa" value="American Samoa">American Samoa</option>
						<option aria-label="Andorra" value="Andorra">Andorra</option>
						<option aria-label="Angola" value="Angola">Angola</option>
						<option aria-label="Anguilla" value="Anguilla">Anguilla</option>
						<option aria-label="Antarctica" value="Antarctica">Antarctica</option>
						<option aria-label="Antigua and Barbuda" value="Antigua and Barbuda">Antigua and Barbuda</option>
						<option aria-label="Argentina" value="Argentina">Argentina</option>
						<option aria-label="Armenia" value="Armenia">Armenia</option>
						<option aria-label="Aruba" value="Aruba">Aruba</option>
						<option aria-label="Australia" value="Australia">Australia</option>
						<option aria-label="Austria" value="Austria">Austria</option>
						<option aria-label="Azerbaijan" value="Azerbaijan">Azerbaijan</option>
						<option aria-label="Bahamas" value="Bahamas">Bahamas</option>
						<option aria-label="Bahrain" value="Bahrain">Bahrain</option>
						<option aria-label="Bangladesh" value="Bangladesh">Bangladesh</option>
						<option aria-label="Barbados" value="Barbados">Barbados</option>
						<option aria-label="Belarus" value="Belarus">Belarus</option>
						<option aria-label="Belgium" value="Belgium">Belgium</option>
						<option aria-label="Belize" value="Belize">Belize</option>
						<option aria-label="Benin" value="Benin">Benin</option>
						<option aria-label="Bermuda" value="Bermuda">Bermuda</option>
						<option aria-label="Bhutan" value="Bhutan">Bhutan</option>
						<option aria-label="Bolivia" value="Bolivia">Bolivia</option>
						<option aria-label="Bonaire, Sint Eustatius and Saba" value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
						<option aria-label="Bosnia" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
						<option aria-label="Botswana" value="Botswana">Botswana</option>
						<option aria-label="Bouvet Island" value="Bouvet Island">Bouvet Island</option>
						<option aria-label="Brazil" value="Brazil">Brazil</option>
						<option aria-label="British Indian Ocean Territory" value="British Indian Ocean Territory">British Indian Ocean Territory</option>
						<option aria-label="Brunei Darussalam" value="Brunei Darussalam">Brunei Darussalam</option>
						<option aria-label="Bulgaria" value="Bulgaria">Bulgaria</option>
						<option aria-label="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
						<option aria-label="Burundi" value="Burundi">Burundi</option>
						<option aria-label="Cambodia" value="Cambodia">Cambodia</option>
						<option aria-label="Cameroon" value="Cameroon">Cameroon</option>
						<option aria-label="Canada" value="Canada">Canada</option>
						<option aria-label="Cape Verde" value="Cape Verde">Cape Verde</option>
						<option aria-label="Cayman Islands" value="Cayman Islands">Cayman Islands</option>
						<option aria-label="Central African Republic" value="Central African Republic">Central African Republic</option>
						<option aria-label="Chad" value="Chad">Chad</option>
						<option aria-label="Chile" value="Chile">Chile</option>
						<option aria-label="China" value="China">China</option>
						<option aria-label="Christmas Island" value="Christmas Island">Christmas Island</option>
						<option aria-label="Cocos (Keeling) Islands" value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
						<option aria-label="Colombia" value="Colombia">Colombia</option>
						<option aria-label="Comoros" value="Comoros">Comoros</option>
						<option aria-label="Congo (Brazzaville)" value="Congo (Brazzaville)">Congo (Brazzaville)</option>
						<option aria-label="Congo (Kinshasa)" value="Congo (Kinshasa)">Congo (Kinshasa)</option>
						<option aria-label="Cook Islands" value="Cook Islands">Cook Islands</option>
						<option aria-label="Costa Rica" value="Costa Rica">Costa Rica</option>
						<option aria-label="Croatia" value="Croatia">Croatia</option>
						<option aria-label="Cuba" value="Cuba">Cuba</option>
						<option aria-label="Curaçao" value="Curaçao">Curaçao</option>
						<option aria-label="Cyprus" value="Cyprus">Cyprus</option>
						<option aria-label="Czech Republic" value="Czech Republic">Czech Republic</option>
						<option aria-label="Côte d'Ivoire" value="Côte d'Ivoire">Côte d'Ivoire</option>
						<option aria-label="Denmark" value="Denmark">Denmark</option>
						<option aria-label="Djibouti" value="Djibouti">Djibouti</option>
						<option aria-label="Dominica" value="Dominica">Dominica</option>
						<option aria-label="Dominican Republic" value="Dominican Republic">Dominican Republic</option>
						<option aria-label="Ecuador" value="Ecuador">Ecuador</option>
						<option aria-label="Egypt" value="Egypt">Egypt</option>
						<option aria-label="El Salvador" value="El Salvador">El Salvador</option>
						<option aria-label="Equatorial Guinea" value="Equatorial Guinea">Equatorial Guinea</option>
						<option aria-label="Eritrea" value="Eritrea">Eritrea</option>
						<option aria-label="Estonia" value="Estonia">Estonia</option>
						<option aria-label="Ethiopia" value="Ethiopia">Ethiopia</option>
						<option aria-label="Falkland Islands" value="Falkland Islands">Falkland Islands</option>
						<option aria-label="Faroe Islands" value="Faroe Islands">Faroe Islands</option>
						<option aria-label="Fiji" value="Fiji">Fiji</option>
						<option aria-label="Finland" value="Finland">Finland</option>
						<option aria-label="France" value="France">France</option>
						<option aria-label="French Guiana" value="French Guiana">French Guiana</option>
						<option aria-label="French Polynesia" value="French Polynesia">French Polynesia</option>
						<option aria-label="French Southern Lands" value="French Southern Lands">French Southern Lands</option>
						<option aria-label="Gabon" value="Gabon">Gabon</option>
						<option aria-label="Gambia" value="Gambia">Gambia</option>
						<option aria-label="Georgia" value="Georgia">Georgia</option>
						<option aria-label="Germany" value="Germany">Germany</option>
						<option aria-label="Ghana" value="Ghana">Ghana</option>
						<option aria-label="Gibraltar" value="Gibraltar">Gibraltar</option>
						<option aria-label="Greece" value="Greece">Greece</option>
						<option aria-label="Greenland" value="Greenland">Greenland</option>
						<option aria-label="Grenada" value="Grenada">Grenada</option>
						<option aria-label="Guadeloupe" value="Guadeloupe">Guadeloupe</option>
						<option aria-label="Guam" value="Guam">Guam</option>
						<option aria-label="Guatemala" value="Guatemala">Guatemala</option>
						<option aria-label="Guernsey" value="Guernsey">Guernsey</option>
						<option aria-label="Guinea" value="Guinea">Guinea</option>
						<option aria-label="Guinea" value="Guinea-Bissau">Guinea-Bissau</option>
						<option aria-label="Guyana" value="Guyana">Guyana</option>
						<option aria-label="Haiti" value="Haiti">Haiti</option>
						<option aria-label="Heard and McDonald Islands" value="Heard and McDonald Islands">Heard and McDonald Islands</option>
						<option aria-label="Honduras" value="Honduras">Honduras</option>
						<option aria-label="Hong Kong" value="Hong Kong">Hong Kong</option>
						<option aria-label="Hungary" value="Hungary">Hungary</option>
						<option aria-label="Iceland" value="Iceland">Iceland</option>
						<option aria-label="India" value="India">India</option>
						<option aria-label="Indonesia" value="Indonesia">Indonesia</option>
						<option aria-label="Iran" value="Iran">Iran</option>
						<option aria-label="Iraq" value="Iraq">Iraq</option>
						<option aria-label="Ireland" value="Ireland">Ireland</option>
						<option aria-label="Isle of Man" value="Isle of Man">Isle of Man</option>
						<option aria-label="Israel" value="Israel">Israel</option>
						<option aria-label="Italy" value="Italy">Italy</option>
						<option aria-label="Jamaica" value="Jamaica">Jamaica</option>
						<option aria-label="Japan" value="Japan">Japan</option>
						<option aria-label="Jersey" value="Jersey">Jersey</option>
						<option aria-label="Jordan" value="Jordan">Jordan</option>
						<option aria-label="Kazakhstan" value="Kazakhstan">Kazakhstan</option>
						<option aria-label="Kenya" value="Kenya">Kenya</option>
						<option aria-label="Kiribati" value="Kiribati">Kiribati</option>
						<option aria-label="Korea, North" value="Korea, North">Korea, North</option>
						<option aria-label="Korea, South" value="Korea, South">Korea, South</option>
						<option aria-label="Kuwait" value="Kuwait">Kuwait</option>
						<option aria-label="Kyrgyzstan" value="Kyrgyzstan">Kyrgyzstan</option>
						<option aria-label="Laos" value="Laos">Laos</option>
						<option aria-label="Latvia" value="Latvia">Latvia</option>
						<option aria-label="Lebanon" value="Lebanon">Lebanon</option>
						<option aria-label="Lesotho" value="Lesotho">Lesotho</option>
						<option aria-label="Liberia" value="Liberia">Liberia</option>
						<option aria-label="Libya" value="Libya">Libya</option>
						<option aria-label="Liechtenstein" value="Liechtenstein">Liechtenstein</option>
						<option aria-label="Lithuania" value="Lithuania">Lithuania</option>
						<option aria-label="Luxembourg" value="Luxembourg">Luxembourg</option>
						<option aria-label="Macau" value="Macau">Macau</option>
						<option aria-label="Macedonia" value="Macedonia">Macedonia</option>
						<option aria-label="Madagascar" value="Madagascar">Madagascar</option>
						<option aria-label="Malawi" value="Malawi">Malawi</option>
						<option aria-label="Malaysia" value="Malaysia">Malaysia</option>
						<option aria-label="Maldives" value="Maldives">Maldives</option>
						<option aria-label="Mali" value="Mali">Mali</option>
						<option aria-label="Malta" value="Malta">Malta</option>
						<option aria-label="Marshall Islands" value="Marshall Islands">Marshall Islands</option>
						<option aria-label="Martinique" value="Martinique">Martinique</option>
						<option aria-label="Mauritania" value="Mauritania">Mauritania</option>
						<option aria-label="Mauritius" value="Mauritius">Mauritius</option>
						<option aria-label="Mayotte" value="Mayotte">Mayotte</option>
						<option aria-label="Mexico" value="Mexico">Mexico</option>
						<option aria-label="Micronesia" value="Micronesia">Micronesia</option>
						<option aria-label="Moldova" value="Moldova">Moldova</option>
						<option aria-label="Monaco" value="Monaco">Monaco</option>
						<option aria-label="Mongolia" value="Mongolia">Mongolia</option>
						<option aria-label="Montenegro" value="Montenegro">Montenegro</option>
						<option aria-label="Montserrat" value="Montserrat">Montserrat</option>
						<option aria-label="Morocco" value="Morocco">Morocco</option>
						<option aria-label="Mozambique" value="Mozambique">Mozambique</option>
						<option aria-label="Myanmar" value="Myanmar">Myanmar</option>
						<option aria-label="Namibia" value="Namibia">Namibia</option>
						<option aria-label="Nauru" value="Nauru">Nauru</option>
						<option aria-label="Nepal" value="Nepal">Nepal</option>
						<option aria-label="Netherlands" value="Netherlands">Netherlands</option>
						<option aria-label="Netherlands Antilles" value="Netherlands Antilles">Netherlands Antilles</option>
						<option aria-label="New Caledonia" value="New Caledonia">New Caledonia</option>
						<option aria-label="New Zealand" value="New Zealand">New Zealand</option>
						<option aria-label="Nicaragua" value="Nicaragua">Nicaragua</option>
						<option aria-label="Niger" value="Niger">Niger</option>
						<option aria-label="Nigeria" value="Nigeria">Nigeria</option>
						<option aria-label="Niue" value="Niue">Niue</option>
						<option aria-label="Norfolk Island" value="Norfolk Island">Norfolk Island</option>
						<option aria-label="Northern Mariana Islands" value="Northern Mariana Islands">Northern Mariana Islands</option>
						<option aria-label="Norway" value="Norway">Norway</option>
						<option aria-label="Oman" value="Oman">Oman</option>
						<option aria-label="Pakistan" value="Pakistan">Pakistan</option>
						<option aria-label="Palau" value="Palau">Palau</option>
						<option aria-label="Palestine" value="Palestine">Palestine</option>
						<option aria-label="Panama" value="Panama">Panama</option>
						<option aria-label="Papua New Guinea" value="Papua New Guinea">Papua New Guinea</option>
						<option aria-label="Paraguay" value="Paraguay">Paraguay</option>
						<option aria-label="Peru" value="Peru">Peru</option>
						<option aria-label="Philippines" value="Philippines">Philippines</option>
						<option aria-label="Pitcairn" value="Pitcairn">Pitcairn</option>
						<option aria-label="Poland" value="Poland">Poland</option>
						<option aria-label="Portugal" value="Portugal">Portugal</option>
						<option aria-label="Puerto Rico" value="Puerto Rico">Puerto Rico</option>
						<option aria-label="Qatar" value="Qatar">Qatar</option>
						<option aria-label="Reunion" value="Reunion">Reunion</option>
						<option aria-label="Romania" value="Romania">Romania</option>
						<option aria-label="Russian Federation" value="Russian Federation">Russian Federation</option>
						<option aria-label="Rwanda" value="Rwanda">Rwanda</option>
						<option aria-label="Saint Barthélemy" value="Saint Barthélemy">Saint Barthélemy</option>
						<option aria-label="Saint Helena" value="Saint Helena">Saint Helena</option>
						<option aria-label="Saint Kitts and Nevis" value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
						<option aria-label="Saint Lucia" value="Saint Lucia">Saint Lucia</option>
						<option aria-label="Saint Martin (French part)" value="Saint Martin (French part)">Saint Martin (French part)</option>
						<option aria-label="Saint Pierre and Miquelon" value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
						<option aria-label="Saint Vincent and the Grenadines" value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
						<option aria-label="Samoa" value="Samoa">Samoa</option>
						<option aria-label="San Marino" value="San Marino">San Marino</option>
						<option aria-label="Sao Tome and Principe" value="Sao Tome and Principe">Sao Tome and Principe</option>
						<option aria-label="Saudi Arabia" value="Saudi Arabia">Saudi Arabia</option>
						<option aria-label="Senegal" value="Senegal">Senegal</option>
						<option aria-label="Serbia" value="Serbia">Serbia</option>
						<option aria-label="Seychelles" value="Seychelles">Seychelles</option>
						<option aria-label="Sierra Leone" value="Sierra Leone">Sierra Leone</option>
						<option aria-label="Singapore" value="Singapore">Singapore</option>
						<option aria-label="Sint Maarten (Dutch part)" value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
						<option aria-label="Slovakia" value="Slovakia">Slovakia</option>
						<option aria-label="Slovenia" value="Slovenia">Slovenia</option>
						<option aria-label="Solomon Islands" value="Solomon Islands">Solomon Islands</option>
						<option aria-label="Somalia" value="Somalia">Somalia</option>
						<option aria-label="South Africa" value="South Africa">South Africa</option>
						<option aria-label="South Georgia and South Sandwich Islands" value="South Georgia and South Sandwich Islands">South Georgia and South Sandwich Islands</option>
						<option aria-label="South Sudan" value="South Sudan">South Sudan</option>
						<option aria-label="Spain" value="Spain">Spain</option>
						<option aria-label="Sri Lanka" value="Sri Lanka">Sri Lanka</option>
						<option aria-label="Sudan" value="Sudan">Sudan</option>
						<option aria-label="Suriname" value="Suriname">Suriname</option>
						<option aria-label="Svalbard and Jan Mayen Islands" value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
						<option aria-label="Swaziland" value="Swaziland">Swaziland</option>
						<option aria-label="Sweden" value="Sweden">Sweden</option>
						<option aria-label="Switzerland" value="Switzerland">Switzerland</option>
						<option aria-label="Syria" value="Syria">Syria</option>
						<option aria-label="Taiwan" value="Taiwan">Taiwan</option>
						<option aria-label="Tajikistan" value="Tajikistan">Tajikistan</option>
						<option aria-label="Tanzania" value="Tanzania">Tanzania</option>
						<option aria-label="Thailand" value="Thailand">Thailand</option>
						<option aria-label="Timor-Leste" value="Timor-Leste">Timor-Leste</option>
						<option aria-label="Togo" value="Togo">Togo</option>
						<option aria-label="Tokelau" value="Tokelau">Tokelau</option>
						<option aria-label="Tonga" value="Tonga">Tonga</option>
						<option aria-label="Trinidad and Tobago" value="Trinidad and Tobago">Trinidad and Tobago</option>
						<option aria-label="Tunisia" value="Tunisia">Tunisia</option>
						<option aria-label="Turkey" value="Turkey">Turkey</option>
						<option aria-label="Turkmenistan" value="Turkmenistan">Turkmenistan</option>
						<option aria-label="Turks and Caicos Islands" value="Turks and Caicos Islands">Turks and Caicos Islands</option>
						<option aria-label="Tuvalu" value="Tuvalu">Tuvalu</option>
						<option aria-label="Uganda" value="Uganda">Uganda</option>
						<option aria-label="Ukraine" value="Ukraine">Ukraine</option>
						<option aria-label="United Arab Emirates" value="United Arab Emirates">United Arab Emirates</option>
						<option aria-label="United Kingdom" value="United Kingdom">United Kingdom</option>
						<option aria-label="United States Minor Outlying Islands" value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
						<option aria-label="United States of America" value="United States of America">United States of America</option>
						<option aria-label="Uruguay" value="Uruguay">Uruguay</option>
						<option aria-label="Uzbekistan" value="Uzbekistan">Uzbekistan</option>
						<option aria-label="Vanuatu" value="Vanuatu">Vanuatu</option>
						<option aria-label="Vatican City" value="Vatican City">Vatican City</option>
						<option aria-label="Venezuela" value="Venezuela">Venezuela</option>
						<option aria-label="Vietnam" value="Vietnam">Vietnam</option>
						<option aria-label="Virgin Islands, British" value="Virgin Islands, British">Virgin Islands, British</option>
						<option aria-label="Virgin Islands, U.S." value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
						<option aria-label="Wallis and Futuna Islands" value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
						<option aria-label="Western Sahara" value="Western Sahara">Western Sahara</option>
						<option aria-label="Yemen" value="Yemen">Yemen</option>
						<option aria-label="Zambia" value="Zambia">Zambia</option>
						<option aria-label="Zimbabwe" value="Zimbabwe">Zimbabwe</option>
						<option aria-label="Åland" value="Åland">Åland</option>
					</select>