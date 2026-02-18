
<?php 
	$db =& get_instance();
	$userdetails=$db->userdetails();
	$pro_setting = $this->Product_model->getSettings('productsetting');
	$vendor_setting = $this->Product_model->getSettings('vendor');
?>

<?php foreach($productlist as $product){ ?>
	<?php 
		$productLink = base_url('store/'. base64_encode($userdetails['id']) .'/product/'.$product['product_slug'] );
	?>
	<tr>
		<td class="text-center">
			<input name="product[]" class="list-checkbox" type="checkbox" id="check<?php echo $product['product_id'];?>" value="<?php echo $product['product_id'];?>" onclick="checkonly(this,'check<?php echo $product['product_id'];?>')">
			<?php if($product['product_type'] == 'downloadable'){ ?>
				<img src="<?= base_url('assets/images/download.png') ?>" width="20px" class='d-block'>
			<?php } ?>
		</td>
		<td class="white-space-normal">
			<div class="tooltip-copy">
				<span><?php echo $product['product_name'];?></span>
				<div> <small>
					<a target="_blank" href="<?= $productLink.'?preview=1' ?>"><?= __('admin.public_page') ?></a>
				</small></div>
			</div>
		</td>
		<td>
			<div class="tooltip-copy">
				<img width="50px" height="50px" src="<?php echo resize('assets/images/product/upload/thumb/'. $product['product_featured_image'] ,100,100) ?>" ><br>
			</div>
		</td>
		<td class="txt-cntr"><?php echo $product['seller_username'] ? $product['seller_username'] : __('admin.admin'); ?></td>
		<td class="txt-cntr"><?php echo c_format($product['product_price']); ?></td>
		<td class="txt-cntr"><?php echo $product['product_sku'];?></td>
		<td class="txt-cntr commission-tr">

			<?php 

				if($product['seller_id']){
		
					$seller = $this->Product_model->getSellerFromProduct($product['product_id']);
					$seller_setting = $this->Product_model->getSellerSetting($seller->user_id);

					$commnent_line = "";
					if($seller->affiliate_sale_commission_type == 'default'){ 
						if($seller_setting->affiliate_sale_commission_type == ''){
							$commnent_line .= __('admin.warning_default_commission_not_set');
						}
						else if($seller_setting->affiliate_sale_commission_type == 'percentage'){
							$commnent_line .= __('admin.percentage').' : '. (float)$seller_setting->affiliate_commission_value .'%';
						}
						else if($seller_setting->affiliate_sale_commission_type == 'fixed'){
							$commnent_line .= __('admin.fixed').' : '. c_format($seller_setting->affiliate_commission_value);
						}
					} else if($seller->affiliate_sale_commission_type == 'percentage'){
						$commnent_line .= __('admin.percentage').' : '. (float)$seller->affiliate_commission_value .'%';
					} else if($seller->affiliate_sale_commission_type == 'fixed'){
						$commnent_line .= __('admin.fixed').' : '. c_format($seller->affiliate_commission_value);
					} 

					echo '<b>'.__('admin.sale').'</b> : ' .$commnent_line;

					$commnent_line = "";
					if($seller->affiliate_click_commission_type == 'default'){ 
						$commnent_line .= c_format($seller_setting->affiliate_click_amount) ." ".__('admin.per')." ". (int)$seller_setting->affiliate_click_count ." ".__('admin.clicks');
					} else{
						$commnent_line .= c_format($seller->affiliate_click_amount) ." ".__('admin.per')." ". (int)$seller->affiliate_click_count ." ".__('admin.clicks');
					} 
					echo '<br><b>'.__('admin.click').'</b> : ' .$commnent_line;

					$commnent_line = '';
					if($seller->admin_click_commission_type == '' || $seller->admin_click_commission_type == 'default'){
						$commnent_line =  c_format($vendor_setting['admin_click_amount']) ." ".__('admin.per')." ". (int)$vendor_setting['admin_click_count'] ." ".__('admin.clicks');
					} else{ 
						$commnent_line =  c_format($seller->admin_click_amount) ." ".__('admin.per')." ". (int)$seller->admin_click_count ." ".__('admin.clicks');
					} 

					echo '<br><b>'.__('admin.admin_click').'</b> : ' .$commnent_line;

					$commnent_line = '';
					if($seller->admin_sale_commission_type == '' || $seller->admin_sale_commission_type == 'default'){ 
						if($vendor_setting['admin_sale_commission_type'] == ''){
							$commnent_line .= __('admin.warning_default_commission_not_set');
						}
						else if($vendor_setting['admin_sale_commission_type'] == 'percentage'){
							$commnent_line .= ' '. (float)$vendor_setting['admin_commission_value'] .'%';
						}
						else if($vendor_setting['admin_sale_commission_type'] == 'fixed'){
							$commnent_line .= ' '. c_format($vendor_setting['admin_commission_value']);
						}
					} else if($seller->admin_sale_commission_type == 'percentage'){
						$commnent_line .= ''. (float)$seller->admin_commission_value .'%';
					} else if($seller->admin_sale_commission_type == 'fixed'){
						$commnent_line .= ''. c_format($seller->admin_commission_value);
					} else {
						$commnent_line .= __('admin.warning_commission_not_set');
					} 

					echo '<br><b>'.__('admin.admin_sale').'</b> : ' .$commnent_line;
				} else {
			?>

				<b>Sale</b> : 
				<?php

					if($product['product_commision_type'] == 'default'){
						if($default_commition['product_commission_type'] == 'percentage'){
							echo $default_commition['product_commission']. "%";
						}
						else
						{
							echo c_format($default_commition['product_commission']);
						}
					}
					else if($product['product_commision_type'] == 'percentage'){
						echo $product['product_commision_value']. "%";
					}
					else{
						echo c_format($product['product_commision_value']);
					}
				?>
				
				<br> <b>Click</b> :
				<?php
			    	if($product['product_click_commision_type'] == 'default'){
						echo "<small>{$default_commition['product_noofpercommission']} ".__('admin.click_for')." "; 	
						echo c_format($default_commition['product_ppc']);
						echo "</small>";
					}
					else{
						echo "<small>{$product['product_click_commision_per']} ".__('admin.click_for')." : ";
						echo c_format($product['product_click_commision_ppc']) ."</small>";
					}
				?>
			<?php } ?>

			<?php 
				if($product['product_recursion_type']){
	           		if($product['product_recursion_type'] == 'custom'){
	           			if($product['product_recursion'] != 'custom_time'){
	           				echo '<br><b>'. __('admin.recurring') .' </b> : ' .  __('admin.'.$product['product_recursion']);
	           			} else {
	           				echo '<br><b>'. __('admin.recurring') .' </b> : '. timetosting($product['recursion_custom_time']);
	           			}
	           		} else{
						if($pro_setting['product_recursion'] == 'custom_time' ){
           					echo '<br><b>'. __('admin.recurring') .' </b> : '. timetosting($pro_setting['recursion_custom_time']);
						} else {
							echo '<br><b>'. __('admin.recurring') .' </b> : '.  __('admin.'.$pro_setting['product_recursion']);
						}
	           		}
	           	}
			?>
		</td>
		<td class="txt-cntr">
			<?php echo $product['order_count'];?> / 
			<?php echo c_format($product['commission']) ;?>
		</td>
		<td class="txt-cntr">
			<?php echo (int)$product['commition_click_count'] + (int)$product['commition_click_count_admin'];?> / 
			<?php echo c_format($product['commition_click']) ;?>
		</td>
		<td class="txt-cntr">
			<?php echo
				c_format((float)$product['commition_click'] + (float)$product['commission']);
			?>
		</td>
		<td class="txt-cntr">
			<?= product_status_on_store($product['on_store']) ?>	
			<?= product_status($product['product_status']) ?>	
		</td>
		<td class="txt-cntr no-wrap">
			<a class="btn btn-sm btn-primary" onclick="return confirm(<?= __('admin.are_you_sure_to_edit') ?>);" href="<?php echo base_url();?>admincontrol/updateproduct/<?php echo $product['product_id'];?>"><i class="fa fa-edit cursors" aria-hidden="true"></i></a>
			<?php if((int)$product['seller_id'] == 0 ){ ?>
				<a class="btn btn-sm btn-primary" href="<?php echo base_url('admincontrol/duplicateProduct');?>/<?php echo $product['product_id'];?>"><i class="fa fa-clone cursors" aria-hidden="true"></i></a>
			<?php } ?>
			<a class="btn btn-sm btn-primary" href="<?php echo base_url('admincontrol/productupload/'. $product['product_id']);?>"><i class="fa fa-image cursors"></i></a>
			<a class="btn btn-sm btn-primary" href="<?php echo base_url('admincontrol/videoupload/'. $product['product_id']);?>"><i class="fa fa-youtube cursors"></i></a>
			<span class="btn btn-sm btn-primary" data-social-share data-share-url="<?= $productLink ?>" data-share-title="<?= $product['product_name'];?>" data-share-desc="<?= $product['product_short_description'];?>"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
			<button class="btn btn-danger btn-sm delete-product" type="button" data-id="<?= $product['product_id'] ?>"> <i class="fa fa-trash"></i> </button>
		</td>
	</tr>
<?php } ?>