<?php

?>
<div class="ttop ttop-account-search">
	<div class="uk-width-1-1">
		<div class="uk-article-title uk-text-center">
			<?php echo $this->title; ?>
		</div>
	</div>
	<form id="user_admin_form" method="post" action="<?php echo $this->baseurl; ?>">
	<div class="uk-width-1-1 uk-margin-bottom">
		<?php echo $this->app->button->render('add', '<span class="uk-icon uk-icon-plus-circle"></span>New User', $this->app->user->canCreate($this->cUser, 'com_users'), array('class' => 'uk-button-success'));  ?>	
	</div>

	<div class="uk-width-1-1">
		
		<table class="uk-table uk-table-condensed uk-table-striped uk-table-hover">
			<thead>
				<tr>
					<th></th>
					<th class="uk-width-2-10">Name</th>
					<th class="uk-width-2-10">E-Mail</th>
					<th class="uk-width-2-10">Account</th>
					<th class="uk-width-1-10">Type</th>
					<th class="uk-width-1-10">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($this->profiles) < 1) : ?>
					<tr><td colspan="7" class="uk-text-center">No Users Found!</td></tr>
				<?php endif; ?>
				<?php foreach($this->profiles as $profile) : ?>
				<tr id="<?php echo $profile->id; ?>">
					<td class="uk-text-center" >
						<?php echo $this->app->button->render('edit', 'Edit', $profile->canEdit($this->cUser));  ?>
						<?php echo $this->app->button->render('delete', 'Delete', $profile->canDelete($this->cUser));  ?>
						<?php echo $this->app->button->render('view', 'View');  ?>
					</td>
					<?php $user = $profile->getUser(); ?>
					<?php $account = $profile->getAccount(); ?>
					<td><?php echo $user->name; ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $account ? $account->name : null; ?></td>
					<td><?php echo Jtext::_('PROFILE_TYPE_'.$profile->type); ?></td>
					<td><?php echo $this->app->userprofile->getStatus($profile); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="uid" value="0" />
	</div>
	</form>
		<script>
			jQuery(function($) {

				$(document).ready(function(){

					$('button').on('click', function(e) {
						var button = $(e.target);
						$('[name="task"]').val(button.data('task'));
						$('[name="uid"]').val(button.closest('tr').prop('id'));
						$('form#user_admin_form').submit();

					})
				})
			})
		</script>
	
</div>