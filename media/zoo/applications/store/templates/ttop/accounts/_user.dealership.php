<?php 
	$user = $this->account->getUser();
	$values = (array) $this->account;
	$values['email'] = $user->email;
	$values['username'] = $user->username;
	$cUser = $this->app->customer->canEdit('com_zoo.accounts');
	//var_dump($cUser);

		// get permission form
		$xml = simplexml_load_file($this->app->path->path('component.admin:/models/forms/permissions.xml'));

		$this->permissions = JForm::getInstance('com_zoo.new', $xml->asXML());
		$this->permissions->bind(array('asset_id' => $this->application->asset_id));
		echo str_replace('pane-sliders',  'pane-sliders zoo-application-permissions', $this->permissions->getInput('rules_orders'));

		//echo $this->app->field->render('permissions', 'permissions', $this->permissions, $xml);

	//echo $this->app->account->canEdit($cUser, 0, $this->account->id) ? 'Allowed' : 'Not Allowed';
?>


<div class="ttop ttop-account-edit uk-grid">
	<div class="uk-width-1-1">
			<?php $this->form->setValues($values); ?>
			<?php if($this->form->checkGroup('details')) : ?>
				<div class="uk-form-row">
					<fieldset id="details">
						<legend>Details</legend>
						<?php echo $this->form->render('details')?>
					</fieldset>
				</div>
			<?php endif; ?>
			<?php if($this->form->checkGroup('password')) : ?>
				<div class="uk-form-row">
					<fieldset id="password">
						<legend>Password</legend>
						<?php 
							if($this->app->user->isJoomlaAdmin($this->cUser)) {
								echo $this->form->render('password');
							} else {
								echo '<button id="resetPWD" class="uk-width-1-3 uk-button uk-button-primary uk-margin" data-task="resetPassword">Reset Password</button>';
							}
						?>
					</fieldset>
				</div>
			<?php endif; ?>
			<?php if($this->form->checkGroup('notifications')) : ?>
				<div class="uk-form-row">
					<fieldset id="notifications">
						<legend>Notifications</legend>
						<?php echo $this->form->render('notifications')?>
					</fieldset>
				</div>
			<?php endif; ?>
			<?php $this->form->setValues($this->account->elements); ?>
			<?php if($this->form->checkGroup('contact')) : ?>
				<div class="uk-form-row">
					<fieldset id="contact">
						<legend>Contact Info</legend>
						<?php echo $this->form->render('contact')?>
					</fieldset>
				</div>
			<?php endif; ?>
			<?php 
				$values['parents'] = $this->account->getParents();
				$values['groups'] = $this->account->getUser()->getAuthorisedGroups();
				$this->form->setValues($values);
			?>
			<?php if($this->form->checkGroup('related')) : ?>
				<div class="uk-form-row">
					<fieldset id="related">
						<legend>User Assignments</legend>
						<?php echo $this->form->render('related')?>
					</fieldset>
				</div>
			<?php endif; ?>
		<input type="hidden" name="[params]user" value="<?php echo $user->id; ?>" />
		<?php echo $this->app->html->_('form.token'); ?>
		<script>
			jQuery(function($) {

				$(document).ready(function(){
					$('button').on('click', function(e) {
						e.preventDefault();
						var task = $(e.target).data('task');
						var form = document.getElementById('account_admin_form');
						form.task.value = task;
						var button = document.createElement('input');
						button.style.display = 'none';
						button.type = 'submit';

						form.appendChild(button).click();

						//form.removeChild(button);
					})
				})
			})
		</script>
	</div>
</div>