<?php 
	$xml = simplexml_load_file($this->app->path->path('component.admin:models/forms/permissions.xml'));
	$xml->fieldset->field->attributes()->section = 'orders';
	$xml->fieldset->field->attributes()->name = 'rules_orders';
	$permissions = JForm::getInstance('com_zoo.new', $xml->asXML());
	$permissions->bind(array('asset_id' => 'orders'));
	//var_dump($permissions);
	//var_dump($parent);
	//echo 'Permissions';
	//var_dump($this->app->zoo->getApplication());

	$html = $permissions->getInput('rules_orders');

	//$html = str_replace('<ul class="nav nav-tabs">', '<ul class="uk-tabs uk-tabs-left" data-uk-tab="{connect: \'#permissions\'">', $html);
	//$html = str_replace('class="active"', 'class="uk-active"', $html);
	//$html = str_replace('<div class="tab-content">', '<ul id="permissions" class="uk-switcher">', $html);
	$doc = new DomDocument(); 
	$doc->loadHTML($html);
	$xpath = new DOMXPath($doc);  

	// get li elements in the first ol in the div whose id is list
	$nodes = $xpath->query('//ul');
	// change li elements to <li class='list'><div class='inline'>#####</div></li>
	foreach ($nodes as $node) {
		$tabs = $node;
	    $node->setAttribute('class', 'uk-nav uk-nav-side');
	    $node->setAttribute('data-uk-switcher', '{connect:"#permissions"}');
	}

	
	$tabList = $doc->createElement('ul');
	$tabList->setAttribute('class', 'uk-switcher');
	$tabList->setAttribute('id', 'permissions');

	// get li elements in the first ol in the div whose id is list
	$nodes = $xpath->query('//div[@class="tab-content"]/div');
	// change li elements to <li class='list'><div class='inline'>#####</div></li>

	foreach ($nodes as $node) {
		$content = $doc->createElement('li');
		$content->setAttribute('id', $node->getAttribute('id'));
		$content->setAttribute('class', $node->getAttribute('class'));
		$content->appendChild($node);
		$tabList->appendChild($content);
	}
	// get li elements in the first ol in the div whose id is list
	$nodes = $xpath->query('//div[@class="tab-content"]');
	foreach($nodes as $node) {
		$doc->getElementByID('permissions-sliders')->removeChild($node);
	}
	
	$tabPanel = $doc->createElement('div');
	$tabPanel->setAttribute('class', 'uk-width-1-4');
	$tabPanel->appendChild($tabs);
	$tabContentPanel = $doc->createElement('div');
	$tabContentPanel->setAttribute('class', 'uk-width-3-4');
	$tabContentPanel->appendChild($tabList);

	$s = $doc->getElementByID('permissions-sliders');
	$s->appendChild($tabPanel);
	$s->appendChild($tabContentPanel);
	$s->setAttribute('class', 'uk-grid');

	// get li elements in the first ol in the div whose id is list
	$nodes = $xpath->query('*//li[@class="active"]');
	// change li elements to <li class='list'><div class='inline'>#####</div></li>
	foreach ($nodes as $node) {
	    $node->setAttribute('class', 'uk-active');
	}

	// get the new HTML
	$html = $doc->saveHTML();
	echo $html;

?>