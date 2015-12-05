<?php
$total = 0;
$filter = $this->app->request->get('filter','string','all');
$order_number = $this->app->request->get('order_number','string',null);
?>
<div class="">
	<div class="uk-article-title uk-text-center">
		<?php echo $this->title; ?>
	</div>
</div>
<div class="uk-width-1-1">
	<form id="order_search" class="uk-form" >
		<select name="filter">
			<option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Orders</option>
			<option value="active" <?php echo $filter == 'active' ? 'selected' : ''; ?>>Active Orders</option>
			<option value="closed" <?php echo $filter == 'closed' ? 'selected' : ''; ?>>Closed Orders</option>
		</select>
		<input type="text" name="order_number" placeholder="Order Number" value="<?php echo $order_number; ?>"/>
		<input type="submit" class="uk-button uk-button-primary" value="Search"/>
	</form>
</div>

<div class="uk-width-1-1">
	<table class="uk-table uk-table-condensed uk-table-striped uk-table-hover order-table">
		<thead>
			<tr>
				<th class="uk-width-1-10"></th>
				<th class="uk-text-center uk-width-1-10" >ID</th>
				<th class="uk-width-2-10">Date</th>
				<th class="uk-width-1-10">Transaction ID</th>
				<th class="uk-width-2-10">Rep</th>
				<th class="uk-width-2-10">Status</th>
				<th class="uk-width-1-10">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php if($this->record_count <= 0) : ?>
				<tr><td colspan="7" class="uk-text-center">No Orders Found!</td></tr>
			<?php endif; ?>
			<?php foreach($this->orders as $order) : ?>
			<tr class="<?php echo $order->isOverdue() ? 'overdue' : ''; ?>">
				<td class="uk-text-center" ><a class="uk-button uk-button-primary" href="orders/all-orders?task=order&id=<?php echo $order->id; ?>">View</a></td>
				<td><?php echo $order->id; ?></td>
				<td><?php echo $order->getOrderDate(); ?></td>
				<td><?php echo $order->transaction_id; ?></td>
				<td><?php echo $order->getSalesperson(); ?></td>
				<td><?php echo $order->getStatus(); ?></td>
				<td><?php echo $this->app->number->currency($order->total,array('currency' => 'USD')); ?></td>
				<?php $total += $order->total; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" class="uk-text-right">Total:</td>
				<td class="uk-text-center"><?php echo $this->app->number->currency($total,array('currency' => 'USD')); ?></td>
			</tr>
		</tfoot>
	</table>
</div>

<script>
jQuery(function($) {
	$(document).ready(function(){
		$('[name="filter"]').on('change',function(e){
			console.log('changed');
			$('#order_search').submit();
		})
	})
})
</script>