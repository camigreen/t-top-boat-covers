<div class='uk-width-1-2'>
	<table class='uk-table shipping'>
	    <thead>
	        <tr>
	            <th>Ship To:</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr>
	            <td>
	                <div><?php echo $elements->get('shipping.name'); ?></div>
	                <div><?php echo $elements->get('shipping.street1'); ?></div>
	                <div><?php echo $elements->get('shipping.street2'); ?></div>
	                <div><?php echo $elements->get('shipping.city').', '.$elements->get('shipping.state').'  '.$elements->get('shipping.postalCode'); ?></div>
	                <div><?php echo $elements->get('shipping.phoneNumber'); ?></div>
	                <div><?php echo $elements->get('shipping.altNumber'); ?></div>
	            </td>
	        </tr>
	    </tbody>
	</table>
</div>