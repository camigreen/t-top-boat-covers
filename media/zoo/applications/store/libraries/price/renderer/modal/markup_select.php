<?php
$markupList = $price->getMarkupList();
$markupHTML = array();
foreach($markupList as $value) {
	if($value['default']) {
		$markup = $value['markup'];
	}
	$markupHTML[] = '<li><label><input id="mus-'.($value['markup']*100).'" name="markup_select" type="radio" value="'.$value['markup'].'"/>'.$value['formatted'].' '.$value['text'].'(+'.$this->app->number->currency($value['diff'],array('currency' => 'USD')).')</label></li>';
}
?>

<article class="uk-article">
	<p class="uk-article-title">Pricing Options</p>
	<p class="uk-article-lead">These are the current pricing options.</p>
	<div class="uk-h4">Dealer Price</div>
	<div><?php echo $this->app->number->currency($price->discount, array('currency' => 'USD')); ?></div>
	<div class="uk-h4">MSRP</div>
	<div><?php echo $this->app->number->currency($price->retail, array('currency' => 'USD')); ?></div>
	<div class="uk-h4">Choose your markup</div>
	<div>
		<ul class="uk-list">
			<?php echo implode("\n", $markupHTML); ?>
		</ul>
	</div>
</article>