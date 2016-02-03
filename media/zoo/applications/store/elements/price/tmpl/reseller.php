<?php
$item = $params['item'];
$price = $item->getPrice();

?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->precision($price->get('markup'), 2); ?></span>
	<a id="price_display-<?php echo $item->id; ?>" href="#"class="uk-icon-button uk-icon-info-circle uk-text-top" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
	<input type="hidden" name="markup" data-name="Markup" value="<?php echo $price->getMarkupRate(); ?>" />
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#price_display-<?php echo $item->id; ?>').on('click', function(e) {
				var modal;
				var StoreItem = $("#storeOrderForm").StoreItem('getItem',<?php echo $item->id; ?>);
				console.log(StoreItem);
				$.ajax({
	                type: 'POST',
	                url: "?option=com_zoo&controller=store&task=priceMarkupModal&format=json",
	                data: {item: StoreItem},
	                success: function(data){
	                	UIkit.modal.confirm(data.html, function(){
							$('input[name="markup"]').val($('input:radio[name="markup_select"]:checked').val());
							$('#storeOrderForm').StoreItem('setMarkup',[StoreItem.id,$('input:radio[name="markup_select"]:checked').val()]);
							$('#storeOrderForm').StoreItem('_publishPrice',StoreItem.id);
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