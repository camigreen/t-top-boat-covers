<?php 
	$xml = simplexml_load_file($this->app->path->path('component.admin:models/forms/permissions.xml'));
	$permissions = JForm::getInstance('com_zoo.new', $xml->asXML());
	$permissions->bind(array('asset_id' => 'com_zoo'));
	var_dump($permissions);
	var_dump($parent);
	echo 'Permissions';

	$html = $permissions->getInput('rules');

	//$html = str_replace('<ul class="nav nav-tabs">', '<ul class="uk-tabs uk-tabs-left" data-uk-tab="{connect: \'#permissions\'">', $html);
	//$html = str_replace('class="active"', 'class="uk-active"', $html);
	//$html = str_replace('<div class="tab-content">', '<ul id="permissions" class="uk-switcher">', $html);
	$doc = new DomDocument(); 
	$doc->loadHTML($html);
	//$xpath = new DOMXPath($doc);  

	// get li elements in the first ol in the div whose id is list
	//$nodes = $xpath->query('/*/ul');

	var_dump($doc->saveHTML());
	// change li elements to <li class='list'><div class='inline'>#####</div></li>
	// foreach ($nodes as $node) {
	//     $node->setAttribute('class', 'list');
	//     $number = $node->firstChild;
	//     $div = $doc->createElement('div');
	//     $div->setAttribute('class', 'inline');
	//     $div->appendChild($number);
	//     $node->appendChild($div);
	// }

	// get the new HTML
	// $html = $doc->saveHTML();
	//echo $html;

?>