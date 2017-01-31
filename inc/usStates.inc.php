<?php
function usStates($identifier, $selection=NULL){
?>
	<select id="<?=$identifier?>" class="form-control" name="<?=$identifier?>">
		<option value="">Choose a state</option>
		<option value="AL" <?php echo ($selection == 'AL') ? "selected=\"selected\"": ''; ?> >Alabama</option>
		<option value="AK" <?php echo ($selection == 'AK') ? "selected=\"selected\"": ''; ?> >Alaska</option>
		<option value="AZ" <?php echo ($selection == 'AZ') ? "selected=\"selected\"": ''; ?> >Arizona</option>
		<option value="AR" <?php echo ($selection == 'AR') ? "selected=\"selected\"": ''; ?> >Arkansas</option>
		<option value="CA" <?php echo ($selection == 'CA') ? "selected=\"selected\"": ''; ?> >California</option>
		<option value="CO" <?php echo ($selection == 'CO') ? "selected=\"selected\"": ''; ?> >Colorado</option>
		<option value="CT" <?php echo ($selection == 'CT') ? "selected=\"selected\"": ''; ?> >Connecticut</option>
		<option value="DE" <?php echo ($selection == 'DE') ? "selected=\"selected\"": ''; ?> >Delaware</option>
		<option value="DC" <?php echo ($selection == 'DC') ? "selected=\"selected\"": ''; ?> >District of Columbia</option>
		<option value="FL" <?php echo ($selection == 'FL') ? "selected=\"selected\"": ''; ?> >Florida</option>
		<option value="GA" <?php echo ($selection == 'GA') ? "selected=\"selected\"": ''; ?> >Georgia</option>
		<option value="HI" <?php echo ($selection == 'HI') ? "selected=\"selected\"": ''; ?> >Hawaii</option>
		<option value="ID" <?php echo ($selection == 'ID') ? "selected=\"selected\"": ''; ?> >Idaho</option>
		<option value="IL" <?php echo ($selection == 'IL') ? "selected=\"selected\"": ''; ?> >Illinois</option>
		<option value="IN" <?php echo ($selection == 'IN') ? "selected=\"selected\"": ''; ?> >Indiana</option>
		<option value="IA" <?php echo ($selection == 'IA') ? "selected=\"selected\"": ''; ?> >Iowa</option>
		<option value="KS" <?php echo ($selection == 'KS') ? "selected=\"selected\"": ''; ?> >Kansas</option>
		<option value="KY" <?php echo ($selection == 'KY') ? "selected=\"selected\"": ''; ?> >Kentucky</option>
		<option value="LA" <?php echo ($selection == 'LA') ? "selected=\"selected\"": ''; ?> >Louisiana</option>
		<option value="ME" <?php echo ($selection == 'ME') ? "selected=\"selected\"": ''; ?> >Maine</option>
		<option value="MD" <?php echo ($selection == 'MD') ? "selected=\"selected\"": ''; ?> >Maryland</option>
		<option value="MA" <?php echo ($selection == 'MA') ? "selected=\"selected\"": ''; ?> >Massachusetts</option>
		<option value="MI" <?php echo ($selection == 'MI') ? "selected=\"selected\"": ''; ?> >Michigan</option>
		<option value="MN" <?php echo ($selection == 'MN') ? "selected=\"selected\"": ''; ?> >Minnesota</option>
		<option value="MS" <?php echo ($selection == 'MS') ? "selected=\"selected\"": ''; ?> >Mississippi</option>
		<option value="MO" <?php echo ($selection == 'MO') ? "selected=\"selected\"": ''; ?> >Missouri</option>
		<option value="MT" <?php echo ($selection == 'MT') ? "selected=\"selected\"": ''; ?> >Montana</option>
		<option value="NE" <?php echo ($selection == 'NE') ? "selected=\"selected\"": ''; ?> >Nebraska</option>
		<option value="NV" <?php echo ($selection == 'NV') ? "selected=\"selected\"": ''; ?> >Nevada</option>
		<option value="NH" <?php echo ($selection == 'NH') ? "selected=\"selected\"": ''; ?> >New Hampshire</option>
		<option value="NJ" <?php echo ($selection == 'NJ') ? "selected=\"selected\"": ''; ?> >New Jersey</option>
		<option value="NM" <?php echo ($selection == 'NM') ? "selected=\"selected\"": ''; ?> >New Mexico</option>
		<option value="NY" <?php echo ($selection == 'NY') ? "selected=\"selected\"": ''; ?> >New York</option>
		<option value="NC" <?php echo ($selection == 'NC') ? "selected=\"selected\"": ''; ?> >North Carolina</option>
		<option value="ND" <?php echo ($selection == 'ND') ? "selected=\"selected\"": ''; ?> >North Dakota</option>
		<option value="OH" <?php echo ($selection == 'OH') ? "selected=\"selected\"": ''; ?> >Ohio</option>
		<option value="OK" <?php echo ($selection == 'OK') ? "selected=\"selected\"": ''; ?> >Oklahoma</option>
		<option value="OR" <?php echo ($selection == 'OR') ? "selected=\"selected\"": ''; ?> >Oregon</option>
		<option value="PA" <?php echo ($selection == 'PA') ? "selected=\"selected\"": ''; ?> >Pennsylvania</option>
		<option value="RI" <?php echo ($selection == 'RI') ? "selected=\"selected\"": ''; ?> >Rhode Island</option>
		<option value="SC" <?php echo ($selection == 'SC') ? "selected=\"selected\"": ''; ?> >South Carolina</option>
		<option value="SD" <?php echo ($selection == 'SD') ? "selected=\"selected\"": ''; ?> >South Dakota</option>
		<option value="TN" <?php echo ($selection == 'TN') ? "selected=\"selected\"": ''; ?> >Tennessee</option>
		<option value="TX" <?php echo ($selection == 'TX') ? "selected=\"selected\"": ''; ?> >Texas</option>
		<option value="UT" <?php echo ($selection == 'UT') ? "selected=\"selected\"": ''; ?> >Utah</option>
		<option value="VT" <?php echo ($selection == 'VT') ? "selected=\"selected\"": ''; ?> >Vermont</option>
		<option value="VA" <?php echo ($selection == 'VA') ? "selected=\"selected\"": ''; ?> >Virginia</option>
		<option value="WA" <?php echo ($selection == 'WA') ? "selected=\"selected\"": ''; ?> >Washington</option>
		<option value="WV" <?php echo ($selection == 'WV') ? "selected=\"selected\"": ''; ?> >West Virginia</option>
		<option value="WI" <?php echo ($selection == 'WI') ? "selected=\"selected\"": ''; ?> >Wisconsin</option>
		<option value="WY" <?php echo ($selection == 'WY') ? "selected=\"selected\"": ''; ?> >Wyoming</option>
	</select>
<?php
} // END usStates()