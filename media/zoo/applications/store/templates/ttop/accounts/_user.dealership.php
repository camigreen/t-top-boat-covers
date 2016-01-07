<?php 
	$user = $this->account->getUser();
	$values = (array) $this->account;
	$values['email'] = $user->email;
	$values['username'] = $user->username;
	// var_dump($this->app->user->get());
	// echo 'Can Edit -> ' . ($this->app->customer->canEdit('com_zoo', $this->account->id) ? 'True' : 'False').'</br>';
	// echo 'Can EditState -> ' . ($this->app->customer->canEditState('com_zoo', $this->account->id) ? 'True' : 'False').'</br>';
	// echo 'Can Create -> ' . ($this->app->customer->canCreate('com_zoo', $this->account->id) ? 'True' : 'False').'</br>';
	// echo 'Can Delete -> ' . ($this->app->customer->canDelete('com_zoo', $this->account->id) ? 'True' : 'False').'</br>';
	// echo 'Can Access - 1 -> ' . ($this->app->customer->canAccess(1) ? 'True' : 'False').'</br>';
?>


<div class="ttop ttop-account-edit uk-grid">
	<div class="uk-width-1-1">
			<?php $this->form->setValues($values); ?>
			<?php if($this->form->checkGroup('details')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('details')?>
				</div>
			<?php endif; ?>
			<?php if($this->form->checkGroup('password')) : ?>
				<div class="uk-form-row">
					<?php 
						if($this->app->customer->canEditOwn('com_zoo',$this->account->id)) {
							echo $this->form->render('password');
						} else {
							echo '<button id="resetPWD" class="uk-width-1-3 uk-button uk-button-primary uk-margin" data-task="resetPassword">Reset Password</button>';
						}
					?>
				</div>
			<?php endif; ?>
			<?php if($this->form->checkGroup('notifications')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('notifications')?>
				</div>
			<?php endif; ?>
			<?php $this->form->setValues($this->account->elements); ?>
			<?php if($this->form->checkGroup('contact')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('contact')?>
				</div>
			<?php endif; ?>
			<?php 
				$values['parents'] = $this->account->getParents();
				$values['groups'] = $this->account->getUser()->getAuthorisedGroups();
				$this->form->setValues($values);
			?>
			<?php if($this->form->checkGroup('related')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('related')?>
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