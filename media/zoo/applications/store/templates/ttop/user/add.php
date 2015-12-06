<div class="ttop ttop-user-select-type">
	<div class="uk-width-1-1">
		<div class="uk-article-title uk-text-center uk-margin-bottom">
			<?php echo $this->title; ?>
		</div>
	</div>
	<form id="user_type" method="post" action="<?php echo $this->baseurl; ?>">
	<ul class="uk-grid uk-grid-width-1-3 uk-text-center">
	    <li><button class="uk-button uk-button-primary uk-width-1-2" data-type="employee">Employee</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-2" data-type="dealer">Dealer Employee</button></li>
	    <li><button class="uk-button uk-button-primary uk-width-1-2" data-type="customer" disabled>Customer</button></li>
	</ul>
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="type" value="default" />
	</form>
	<script>
		jQuery(function($) {

			$(document).ready(function(){
				$('button').on('click', function(e) {
					var button = $(e.target);
					$('[name="type"]').val(button.data('type'));
					$('form#user_type').submit();

				})
			})
		})
	</script>
</div>