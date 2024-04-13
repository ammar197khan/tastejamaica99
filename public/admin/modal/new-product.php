<div class="modal fade modal-md" id="NewProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px !important;">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Product Name:*</label>
                                <input class="form-control form_height_modal"  name="product_name" type="text" id="" placeholder="Product Name">
                            </div>
                        </div>
                         <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Sku</label>
                                <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Unique product id or Stock Keeping Unit <br><br>Keep it blank to automatically generate sku.<br><small class='text-muted'>You can modify sku prefix in Business settings.</small>" data-html="true" data-trigger="hover" data-original-title="" title=""></i>
                                <input class="form-control form_height_modal"  name="sku_name" type="text" id="" placeholder="SKU">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  mb-0">
                                <label for="select2Multiple" class="label_all_modal">Barcode Type:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="barcode_type">
                                    <option value="C128">Code 128 (C128)</option>
                                    <option value="C39">Code 39 (C39)</option>
                                    <option value="EAN13">EAN-13</option>
                                    <option value="EAN8">EAN-8</option>
                                    <option value="UPCA">UPC-A</option>
                                    <option value="UPCE">UPC-E</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Unit:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="unit_type">
                                    <option value="">Please Select</option>
                                    <option value="">Pieces (Pc(s))</option>
                                    <option value="">DOZEN (DZN)</option>
                                    <option value="">FEET (FT)</option>
                                    <option value="">GRAMS (G)</option>
                                    <option value="">KILOGRAM (KG)</option>
                                    <option value="">set (set)</option>
                                    <option value="">HALF KG (1/2KG)</option>
                                    <option value="">PAYA (1/4KG)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Brand:</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="brand_type">
                                    <option  value="">Please Select</option>
                                    <option value="">A+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12"></div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Category:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="category_new_product">
                                    <option  value="">Please Select</option>
                                    <option value="">ACRYLIC DESIGN</option>
                                    <option value="">ACRYLIC GLITTER</option>
                                    <option value="">ALNOOR  MATT</option>
                                    <option value="">ALNOOR HIGH GLOSS</option>
                                    <option value="">ALNOOR SUPER GLOSS</option>
                                    <option value="">ALNOOR TACTILE</option>
                                    <option value="">ANKH GOLA</option>
                                    <option value="">ASH SKIN DOOR 27''</option>
                                    <option value="">ASH SKIN DOOR 30''</option>
                                    <option value="">ASH SKIN DOOR 33''</option>
                                    <option value="">ASH SKIN DOOR 36''</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">SubCategory:</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="subcategory_new_product">
                                    <option  value="">Please Select</option>
                                    <option value="">A+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                        	<div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input input_checkbox" value="" name="manage_stock">
                                </label>
                                <span class="span_checkbox">Manage Stock</span>
                            </div>
                            <p class="help-block mt-4" style="color: #737373;font-weight: 600;"><i>Enable stock management at product level</i></p>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Alert Quantity:*</label>
                                <input class="form-control form_height_modal"  name="alert_quantity" type="text" id="" placeholder="Alert Quantity">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  mb-0">
                                <label for="select2Multiple" class="label_all_modal">Business Location:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="business_loc_new_product">
                                    <option value="">Al-Hamd Hardware (UNIVERSITY ROAD)</option>
                                    <option value="">31 Marla (lari adda)</option>
                                    <option value="">PVC PANEL (RANA TOWN)</option>
                                    <option value="">PATEX (LARI ADDA ROAD)</option>
                                    <option value="">AL HAMD DISPLAY (HBL STREET)</option>
                                    <option value="">PAINT GODOWN (SHOP STREET)</option>
                                    <option value="">ALAMGIR (LARI ADDA STREET)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12 ">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Weight:</label>
                                <input class="form-control form_height_modal"  name="weight" type="text" id="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 mb-4">
                        	<label for="" class="label_all_modal">Product Description:</label>
                            <div id="toolbar-container" style="margin-top:10px;"></div>
                            <div class="mt-3" style="width: 100%;border: 1px solid #d1d3e2;height: 250px" id="editor">
                                <p class="print_text" name="print_text" id="print_text"></p>
                            </div>
                        </div>
                       <!--  <div class="coll-md-4 col-12"></div> -->
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Applicable Tax:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="applcable_tax">
                                    <option  value="">Please Select</option>
                                    <option value="">none</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Selling Price Tax Type:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="selling_price_tax">
                                    <option value="inclusive">Inclusive</option>
                                    <option value="exclusive" selected="selected">Exclusive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12">
                        	<div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input input_checkbox" value="" name="enable_product">
                                </label>
                                <span class="span_checkbox">Enable Product description, IMEI or Serial Number</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12 mb-5">
                        	<div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input input_checkbox" value="" name="not_selling">
                                </label>
                                <span class="span_checkbox">Not For Selling</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12"></div>
                        <div class="col-md-4 col-12"></div>
                        <div class="col-md-3 col-sm-12 col-12">
                            <div class="form-group ">
                                <label for="select2Multiple" class="label_all_modal">Customer Filed 1:</label>
                                    <input class="form-control form_height_modal"  name="Customer_filed1" type="text" id="" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="select2Multiple" class="label_all_modal">Customer Filed 2:</label>
                                    <input class="form-control form_height_modal"  name="Customer_filed2" type="text" id="" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="select2Multiple" class="label_all_modal">Customer Filed 3:</label>
                                    <input class="form-control form_height_modal"  name="Customer_filed3" type="text" id="" placeholder="">
                                
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-12">
                            <div class="form-group ">
                                <label for="select2Multiple" class="label_all_modal">Customer Filed 4:</label>
                                
                                    <input class="form-control form_height_modal"  name="Customer_filed4" type="text" id="" placeholder="">
                                
                            </div>
                        </div>
                        <div class="col-md-12  col-sm-12 col-12">
                        	<table class="table table-bordered add-product-price-table table-condensed ">
								<tbody>
									<tr style="background-color: #5cb85c;">
  										<th style="color: #fff;">Default Purchase Price</th>
  										<th style="color: #fff;">x Margin(%) <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Default profit margin for the product. <br><small class='text-muted'>(<i>You can manage default profit margin in Business Settings.</i>)</small>" data-html="true" data-trigger="hover"></i></th>
  										<th style="color: #fff;">Default Selling Price</th>
          							</tr>
							        <tr class="tr_color">
							          	<td>
							          		<div class="row">
									            <div class="col-sm-6">
									              <label for="single_dpp">Exc. tax:*</label>

									              <input class="form-control input-sm dpp input_number" placeholder="Exc. tax" required="" name="single_dpp" type="text" id="single_dpp" aria-required="true">
									            </div>
									            <div class="col-sm-6">
									              <label for="single_dpp_inc_tax">Inc. tax:*</label>
									            
									              <input class="form-control input-sm dpp_inc_tax input_number" placeholder="Inc. tax" required="" name="single_dpp_inc_tax" type="text" id="single_dpp_inc_tax" aria-required="true">
									            </div>
									        </div>
							          	</td>

							          	<td>
							            	<br>
							            	<input class="form-control input-sm input_number" id="profit_percent" required="" name="profit_percent" type="text" value="5.00" aria-required="true">
							          	</td>
							          	<td>
							            	<label><span class="dsp_label">Inc. Tax</span></label>
							            	<input type="hidden" class="form-control input-sm dsp input_number hide" placeholder="Exc. tax" id="single_dsp" required="" name="single_dsp" type="text" aria-required="true">
							            	<input class="form-control input-sm input_number" placeholder="Inc. tax" id="single_dsp_inc_tax" required="" name="single_dsp_inc_tax" type="text" aria-required="true">
							          	</td>
							        </tr>
								</tbody>
							</table>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                        	<label for="select2Multiple" class="label_all_modal">Add Openning Stock</label>
                        	<table class="table table-condensed table-th-green" id="quick_product_opening_stock_table">
								<thead>
									<tr style="background-color: #5cb85c;">
										<th style="color: #fff;">Location</th>
										<th style="color: #fff;">Quantity</th>
										<th style="color: #fff;">Unit Cost (Before Tax)</th>
										<th style="color: #fff;">Subtotal (Before Tax)</th>
									</tr>
								</thead>
								<tbody>
									<tr class="tr_color">
										<td>Al-Hamd Hardware (UNIVERSITY ROAD)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
									<tr class="tr_color">
										<td>31 Marla (lari adda)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
									<tr class="tr_color">
										<td>PVC PANEL (RANA TOWN)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
									<tr class="tr_color">
										<td>PATEX (LARI ADDA ROAD)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
									<tr class="tr_color">
										<td>AL HAMD DISPLAY (HBL STREET)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
									<tr class="tr_color">
										<td>PAINT GODOWN (SHOP STREET)</td>
										<td><input class="form-control input-sm input_number purchase_quantity" required="" name="" type="text" value="0" aria-required="true"></td>
										<td><input class="form-control input-sm input_number unit_price" required="" name="" type="text" aria-required="true"></td>
										<td><span class="row_subtotal_before_tax">0</span></td>
									</tr>
								</tbody>
							</table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_changes" name="command" value="Add" >Save changes</button>
                </div>
            </div>
        </form>
    </div>   
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/decoupled-document/ckeditor.js"></script>
<script type="text/javascript">
     DecoupledEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container' );
                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            })
            .catch( error => {
                console.error( error );
            });
        

            function getPara() {
              
            }
</script>