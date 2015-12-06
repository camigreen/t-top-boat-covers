<div class="ttop ttop-account-select-type">
	<div class="uk-width-1-1">
		<div class="uk-article-title uk-text-center uk-margin-bottom">
			<?php echo $this->title; ?>
		</div>
	</div>
	<ul class="uk-grid uk-grid-width-1-4 uk-text-center" data-uk-margin>
	    <li><button class="uk-button uk-button-primary uk-width-1-1" data-type="dealership">Dealership</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-1" data-type="user.dealership">Dealership User</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-1" data-type="oem">OEM</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-1" data-type="user.oem" disabled>OEM User</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-1" data-type="user.employee" disabled>Employee</button></li>
	</ul>
	<form id="account_type" method="post" action="<?php echo $this->baseurl; ?>">
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="type" value="default" />
	</form>
	<script>
		jQuery(function($) {

			$(document).ready(function(){
				$('ul button').on('click', function(e) {
					var form = $('#account_type');
					var target = $(e.target);
					var type = target.data('type');
					form.find('input[name="type"]').val(type);
					form.submit();
				})
			})
		})
	</script>
</div>