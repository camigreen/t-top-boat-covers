<?php
	$item = $params['item'];
	$price = $item->getPrice();
	$group = $price->getGroup();
	$markup = 0;
	echo $this->app->renderer->create()->addPath(array($this->app->path->path('store.lib:/price')))->render('modal.markup_select');
	$discountHTML = '<div class="uk-h4">Dealer Price</div><div>'.$this->app->number->currency($price->discount, array('currency' => 'USD')).' ('.$price->getDiscountRate().' off of MSRP)</div>';
	$retailHTML = '<div class="uk-h4">MSRP</div><div>'.$this->app->number->currency($price->retail, array('currency' => 'USD')).'</div>';
	$markuplist = $price->getMarkupList();
	$markupHTML = '<div class="uk-h4">Choose your markup</div><div><ul class="uk-list">';
	foreach($markuplist as $value) {
		if($value['default']) {
			$markup = $value['markup'];
		}
		$markupHTML .= '<li><label><input id="mus-'.($value['markup']*100).'" name="markup_select" type="radio" value="'.$value['markup'].'"/>'.$value['formatted'].' '.$value['text'].'(+'.$this->app->number->currency($value['diff'],array('currency' => 'USD')).')</label></li>';
	}
	$markupHTML .= '</ul></div>';


?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->precision($price->markup, 2); ?></span>
	<a id="price_display" href="#"class="uk-icon-button uk-icon-info-circle uk-text-top" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
	<input type="hidden" name="markup" data-name="Markup" value="<?php echo $markup; ?>" />
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#price_display').on('click', function(e) {
				var select = $('<select name="price_display_select" />').append('<option value="retail">MSRP</option>').append('<option value="discount">Dealer Price</option>');
				select.val('discount').change();
				var modal = $('<article class="uk-article" />')
					.append('<p class="uk-article-title">Pricing Options</p>')
					.append('<p class="uk-article-lead">These are the current pricing options.</p>')
					.append('<?php echo $discountHTML; ?>')
					.append('<?php echo $retailHTML; ?>')
					.append('<?php echo $markupHTML; ?>')
					.append('<hr class="uk-article-divider">');
				var markup = $('#'+<?php echo $item->id; ?>).StoreItem('_getPricing').markup*100;
				
				UIkit.modal.confirm(modal.prop('outerHTML'), function(){
					$('input[name="markup"]').val($('input:radio[name="markup_select"]:checked').val());
					$('#'+<?php echo $item->id; ?>).StoreItem('_publishPrice');
				});
				$('input#mus-'+markup).prop('checked', true);
			})
		})
		
	})

</script>