<table class='uk-table billing'>
    <thead>
        <tr>
            <th>Bill To:</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p><?php echo $billing->get('firstname').' '.$billing->get('lastname'); ?></p>
                <p><?php echo $billing->get('address'); ?></p>
                <p><?php echo $billing->get('city').', '.$billing->get('state').'  '.$billing->get('zip'); ?></p>
                <p><?php echo $billing->get('phoneNumber'); ?></p>
                <p><?php echo $billing->get('faxNumber'); ?></p>
            </td>
        </tr>
    </tbody>
</table>