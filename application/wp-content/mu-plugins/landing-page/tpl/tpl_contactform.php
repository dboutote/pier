<?php global $DBDB_ContactForm; ?>

<form id="pubconform" class="pubconform clearfix text-left" method="post" action="" role="form">

	<fieldset class="clearfix first">
	
		<div class="form-group">
			<label class="control-label" for="pcname"><?php _e('Name');?><sup><small>*</small></sup></label>
			<div class="form-control-wrap clearfix">
				<input type="text" name="pcname" id="pcname" class="text form-control" value="<?php echo esc_attr( wp_unslash($DBDB_ContactForm->get_param('pcname')) ) ;?>" aria-required="true" />
			</div>
		</div> <!-- /.form-group -->
		
		<div class="form-group">
			<label class="control-label" for="pcemail"><?php _e('Email Address');?><sup><small>*</small></sup></label>
			<div class="form-control-wrap clearfix">
				<input type="text" name="pcemail" id="pcemail" class="text form-control" value="<?php echo esc_attr( wp_unslash($DBDB_ContactForm->get_param('pcemail')) ) ;?>" aria-required="true" />							
			</div>
		</div> <!-- /.form-group -->
			
	</fieldset>

	<fieldset class="clearfix">
	
		<div class="form-group">
			<label class="control-label" for="pcmessage"><?php _e('Message');?><sup><small>*</small></sup></label>
			<div class="form-control-wrap clearfix">
				<textarea name="pcmessage" id="pcmessage" class="textarea form-control" rows="10" aria-required="true"><?php echo wp_unslash( $DBDB_ContactForm->get_param('pcmessage')) ;?></textarea>								
			</div>
		</div> <!-- /.form-group -->
	</fieldset>

	<div class="form-group">		
		<div class="control-label">
			<?php wp_nonce_field('dbdb_pcontact','pc_nonce'); ?>
			<input type="hidden" name="action" value="setup_pub_contact" />
			<input type="hidden" name="util_action" value="process_pub_contact" />											
			<input type="text" value="" name="pctob" class="sr-only" />			
		</div>
		<div class="form-control-wrap">
			<div class="response contact-response"></div>
						
			<button type="submit" class="btn btn-primary btn-large text-uppercase" name="pccontact-submit" id="pccontact-submit"><?php esc_attr_e('Submit'); ?> <i class="fa fa-refresh fa-spin display-no loading"></i></button>				
			
		</div>
	</div> <!-- /.form-group -->

</form>