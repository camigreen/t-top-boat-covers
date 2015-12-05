<?php


class Ups_Ups extends Ups_Base {
	
	private $available_apis = array(
		'rates' => array(
            'file' => 'LiveRates.php',
            'class' => 'Ups_LiveRates'
        )
	);
	
	public function __construct($data, $load_apis = FALSE)
	{
		parent::__construct($data);
		
		$this->load();
	}
	
	public function load($apis = FALSE)
	{
		if(!$apis)
		{
			$apis = $this->available_apis;
		}
		
		foreach($apis as $obj => $fileInfo)
		{
			require_once($fileInfo['file']);
			
			$params = array();
			
			foreach(get_object_vars($this) as $index => $value)
			{
				if(!in_array($index, array('available_apis')))
				{
					$params[$index] = $value;
				}
			}
			
			$this->$obj = new $fileInfo['class']($params);
		}
	}
}