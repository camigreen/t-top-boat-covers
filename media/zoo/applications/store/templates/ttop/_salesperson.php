<?php if($order->hasSalesperson()) : ?>
    <div class="uk-width-1-1 uk-margin-bottom">
        <fieldset id="salesperson">
            <div class="uk-grid" data-uk-margin>
                <div class="uk-width-1-1">
                    <legend>Salesperson Info</legend>
                </div>
                <div class="uk-width-1-3">
                    <label>Service Fee</label>
                    <select class="uk-width-1-1" name="service_fee" >
                        <option value='0' <?php echo $order->service_fee == 0 ? 'selected' : ''; ?>>No Fee</option>
                        <option value='0.01' <?php echo $order->service_fee == 0.01 ? 'selected' : ''; ?>>1%</option>
                        <option value='0.02' <?php echo $order->service_fee == 0.02 ? 'selected' : ''; ?>>2%</option>
                        <option value='0.03' <?php echo $order->service_fee == 0.03 ? 'selected' : ''; ?>>3%</option>
                    </select>
                </div>
                <div class="uk-width-1-3">
                    <label>Dealer Discount</label>
                    <select class="uk-width-1-1" name="discount" value="<?php echo $order->discount; ?>">
                        <option value='0' <?php echo $order->service_fee == 0 ? 'selected' : ''; ?>>Not a Dealer</option>
                        <option value='0.2' <?php echo $order->service_fee == 0.2 ? 'selected' : ''; ?>>20%</option>
                        <option value='0.25' <?php echo $order->service_fee == 0.25 ? 'selected' : ''; ?>>25%</option>
                        <option value='0.3' <?php echo $order->service_fee == 0.3 ? 'selected' : ''; ?>>30%</option>
                        <option value='0.35' <?php echo $order->service_fee == 0.35 ? 'selected' : ''; ?>>35%</option>
                    </select>
                </div>
            </div>
        </fieldset>
    </div>
    <?php endif; ?>  