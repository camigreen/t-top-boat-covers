<?php 

echo '<h3>Dealer Account Page</h3>';

// echo 'Users';
// var_dump($this->users);

echo 'Account';
var_dump($this->userprofile->getAccount());

// echo 'OEMs';
// var_dump($this->account->getSubAccount(2));

echo 'Can Create Orders: ';
echo $this->app->userprofile->canCreateOrders() ? 'True' : 'False';
echo '</br>Can Edit Orders: ';
echo $this->app->userprofile->canEditOrders() ? 'True' : 'False';
echo '</br>Can Delete Orders: ';
echo $this->app->userprofile->canDeleteOrders() ? 'True' : 'False';

$this->account = $this->userprofile->getAccount();

$poc = $this->account->getParam('poc');

?>
<div class="uk-width-1-1">
	<form class="uk-form" action="/admin/accounts?task=apply&aid=<?php echo $this->account->id; ?>" method="post"
		<input type="text" name="account[name]" value="<?php echo $this->account->name; ?>" />
		<input type="text" name="account[number]" value="<?php echo $this->account->number; ?>" />
		<input type="text" name="account[type]" value="<?php echo $this->account->type; ?>" />
		<?php echo $this->app->html->_('date', $this->account->created, JText::_('DATE_FORMAT_LC2'), $this->app->date->getOffset()); ?>
		<input type="text" name="created_by_name" value="<?php echo $this->app->user->get($this->account->created_by)->name; ?>" />
		<input type="hidden" name="account[created_by]" value="<?php echo $this->account->created_by; ?>" />
		<?php echo $this->app->html->_('date', $this->account->modified, JText::_('DATE_FORMAT_LC2'), $this->app->date->getOffset()); ?>
		<input type="text" name="account[modified_by]" value="<?php echo $this->app->user->get($this->account->modified_by)->name; ?>" />
		<input type="hidden" name="modified_by_name" value="<?php echo $this->account->modified_by; ?>" />
		<input type="text" name="account[params][terms]" value="<?php echo $this->account->params->get('terms', ''); ?>" />
		<input type="text" name="account[params][discount]" value="<?php echo $this->account->params->get('discount', ''); ?>" />
		<input type="text" name="account[params][poc][name]" value="<?php echo $poc->get('name',''); ?>" />
		<input type="text" name="account[params][poc][phone]" value="<?php echo $poc->get('phone',''); ?>" />
		<input type="text" name="account[params][poc][email]" value="<?php echo $poc->get('email',''); ?>" />
		<input type="text" name="account[params][poc][fax]" value="<?php echo $poc->get('fax',''); ?>" />
		<input type="submit" class="uk-button uk-button-primary" value="Save" />
	</form>
</div>