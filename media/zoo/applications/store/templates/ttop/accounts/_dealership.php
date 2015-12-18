<?php $this->form->setValues($this->account); ?>
<?php $this->form->setValue('account_number', $this->account->elements->get('account_number')); ?>
<?php if($this->form->checkGroup('details')) : ?>
	<div class="uk-form-row">
		<fieldset id="details">
			<legend>Details</legend>
			<?php echo $this->form->render('details')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('poc.')); ?>
<?php if($this->form->checkGroup('poc')) : ?>
	<div class="uk-form-row">
		<fieldset id="poc">
			<legend>Point of Contact</legend>
			<?php echo $this->form->render('poc')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('billing.')); ?>
<?php if($this->form->checkGroup('billing')) : ?>
	<div class="uk-form-row">
		<fieldset id="billing">
			<legend>Billing Address</legend>
			<?php echo $this->form->render('billing')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('shipping.')); ?>
<?php if($this->form->checkGroup('shipping')) : ?>
	<div class="uk-form-row">
		<fieldset id="shipping">
			<legend>Shipping Address</legend>
			<?php echo $this->form->render('shipping')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->params); ?>
<?php if($this->form->checkGroup('settings')) : ?>
	<div class="uk-form-row">
		<fieldset id="elements">
			<legend>Account Settings</legend>
			<?php echo $this->form->render('settings')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account); ?>
<?php if($this->form->checkGroup('users')) : ?>
	<div class="uk-form-row">
		<fieldset id="users">
			<legend>Users</legend>
			<?php echo $this->form->render('users')?>
		</fieldset>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account); ?>
<?php if($this->form->checkGroup('subaccounts')) : ?>
	<div class="uk-form-row">
		<fieldset id="subaccounts">
			<legend>OEMS</legend>
			<?php echo $this->form->render('subaccounts')?>
			<?php echo $this->partial('applicationparams')?>
		</fieldset>
	</div>
<?php endif; ?>