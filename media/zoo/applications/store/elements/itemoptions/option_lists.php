<?php

$opts = array();

//  Item Global Options

$opts['global_options']['fabric'] = array(
    '7oz' => 'Material 7oz. 3yr. Warranty',
    '8oz' => 'Material 8oz. 5yr. Warranty',
    '9oz' => 'Material 9oz. 5yr. Warranty'
);
$opts['global_options']['ccc-fabric'] = array(
    '8oz' => 'Material 8oz. 5yr. Warranty',
    '9oz' => 'Material 9oz. 5yr. Warranty'
);

$opts['global_options']['t-top_type'] = array(
    'hard-top' => 'Hard Top',
    'canvas-top' => 'Lace On Canvas Top',
	'key-west' => 'Key West Style',
    'other' => 'Other'
);

$opts['global_options']['motors'] = array(
    '1' => 'Single Engine',
    '2' => 'Twin Engines',
    '3' => 'Triple Engines',
    '4' => 'Quadruple Engines',
    'other' => 'Other'
);
$opts['global_options']['motor_make'] = array(
    'evinrude' => 'Evinrude',
    'honda' => 'Honda',
    'johnson' => 'Johnson',
    'mercury' => 'Mercury',
    'suzuki' => 'Suzuki',
    'yamaha' => 'Yamaha',
    'other' => 'Other'
);
$opts['global_options']['motor_size'] = array(
    90 => '90 HP',
    115 => '115 HP',
    135 => '135 HP',
    150 => '150 HP',
    175 => '175 HP',
    200 => '200 HP',
    225 => '225 HP',
    250 => '250 HP',
    300 => '300 HP',
    350 => '350 HP',
    400 => '400 HP',
    557 => '557 HP',
    'other' => 'Other'
);
$opts['global_options']['bow_rails'] = array(
    'N' => 'No Rails',
    'R' => 'Recessed',
    'L' => 'Low - 8" or less',
    'H' => 'High - 9" or more',
    'WT' => 'Walkthrough',
    'other' => 'Other'
);

$opts['global_options']['zipper'] = array(
    'ZP' => 'Port Side',
    'ZS' => 'Starboard Side',
    'CR' => 'Center Rear(Twin Hulls Only)'
);

$opts['global_options']['color'] = array(
    'navy' => 'Navy',
    'black' => 'Black',
    'gray' => 'Grey',
    'tan' => 'Tan'
);
$opts['global_options']['storage'] = array(
    'T' => 'Trailer',
    'L' => 'Lift',
    'DS' => 'Dry Stack',
    'JD' => 'Jet Dock',
    'IW' => 'In Water',
    'other' => 'Other'
);
$opts['global_options']['bow_options'] = array(
    'N' => 'None',
    'BRW' => 'Bow Roller/Windless',
    'THA' => 'Thru Hull Anchor',
    'BP' => 'Bow Pulpit',
    'other' => 'Other'
);
$opts['global_options']['ski_tow_bar'] = array(
    'N' => 'None',
    'above' => 'Above the engine',
    'in_front' => 'In front of the engine',
    'other' => 'Other'
);
$opts['global_options']['activity_platform'] = array(
    'N' => 'None',
    'opt1' => 'Option 1',
    'opt2' => 'Option 2'
);
$opts['global_options']['trolling_motor'] = array(
    'y' => 'Yes',
    'n' => 'No',
    'r' => 'Removeable'
);
$opts['global_options']['power_poles'] = array(
    'N' => 'None',
    'PEB' => 'Port Side Engine Bracket Mount',
    'SEB' => 'Starboard Side Engine Bracket Mount',
    'DEB' => 'Dual Engine Bracket Mount',
    'PTM' => 'Port Side Transom Mount',
    'STM' => 'Starboard Side Transom Mount',
    'DTM' => 'Dual Transom Mount',
    'Other' => 'Other'
);
$opts['global_options']['jack_plate'] = array(
    'N' => 'None',
    'JP-4' => '4 inch',
    'JP-6' => '6 inch',
    'JP-8'  =>  '8 inch',
    'JP-10' =>  '10 inch',
    'JP-12' =>  '12 inch',
    'JP-14' =>  '14 inch'
);
$opts['global_options']['swim_ladder'] = array(
    'N' => 'None',
    'SL-I'  =>  'In-laid',
    'SL-R'  =>  'Removeable',
    'SL-P' => 'Platform',
    'other' => 'Other'
);
$opts['global_options']['beam_bsk'] = array(
    '0' => '6\' to 6\' 6”',
    '1' => '6\' 7" to 6\' 11”',
    '2' => '7\' to 7\' 6”',
    '3' => '7\' 7" to 7\' 11”',
    '4' => '8\' to 8\' 6”',
    '5' => '8\' 7" to 8\' 11”',
    '6' => '9\' to 9\' 6”',
    '7' => '9\' 7" to 9\' 11”',
    '8' => '10\' to 10\' 6”',
    'ubsk' => 'Greater than 10\' 6"',
);
$opts['global_options']['ttop_width_bsk'] = array(
    '0' => '4\' 6" to 4\' 11”',
    '1' => '5\' to 5\' 6”',
    '2' => '5\' 7" to 5\' 11”',
    '3' => '6\' to 6\' 6”',
    '4' => '6\' 7" to 6\' 11”',
    '5' => '7\' to 7\' 6”',
    'ubsk' => 'Greater than 7\'6"',
);
$opts['global_options']['ttop2rodholders_bsk'] = array(
    '0' => 'Less than 34”',
    'A' => '35” - 48”',
    'B' => '49” - 65”',
    'C' => '66” – 80”',
	'D' => 'Greater than 80"'
);
$opts['global_options']['boat_style'] = array(
    'CC' => 'Center Console',
    'DC' => 'Dual Console',
    'WA' => 'Walkaround',
    'CB' => 'Catamaran',
    'other' => 'Other'
);
$opts['global_options']['ubskboat_style'] = array(
    'SF' => 'Sport Fishing',
    'Y' => 'Yacht',
    'C' => 'Cruiser',
    'other' => 'Other'
);
$opts['global_options']['storagebag_size'] = array(
    'l' => 'Large - $30.00',
    'xl' => 'Extra Large - $45.00'
);
//  Item Attributes

$opts['attributes']['boat_length'] = array('18|19','20|22','23','24','25','26','27','28','29','30','31','32|34','35','36|37','38','33Freeman','37Freeman');



?>
