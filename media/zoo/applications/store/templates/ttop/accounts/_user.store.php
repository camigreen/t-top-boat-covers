<?php 
	$user = $this->account->getUser();
	$values = (array) $this->account;
	$values['email'] = $user->email;
	$values['username'] = $user->username;
	$store = $this->app->account->getStoreAccount();
	$this->app->customer->get();
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
						if($this->app->user->isJoomlaAdmin($this->cUser)) {
							echo $this->form->render('password');
						} else {
							echo '<button id="resetPWD" class="uk-width-1-3 uk-button uk-button-primary uk-margin" data-task="resetPassword">Reset Password</button>';
						}
					?>
				</div>
			<?php endif; ?>
			<?php $this->form->setValues($this->account->params); ?>
			<?php if($this->form->checkGroup('settings')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('settings')?>
				</div>
			<?php endif; ?>
			<?php $this->form->setValues($this->account->elements); ?>
			<?php if($this->form->checkGroup('contact')) : ?>
				<div class="uk-form-row">
					<?php echo $this->form->render('contact')?>
				</div>
			<?php endif; ?>
		<input type="hidden" name="params[user]" value="<?php echo $user->id; ?>" />
		<input type="hidden" name="related[parents][]" value="<?php echo $store->id; ?>" />
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