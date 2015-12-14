<div class='uk-width-1-2'>
    <table class='uk-table billing'>
        <thead>
            <tr>
                <th>Bill To:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div><?php echo $elements->get('billing.name'); ?></div>
                    <div><?php echo $elements->get('billing.street1'); ?></div>
                    <div><?php echo $elements->get('billing.street2'); ?></div>
                    <div><?php echo $elements->get('billing.city').', '.$elements->get('billing.state').'  '.$elements->get('billing.postalCode'); ?></div>
                    <div><?php echo $elements->get('billing.phoneNumber'); ?></div>
                    <div><?php echo $elements->get('billing.altNumber'); ?></div>
                    <div><?php echo $elements->get('email'); ?></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>