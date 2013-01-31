<?php
$num_inputs = 0;

// data sent via post overides data stored in session since we want to be able to delete
// (we just replace the whole array with each save)
if($this->input->post('street'))
{
    $num_inputs = count($this->input->post('street')) - 1;
}
// data stored in session previously, so returning useragent
else if(isset($form_data))
{
    $num_inputs = count($form_data) - 1;
}
$attributes = array('id' => 'expandable_input');
echo form_open('expandable_input', $attributes);
echo validation_errors();
?>
<fieldset>
    <legend>Contact information for each office:</legend>
<?php
for($i = 0; $i <= $num_inputs; $i++):?>
    <fieldset class="addressDetails">
        <legend>Office <span class="office_num"><?php echo (1 + $i) . '/' . ($num_inputs + 1); ?></span>:</legend>
        <label>Street: </label>
        <input class="street" type="text" name="street[]" maxlength="256"
               value="<?php echo set_value('street[]', $form_data[$i]['street[]'])?>"  /> <span class="required">*</span><br />
        <label>Street2: </label>
        <input type="text" name="street2[]" maxlength="256" value="<?php echo set_value('street2[]', $form_data[$i]['street2[]']); ?>"  /><br />

        <label>Building/Room Number:</label>
        <input type="text" name="building_room_number[]" maxlength="70"
               value="<?php echo set_value('building_room_number[]', $form_data[$i]['building_room_number[]']); ?>"  /><br />

        <label>City: </label>
        <input class="city" type="text" name="city[]" maxlength="100" value="<?php echo set_value('city[]', $form_data[$i]['city[]']); ?>"  /> <span class="required">*</span><br />

        <label>State/Province: </label>
        <input type="text" name="province[]" maxlength="100" value="<?php echo set_value('province[]', $form_data[$i]['province[]']); ?>"  /><br />

        <label>Country: </label>
            <?php echo country_dropdown('country[]', Array('PICKONE','CA','CN','HK','ID','JP','MN','NP','KR','TW','TH','TR','VN'), set_value('country[]', $form_data[$i]['country[]']));
            // Returns a list of ALL countries, with the listed 12 shown at the top of the list	?> <span class="required">*</span><br />

        <label>Postal Code: </label>
        <input type="text" name="postal_code[]" maxlength="17" value="<?php echo set_value('postal_code[]', $form_data[$i]['postal_code[]']); ?>"  /><br />

        <label>Office Phone: </label>
        <input class="office_phone" type="text" name="office_phone[]" maxlength="20" value="<?php echo set_value('office_phone[]', $form_data[$i]['office_phone[]']); ?>"  /> <span class="required">*</span><br />

        <label>General Office Email: </label>
        <input class="general_office_email" type="text" name="general_office_email[]" maxlength="256" value="<?php echo set_value('general_office_email[]', $form_data[$i]['general_office_email[]']); ?>"  /> <span class="required">*</span><br />

        <label>Contact Name: </label>
        <input type="text" name="contact_name[]" maxlength="256" value="<?php echo set_value('contact_name[]', $form_data[$i]['contact_name[]']); ?>"  /><br />
    </fieldset>
<?php endfor; ?>

    <div class="save">
<?php echo form_submit( 'submit', 'Save Entered Data', 'id="submit" class="save_submitted_data"');?>
    </div>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/add_remove_fields.js"></script>