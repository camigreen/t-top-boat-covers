<?php
$item = $params['item'];
$price = $item->getPrice();
?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->precision($price->markup, 2); ?></span>
	<a id="price_display" href="#"class="uk-icon-button uk-icon-info-circle uk-text-top" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
	<input type="text" name="markup" data-name="Markup" value="<?php echo $price->getMarkupRate(); ?>" />
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#price_display').on('click', function(e) {
				var modal;
				var markup = $('[name="markup"]').val();
				$.ajax({
	                type: 'POST',
	                url: "?option=com_zoo&controller=store&task=priceMarkupModal&format=json",
	                data: {markup: markup},
	                success: function(data){
	                	UIkit.modal.confirm(data.html, function(){
							$('input[name="markup"]').val($('input:radio[name="markup_select"]:checked').val());
							$('#'+<?php echo $item->id; ?>).StoreItem('_publishPrice');
						});

	                	markup = data.markup*100;
	                	$('input#mus-'+markup).prop('checked', true);
	                },
	                error: function(data, status, error) {
	                	console.log('Error');
	                },
	                dataType: 'json'
            	});
            	
				
				
				
			})
		})
		
	})

</script>