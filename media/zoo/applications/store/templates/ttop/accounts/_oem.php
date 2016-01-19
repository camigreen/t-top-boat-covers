<?php $this->form->setValues($this->account); ?>
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
<?php $this->form->setValues($this->account->params); ?>
<?php if($this->form->checkGroup('settings')) : ?>
	<div class="uk-form-row">
		<?php echo $this->form->render('settings')?>
	</div>
<?php endif; ?>
<?php if($this->form->checkGroup('elements')) : ?>
	<div class="uk-form-row">
		<?php echo $this->form->render('elements')?>
	</div>
<?php endif; ?>
<?php $this->form->setValues($this->account); ?>
<?php if($this->form->checkGroup('parents')) : ?>
	<div class="uk-form-row">
		<?php echo $this->form->render('parents')?>
	</div>
<?php endif; ?>