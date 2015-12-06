<table class='uk-table shipping'>
    <thead>
        <tr>
            <th>Ship To:</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p><?php echo $shipping->get('firstname').' '.$shipping->get('lastname'); ?></p>
                <p><?php echo $shipping->get('address'); ?></p>
                <p><?php echo $shipping->get('city').', '.$shipping->get('state').'  '.$shipping->get('zip'); ?></p>
                <p><?php echo $shipping->get('phoneNumber'); ?></p>
                <p><?php echo $shipping->get('faxNumber'); ?></p>
            </td>
        </tr>
    </tbody>
</table>