<style type="text/css">
#dx-auto-save-images{ width:650px; margin:20px 0;border:1px solid #ddd; background-color:#f7f7f7; padding:10px; }
</style>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br></div><h2>DX-auto-save-images 选项</h2>

	<div id="dx-auto-save-images">
		<form action="" method="post">
			<p><label>禁止缩略图：</label><input type="checkbox" name="tmb" value="yes" <?php checked( 'yes', $options['tmb'] );?>/> 是</p>
		<?php submit_button(); ?>
		</form>	
	</div>
	
	<div style="clear:both;"></div>
	
	<?php $this->form_bottom(); ?>

</div>