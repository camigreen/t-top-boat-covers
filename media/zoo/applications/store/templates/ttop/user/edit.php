<div class="ttop ttop-account-edit uk-grid">
	
		<div class="uk-width-1-1">
			<div class="uk-article-title uk-text-center">
				<?php echo $this->title; ?>
				<?php if($this->user->id) : ?>
					<div class="uk-article-lead"><?php echo $this->user->name.' | ID: '.$this->user->id; ?></div>
				<?php endif; ?>
			</div>
		</div>

			<div class="uk-width-1-1 uk-margin">
				<div class="uk-grid menu-buttons">
					<div class="uk-width-1-6">
			    		<button class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom" data-task="apply">Save</button>
			    	</div>
			    	<div class="uk-width-1-6">
			    		<button class="uk-width-1-1 uk-button uk-button-primary uk-margin-small-bottom" data-task="save">Save and Close</button>
			    	</div>
			    	<div class="uk-width-1-6">
			    		<button class="uk-width-1-1 uk-button uk-button-primary uk-margin-small-bottom" data-task="save2new">Save and New</button>
			    	</div>
			    	<div class="uk-width-1-6">
			    		<button class="uk-width-1-1 uk-button uk-button-default uk-margin-small-bottom" data-task="cancel">Cancel</button>
			    	</div>
		    	</div>
			</div>
			<div class="uk-width-2-10 side-bar">
				<div class="uk-grid" uk-grid-margin>
					<div class="uk-grid-margin-1-1 uk-text-small">
						<div>Created:</div>
						<div class="uk-text-muted"><?php echo $this->profile->created == null ? JText::_('Not created') : $this->app->html->_('date', $this->profile->created, JText::_('DATE_FORMAT_LC2'), $this->app->date->getOffset()); ?></div>
						<div>Created By:</div>
						<div class="uk-text-muted"><?php echo $this->app->user->get($this->profile->created_by)->name; ?></div>
						<div>Modified:</div>
						<div class="uk-text-muted"><?php echo $this->profile->modified == null ? JText::_('Not modified') : $this->app->html->_('date', $this->profile->modified, JText::_('DATE_FORMAT_LC2'), $this->app->date->getOffset()); ?></div>
						<div>Modified By:</div>
						<div class="uk-text-muted"><?php echo $this->app->user->get($this->profile->modified_by)->name; ?></div>

					</div>
					<div class="uk-width-1-1 menu-buttons uk-margin-top">
						
						
						
						
					</div>
				</div>
				
			</div>
			<div class="uk-width-8-10">
				<div class="uk-width-1-1">
					<form id="account_admin_form" class="uk-form" method="post" action="<?php echo $this->baseurl; ?>" enctype="multipart/form-data">
							<?php $this->form->setValues($this->user); ?>
							<?php $this->form->setValue('status',$this->profile->status); ?>
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
											if($this->app->session->get('user')->id == $this->user->id || !$this->user->id) {
												echo $this->form->render('password');
											} else {
												echo '<button id="resetPWD" class="uk-width-1-3 uk-button uk-button-primary uk-margin" data-task="resetPassword">Reset Password</button>';
											}
										?>
									</fieldset>
								</div>
							<?php endif; ?>
							<?php $this->form->setValues($this->profile->elements); ?>
							<?php if($this->form->checkGroup('contact')) : ?>
								<div class="uk-form-row">
									<fieldset id="contact">
										<legend>Contact Info</legend>
										<?php echo $this->form->render('contact')?>
									</fieldset>
								</div>
							<?php endif; ?>
							<?php $this->form->setValue('account', ($this->account ? $this->account->id : 0)); ?>
							<?php if($this->form->checkGroup('elements')) : ?>
								<div class="uk-form-row">
									<fieldset id="elements">
										<legend>User Assignments</legend>
										<?php echo $this->form->render('elements')?>
									</fieldset>
								</div>
							<?php endif; ?>
						<input type="hidden" name="task" value="apply" />
						<input type="hidden" name="uid" value="<?php echo $this->profile->id; ?>" />
						<input type="hidden" name="elements[type]" value="<?php echo $this->profile->type; ?>" />
						<?php echo $this->app->html->_('form.token'); ?>
					</form>
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
</div>