<?php
	$db =& get_instance();
	$userdetails=$db->userdetails();
	$store_setting =$db->Product_model->getSettings('store');
	$Product_model =$db->Product_model;
?>

<?php include(APPPATH.'/views/admincontrol/includes/store.php'); ?>
<br>

<div id="overlay"></div>
<div class="popupbox" style="display: none;">
	<div class="backdrop box">
		<div class="modalpopup" style="display:block;">
			<a href="javascript:void(0)" class="close js-menu-close" onclick="closePopup();"><i class="fa fa-times"></i></a>
			<div class="modalpopup-dialog">
				<div class="modalpopup-content">
					<div class="modalpopup-body">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<?php if($this->session->flashdata('success')){?>
			<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $this->session->flashdata('success'); ?> </div>
		<?php } ?>
		<?php if($this->session->flashdata('error')){?>
			<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php echo $this->session->flashdata('error'); ?> </div>
		<?php } ?>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-body">
				<b>Store URL</b>
				<div class="row top-panel">
					<span class="m-b-5">
						<div class="share-store-list">
							<a class="btn btn-lg btn-default btn-success" href="<?php echo base_url("admincontrol/addproduct") ?>"><?= __('admin.add_product') ?></a>
							<a class="btn btn-lg btn-default btn-success" href="<?php echo base_url("admincontrol/form_manage") ?>"><?= __('admin.add_form') ?></a>
							<a class="btn btn-lg btn-default btn-success" href="javascript:void(0)" data-toggle="modal" data-target="#manageBulkProducts"><?= __('admin.manage_bulk_products') ?></a>
						</div>
					</span>
					<div id="manageBulkProducts" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= __('admin.manage_bulk_products') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6 text-center">
            							<button class="btn btn-lg btn-default btn-success text-center export-products-btn"><?= __('admin.export_products') ?></button>
                                    </div>
                                    <div class="col-6 text-center">
            							<button class="btn btn-lg btn-default btn-success text-center export-structure-btn"><?= __('admin.export_structure_only') ?></button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col">
                                    <form id="bulk_products_form" class="text-center">
                                        <div class="custom-file my-3">
                                          <input type="file" class="custom-file-input" name="file">
                                          <label class="custom-file-label" for="customFile"><?= __('admin.upload_excel_file_for_bulk_product_manage') ?></label>
                                        </div>
                                        <button id="bulk_products_form_btn" type="submit" class="btn btn-lg btn-default btn-success text-center"><?= __('admin.import_products') ?></button><br/><br/>
                                        <a class="mb-4" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseInstructions" aria-expanded="false" aria-controls="collapseInstructions"><?= __('admin.click_here_for_excel_file_upload') ?></a>
                                        <div class="collapse" id="collapseInstructions">
                                          <div class="card card-body text-left" style="max-height: 300px; overflow-y: scroll">
                                              <table class="table table-stripped">
                                                  <thead>
                                                      <tr>
                                                          <td><?= __('admin.column') ?></td>
                                                          <td><?= __('admin.description') ?></td>
                                                      </tr>
                                                  </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= __('admin.product_id') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_product_id_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_id_desc_2') ?></li>
                                                                    <li><?= __('admin.ip_product_id_desc_3') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_name') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_name_desc_1') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_sku') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_sku_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_sku_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_msrp') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_product_msrp_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_msrp_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_price') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_price_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_price_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_short_desc') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_short_desc_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_short_desc_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_desc') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_desc_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_desc_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_tag') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_product_tag_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_tag_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_type') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_type_disc_1') ?> "virtual", "downloadable"</li>
                                                                    <li><?= __('admin.ip_product_type_disc_2') ?>/</li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_variations') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_product_variations_desc_1') ?></li>
                                                                <ul>
                                                                <pre style="overflow: visible;">
{
    "colors":[
        {"code":"#FF0000","name":"Red","price":"10"},
        {"code":"#3014FF","name":"Blue","price":"15"}
    ],
    "size":[
        {"name":"Horizontal 56","price":"10"},
        {"name":"Horizontal 112","price":"15"}
    ]
}
                                                                <pre>
                                                                    <ul>
                                                                        <li><?= __('admin.ip_product_variations_desc_2') ?></li>
                                                                    </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.allow_comment') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_allow_comment_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_allow_comment_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.allow_shipping') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_allow_shipping_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_allow_shipping_desc_2') ?>t</li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.allow_file_uplolad') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_allow_file_uplolad_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_allow_file_uplolad_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_status') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_product_status_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_status_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.allow_on_store') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.required') ?></li>
                                                                    <li><?= __('admin.ip_allow_on_store_desc_1') ?>)</li>
                                                                    <li><?= __('admin.ip_allow_on_store_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.state_id') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_state_id_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_state_id_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= __('admin.product_created_by') ?></td>
                                                            <td>
                                                                <ul>
                                                                    <li><?= __('admin.optional') ?></li>
                                                                    <li><?= __('admin.ip_product_created_by_desc_1') ?></li>
                                                                    <li><?= __('admin.ip_product_created_by_desc_2') ?></li>
                                                                <ul>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                              </table>
                                          </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    <div id="manageBulkProductsConfirmation" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= __('admin.manage_bulk_product_confirmation') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:350px; overflow-y:scroll;">
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-default btn-success text-center import-products-confirm"><?= __('admin.confirm_product_import') ?></button>
                                <button class="btn btn-lg btn-default btn-success text-center" data-dismiss="modal"><?= __('admin.cancel') ?></button>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <div id="manageBulkProductsResult" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= __('admin.manage_bulk_product_result') ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:350px; overflow-y:scroll;">
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-default btn-success text-center" onclick="window.location.reload()"><?= __('admin.ok') ?></button>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    
					<span class="m-b-5" style="width: 400px;">
						<?php $store_url = base_url('store'); ?>
						<div class="input-group">
							<input type="text" id="store-link" readonly="readonly" value="<?php echo $store_url ?>" class="form-control">
							<button onclick="copy_text()" class="input-group-addon">
								<img src="<?php echo base_url('assets/images/clippy.svg') ?>" class="tooltiptext" width="25px" height="25px" alt="<?= __('admin.copy_to_clipboard') ?>">
							</button>
						</div>
					</span>
					<span class="m-b-5">
						<div class="share-store-list">
							<a class="btn btn-lg btn-default btn-success" href="<?php echo $store_url ?>" target="_blank"><?= __('admin.priview_store') ?></a>
						</div>
					</span>
					<span>
						<button style="display:none;" type="button" class="btn btn-lg btn-danger" name="deletebutton" id="deletebutton" value="<?= __('admin.save_exit') ?>" onclick="deleteuserlistfunc('deleteAllproducts');"><?= __('admin.delete_products') ?></button>
					</span>
				</div>
				<br>

				<div class="filter">
					<form id="filter-form">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label"><?= __('admin.category') ?></label>
									<select name="category_id" class="form-control">
										<?php $selected = isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>
										<option value=""><?= __('admin.all_category') ?></option>
										<?php foreach ($categories as $key => $value) { ?>
											<option <?= $selected == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label"><?= __('admin.vendor') ?></label>
									<select name="seller_id" class="form-control">
										<?php $selected = isset($_GET['seller_id']) ? $_GET['seller_id'] : ''; ?>
										<option value=""><?= __('admin.all_vendor') ?></option>
										<?php foreach ($vendors as $key => $value) { ?>
											<option <?= $selected == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>	
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label d-block">&nbsp;</label>
									<button type="submit" class="btn btn-primary"><?= __('admin.search') ?></button>
								</div>
							</div>	
						</div>
					</form>
				</div>
				
			    <?php if ($productlist == null) {?>
                    <div class="text-center">
                    <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:100px;">
                 	<h3 class="m-t-40 text-center text-muted"><?= __('admin.no_products') ?></h3></div>
                <?php } else { ?>
                	<div class="table-responsive b-0" data-pattern="priority-columns">
						<form method="post" name="deleteAllproducts" id="deleteAllproducts" action="<?php echo base_url('admincontrol/deleteAllproducts'); ?>">
							<table id="tech-companies-1" class="table  table-striped">
								<thead>
									<tr>
										<th><input name="product[]" type="checkbox" value="" onclick="checkAll(this)"></th>
										<th width="220px"><?= __('admin.product_name') ?></th>
										<th><?= __('admin.featured_image') ?></th>
										<th><?= __('admin.vendor_name') ?></th>
										<th><?= __('admin.price') ?></th>
										<th><?= __('admin.sku') ?></th>
										<th width="220px"><?= __('admin.get_ncommission') ?></th>
										<th><?= __('admin.sales_/_commission') ?></th>
										<th><?= __('admin.clicks_/_commission') ?></th>
										<th><?= __('admin.total') ?></th>
										<th><?= __('admin.status') ?></th>
										<th><?= __('admin.action') ?></th>
									</tr>
								</thead>
								<tbody></tbody>
								<tfoot>
									<tr>
										<td colspan="12" class="text-right">
											<ul class="pagination pagination-td"></ul>
										</td>
									</tr>
								</tfoot>
							</table>
						</form>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?= $social_share_modal ?>

<script type="text/javascript" async="">

    $temp_import_product_data = null;

    $('#bulk_products_form_btn').on('click', function(e){ 
        e.preventDefault();
        $("#bulk_products_form .alert-danger").remove();
        if($('#bulk_products_form input[name="file"]').val()) {
            $this = $(this);
            var fd = new FormData(document.getElementById("bulk_products_form"));
    
            $.ajax({
                url: '<?= base_url('admincontrol/bulkProductImport'); ?>',  
                type: 'POST',
                data: fd,
                dataType: 'html',
                beforeSend:function(){$this.btn("loading");},
                complete:function(){
                    $this.btn("reset");
                    $('#manageBulkProducts').modal('hide');
                },
                success:function(response){               
                    $('#manageBulkProductsConfirmation .modal-body').html(response);
                    $('#manageBulkProductsConfirmation').modal('show');
                    
                    if(! $('#manageBulkProductsConfirmation textarea[name="product_for_import"]').length > 0) {
                     $('#manageBulkProductsConfirmation .import-products-confirm').hide();  
                    } else {
                      $('#manageBulkProductsConfirmation .import-products-confirm').show();  
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });   
        } else {
            $("#bulk_products_form .custom-file").after('<div class="alert alert-danger"><?= __('admin.please_select_excel_file') ?></div>');
        }
    });
    
    $('#manageBulkProductsConfirmation .import-products-confirm').on('click', function(e){
        e.preventDefault();
        if($('#manageBulkProductsConfirmation textarea[name="product_for_import"]').val()) {
            $this = $(this);
                var data = new FormData();
                data.append( 'products', $('#manageBulkProductsConfirmation textarea[name="product_for_import"]').val());
            $.ajax({
                url: '<?= base_url('admincontrol/bulkProductImportConfirm'); ?>',  
                type: 'POST',
                data: data,
                beforeSend:function(){$this.btn("loading");},
                complete:function(){
                    $this.btn("reset");
                    $('#manageBulkProductsConfirmation').modal('hide');
                },
                success:function(response){               
                    $('#manageBulkProductsResult .modal-body').html(response);
                    $('#manageBulkProductsResult').modal('show');
                },
                cache: false,
                contentType: false,
                processData: false
            });   
        } else {
            $("#bulk_products_form .custom-file").after('<div class="alert alert-danger"><?= __('admin.please_select_excel_file') ?></div>');
        }
    });

	$(".show-more").on('click',function(){
		$(this).parents("tfoot").remove();
		$("#product-list tr.d-none").hide().removeClass('d-none').fadeIn();
	});

	$(".delete-button").on('click',function(){
		if(!confirm("<?= __('admin.are_you_sure') ?>")) return false;
	});
	$(".toggle-child-tr").on('click',function(){
		$tr = $(this).parents("tr");
		$ntr = $tr.next("tr.detail-tr");

		if($ntr.css("display") == 'table-row'){
			$ntr.hide();
			$(this).find("i").attr("class","fa fa-plus");
		}else{
			$(this).find("i").attr("class","fa fa-minus");
			$ntr.show();
		}
	})
	
	function checkAll(bx) {
		var cbs = document.getElementsByTagName('input');
		if(bx.checked)
		{
			document.getElementById('deletebutton').style.display = 'block';
			} else {
			document.getElementById('deletebutton').style.display = 'none';
		}
		for(var i=0; i < cbs.length; i++) {
			if(cbs[i].type == 'checkbox') {
				cbs[i].checked = bx.checked;
			}
		}
	}
	
	function checkonly(bx,checkid) {
		if($(".list-checkbox:checked").length){
			$('#deletebutton').show();
		} else {
			$('#deletebutton').hide();
		}
	}
	
	function deleteuserlistfunc(formId){
		if(! confirm("<?= __('admin.are_you_sure') ?>")) return false;

		$('#'+formId).submit();
	}
	

	$("#filter-form").on("submit",function(){
		getPage('<?= base_url("admincontrol/listproduct_ajax/") ?>/1');
		return false;
	})

	function getPage(url){
		$this = $(this);
		$.ajax({
			url:url,
			type:'POST',
			dataType:'json',
			data:$("#filter-form").serialize(),
			beforeSend:function(){$this.btn("loading");},
			complete:function(){$this.btn("reset");},
			success:function(json){
				if(json['view']){
					$("#tech-companies-1 tbody").html(json['view']);
					$("#tech-companies-1").show();
				} else {
					$(".empty-div").removeClass("d-none");
					$("#tech-companies-1").hide();
				}
				
				$("#tech-companies-1 .pagination-td").html(json['pagination']);
			},
		});
	}
	
	$(document).on('click', '.export-products-btn', function() {
	     exportProducts($(this), 0);
	});
	
	$(document).on('click', '.export-structure-btn', function() {
	     exportProducts($(this), 1);
	});
	
	function exportProducts(thatBtn, structure_only  = 0) {
		$.ajax({
			url:'<?= base_url("admincontrol/exportproduct/") ?>',
			type:'POST',
			dataType:'json',
			data:{structure_only:structure_only},
			beforeSend:function(){thatBtn.btn("loading");},
			complete:function(){thatBtn.btn("reset");},
			success:function(json){
				if(json['download']){
					window.location.href = json['download'];
				}
			},
		});
	}
	

	getPage('<?= base_url("admincontrol/listproduct_ajax/") ?>/1');
	$("#tech-companies-1 .pagination-td").delegate("a","click",function(){
		getPage($(this).attr("href"));
		return false;
	})

	function closePopup(){
		$('.popupbox').hide();
		$('#overlay').hide();
	}
	function generateCode(affiliate_id){
		$('.popupbox').show();
		$('#overlay').show();
		$('.modalpopup-body').load('<?php echo base_url();?>admincontrol/generateproductcode/'+affiliate_id);
		$('.popupbox').ready(function () {
			$('.backdrop, .box').animate({
				'opacity': '.50'
			}, 300, 'linear');
			$('.box').animate({
				'opacity': '1.00'
			}, 300, 'linear');
			$('.backdrop, .box').css('display', 'block');
		});
	}

	$(document).delegate(".delete-product",'click',function(){
		if(! confirm("<?= __('admin.are_you_sure') ?>")) return false;
		window.location = $("#deleteAllproducts").attr("action") + "?delete_id=" + $(this).attr("data-id");
	})
</script>			