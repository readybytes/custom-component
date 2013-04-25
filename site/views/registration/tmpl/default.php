<?php

/**
 * @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @contact		bhavya@readybytes.in
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<script>
//add 
jqueryQueue.push('$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();');
</script>

<form class="form-horizontal" id="register" action="<?php echo JURI::current();?>" method="post">
	<fieldset>
		<div id="legend" class="">
			<legend class="">Register</legend>
		</div>

		<div class="control-group">
			<label class="control-label">I am a </label>
			<div class="controls">
				<select class="input-xlarge" name="profiletype">
					<option value="homeowner">Home Owner</option>
					<option value="professional">Professional</option>
					<option value="vendor">Vendor</option>
				</select>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Name</label>
			<div class="controls">
				<input name="name" placeholder="placeholder" class="input-xlarge" type="text">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="input01">Email</label>
			<div class="controls">
				<input name="email" placeholder="placeholder" class="input-xlarge" type="email">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="input01">Confirm Email</label>
			<div class="controls">
				<input placeholder="placeholder" class="input-xlarge" type="email" data-validation-match-match="email" >
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Mobile</label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on">+91</span> 
					<input name="mobile" class="span2" placeholder="placeholder" id="prependedInput" type="text">
				</div>
			</div>
		</div>
<?php 
	require_once JPATH_ROOT.'/components/com_jxigallery/jxigallery/includes.php';
	$cities = JXiGalleryHelper::getCities();
?>
		<div class="control-group">
			<label class="control-label">City</label>
			<div class="controls">
				<select name="city" class="input-xlarge">
					<?php foreach($cities as $name =>$id):?>
					<option value="<?php echo $id?>"><?php echo $name?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>


		<div class="control-group">
			<div class="controls">
				<input type="hidden" name="register_save" value="1" />
				<button class="btn btn-success btn-large">Register Now</button>
			</div>
		</div>

	</fieldset>
</form>
