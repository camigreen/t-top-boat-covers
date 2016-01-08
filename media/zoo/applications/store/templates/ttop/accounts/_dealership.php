<?php $this->form->setValues($this->account); ?>
<?php $this->form->setValue('account_number', $this->account->elements->get('account_number')); ?>
<?php if($this->form->checkGroup('details')) : ?>
	<div class="uk-form-row">
		<?php echo $this->form->render('details')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('poc.')); ?>
<?php if($this->form->checkGroup('poc')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('poc')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('billing.')); ?>
<?php if($this->form->checkGroup('billing')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('billing')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->elements->get('shipping.')); ?>
<?php if($this->form->checkGroup('shipping')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('shipping')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account->params); ?>
<?php if($this->form->checkGroup('settings')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('settings')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account); ?>
<?php if($this->form->checkGroup('users')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('users')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account); ?>
<?php if($this->form->checkGroup('subaccounts')) : ?>
	<div class="uk-form-row">
			<?php echo $this->form->render('subaccounts')?>
	</div>
<?php endif; ?>