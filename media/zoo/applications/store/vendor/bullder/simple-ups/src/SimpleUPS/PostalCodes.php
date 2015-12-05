<?php namespace SimpleUPS;

class PostalCodes {
	private $US = array(
		'AL'=>'Alabama',
		'AK'=>'Alaska',
		'AZ'=>'Arizona',
		'AR'=>'Arkansas',
		'CA'=>'California',
		'CO'=>'Colorado',
		'CT'=>'Connecticut',
		'DE'=>'Delaware',
		'DC'=>'District Of Columbia',
		'FL'=>'Florida',
		'GA'=>'Georgia',
		'HI'=>'Hawaii',
		'ID'=>'Idaho',
		'IL'=>'Illinois',
		'IN'=>'Indiana',
		'IA'=>'Iowa',
		'KS'=>'Kansas',
		'KY'=>'Kentucky',
		'LA'=>'Louisiana',
		'ME'=>'Maine',
		'MD'=>'Maryland',
		'MA'=>'Massachusetts',
		'MI'=>'Michigan',
		'MN'=>'Minnesota',
		'MS'=>'Mississippi',
		'MO'=>'Missouri',
		'MT'=>'Montana',
		'NE'=>'Nebraska',
		'NV'=>'Nevada',
		'NH'=>'New Hampshire',
		'NJ'=>'New Jersey',
		'NM'=>'New Mexico',
		'NY'=>'New York',
		'NC'=>'North Carolina',
		'ND'=>'North Dakota',
		'OH'=>'Ohio',
		'OK'=>'Oklahoma',
		'OR'=>'Oregon',
		'PA'=>'Pennsylvania',
		'RI'=>'Rhode Island',
		'SC'=>'South Carolina',
		'SD'=>'South Dakota',
		'TN'=>'Tennessee',
		'TX'=>'Texas',
		'UT'=>'Utah',
		'VT'=>'Vermont',
		'VA'=>'Virginia',
		'WA'=>'Washington',
		'WV'=>'West VirginiA',
		'WI'=>'Wisconsin',
		'WY'=>'Wyoming'
		);
	private $CA = array(
		'AB' => 'Alberta',
		'BC' => 'British Columbia'
		);

	public function getStates($country, $default = false) {
		if(isset($this->$country)) {
			$states = $this->$country;
			if ($default) {
				$placeholder['X'] = '-Select-';
				$states = array_merge($placeholder, $this->$country);
			}
			return $states;
		} else {
			return array('X' => '-Select-');
		}
	}	
}
?>
