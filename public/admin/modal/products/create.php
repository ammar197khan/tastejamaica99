<style type="text/css">
    .custom-file-input:lang(en)~.custom-file-label::after {content: "Browse";color: #fff;background-color: #1572e8 !important;border-color: ##1572e8 !important;border-radius: 0px;height: 32px;line-height: 1.1}
    .custom-file-label {height: 34px;border-radius: 0rem;-webkit-box-shadow: 0rem 0rem 0rem !important;box-shadow: 0rem 0rem 0rem!important;line-height: 1.2}
    .exp_card_supp {padding: 15px;background-color: #fff;border-top: 3px solid #3c8dbc;border-radius: 6px;}
    .bg-purple{background-color: #504d8c;color: #fff;}
    .bg-maroon{background-color: #d81b60;color: #fff;}
    .span_set_plus {color: #1572e8;background-color: #fff !important;border-color: #e9dddd !important;border-radius: 0px!important;height: 32px;}
    .input_plus {flex-wrap: unset !important;}
    .form_height_modal {height: 32px;}
    .span_checkbox1 {padding-left: 11px;margin-top: 0px;position: absolute;font-size: 17px;font-weight: 700;color: #525f7f;}
</style>
<div class="modal fade modal-md" id="createproductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px !important;">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="0" class="input-class-id" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #edeef3;">
                    <div class="exp_card_supp mb-4">
                        <div class="row">
                             <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="select2Multiple" class="label_all">Product Image:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="product_image">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group pr-3">
                                    <label for="select2Multiple" class="label_all_modal">Product Name:*</label>
                                    <input class="form-control form_height_modal input-class-name"  name="product_name" type="text" id="" placeholder="Product Name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group pr-3">
                                    <label for="select2Multiple" class="label_all_modal">Sku</label>
                                    <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Unique product id or Stock Keeping Unit <br><br>Keep it blank to automatically generate sku.<br><small class='text-muted'>You can modify sku prefix in Business settings.</small>" data-html="true" data-trigger="hover" data-original-title="" title=""></i>
                                    <input class="form-control form_height_modal input-class-sku"  name="sku_name" type="text" id="" placeholder="SKU">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">Unit:*</label>
                                    <div class="input-group mb-3 input_plus">
                                        <select class="form-control choosen-index form_height_modal mb-3 input-class-unit_id" name="unit_type">
                                            <option value="">Please Select</option>
                                            <?php 
                                            $db->select('select * from item_unit order by id desc');
                                            $units = $db->fetch_all();
                                            foreach($units as $unit){
                                            ?>
                                            <option value="<?= $unit['id']; ?>"><?= $unit['name']; ?></option>
                                            <?php } ?>
                                      
                                        </select>
                                        <span type="button" class="input-group-text span_set_plus"  data-toggle="modal" data-target="#unitModal"><i class="fa-solid fa-circle-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-12">
                            	<div class="form-check">
                                    <label class="form-check-label">
                                        <input  type="checkbox" class="form-check-input business_check input_checkbox input-class-manage_stock"  value="" name="manage_stock">
                                    </label>
                                    <span class="span_checkbox">Manage Stock</span>
                                </div>
                                <p class="help-block pt-4" style="color: #737373;font-weight: 600;"><i>Enable stock management at product level</i></p>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12 business_show"></div>
                            <div class="col-md-6 col-sm-12 col-12 business_show">
                                <div class="form-group pr-3">
                                    <label for="select2Multiple" class="label_all_modal">Alert Quantity:*</label>
                                    <input class="form-control form_height_modal input-class-opening_stock"  name="alert_quantity" type="text" id="" placeholder="Alert Quantity">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="exp_card_supp mb-4">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  mb-0">
                                    <label for="select2Multiple" class="label_all_modal">Barcode Type:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-barcode_type" name="barcode_type">
                                        <option value="C128">Code 128 (C128)</option>
                                        <option value="C39">Code 39 (C39)</option>
                                        <option value="EAN-13">EAN-13</option>
                                        <option value="EAN-8">EAN-8</option>
                                        <option value="UPC-A">UPC-A</option>
                                        <option value="UPC-E">UPC-E</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">Brand:</label>
                                    <div class="input-group mb-3 input_plus">
                                        <select class="form-control choosen-index form_height_modal mb-3 input-class-brand_id" name="brand_type">
                                            <option  value="">Please Select</option>
                                            <?php 
                                            $db->select('select * from item_brand order by id desc');
                                            $brands=$db->fetch_all();
                                            foreach($brands as $brand){
                                            ?>
                                            <option value="<?= $brand['id'] ?>"><?= $brand['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                         <span type="button" class="input-group-text span_set_plus"  data-toggle="modal" data-target="#brandModal"><i class="fa-solid fa-circle-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">Category:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-category_id" name="category_new_product">
                                        <option  value="">Please Select</option>
                                        <?php 
                                        $db->select('select * from categories order by id desc');
                                        $categories=$db->fetch_all();
                                        foreach($categories as $category){
                                        ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">SubCategory:</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-sub_category_id" name="subcategory_new_product">
                                        <option  value="">Please Select</option>
                                        <?php 
                                        $db->select('select * from sub_categories order by id desc');
                                        $sub_categories=$db->fetch_all();
                                        foreach($sub_categories as $subcat){
                                        ?>
                                        <option value="<?= $subcat['id'] ?>"><?= $subcat['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12">
                                <div class="form-group  mb-0">
                                    <label for="select2Multiple" class="label_all_modal">Business Location:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-product_locations" name="business_loc_new_product">
                                        <?php 
                                        $db->select('select * from business_locations order by id desc');
                                        $business_locs=$db->fetch_all();
                                        foreach($business_locs as $business_loc){
                                        ?>
                                        <option value="<?= $business_loc['id']; ?>"><?= $business_loc['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12"></div>
                            <div class="clearfix"></div>
                            <div class="col-md-7 col-sm-12 col-12 mb-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input input_checkbox input-class-p_description_enable" value="" name="enable_product">
                                    </label>
                                    <span class="span_checkbox">Enable Product description, IMEI or Serial Number</span>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 col-12 mb-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input input_checkbox input-class-not_for_selling" value="" name="not_selling">
                                    </label>
                                    <span class="span_checkbox">Not For Selling</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-8 col-sm-12 col-12 mb-3">
                                <div class="form-group pr-3">
                                    <label for="select2Multiple" class="label_all_modal">Weight:</label>
                                    <input class="form-control form_height_modal input-class-weight"  name="weight" type="text" id="">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-12 mb-3"></div>
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
                        </div>
                    </div>
                    <div class="exp_card_supp mb-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">Applicable Tax:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 " name="applcable_tax">
                                        <option  value="">Please Select</option>
                                        <option value="">none</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal ">Selling Price Tax Type:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-selling_price_tax_type" name="selling_price_tax">
                                        <option value="inclusive">Inclusive</option>
                                        <option value="exclusive" selected="selected">Exclusive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-12">
                                <div class="form-group  cust_group">
                                    <label for="select2Multiple" class="label_all_modal">Product Type:*</label>
                                    <select class="form-control choosen-index form_height_modal mb-3 input-class-product_type" name="product_type">
                                        <option value="single">Single</option>
                                        <option value="variable" >Variable</option>
                                        <option value="combo" >Combo</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12  col-sm-12 col-12">
                                <table class="table table-bordered add-product-price-table table-condensed ">
                                    <tbody>
                                        <tr style="background-color: #5cb85c;">
                                            <th style="color: #fff;">Default Purchase Price</th>
                                            <th style="color: #fff;">x Margin(%) <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Default profit margin for the product. <br><small class='text-muted'>(<i>You can manage default profit margin in Business Settings.</i>)</small>" data-html="true" data-trigger="hover"></i></th>
                                            <th style="color: #fff;">Default Selling Price</th>
                                            <th  style="color: #fff;">Product Image</th>
                                        </tr>
                                        <tr class="tr_color">
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                      <label for="single_dpp" class="label_all">Exc. tax:*</label>

                                                      <input class="form-control input-sm dpp input_number input-class-purchase_price_without_tax" placeholder="Exc. tax"  name="single_dpp" type="text" id="single_dpp" >
                                                    </div>
                                                    <div class="col-sm-6">
                                                      <label for="single_dpp_inc_tax" class="label_all">Inc. tax:*</label>
                                                    
                                                      <input class="form-control input-sm dpp_inc_tax input_number input-class-purchase_price_with_tax" placeholder="Inc. tax"  name="single_dpp_inc_tax" type="text" id="single_dpp_inc_tax" >
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <br>
                                                <input class="form-control input-sm input_number input-class-profit_margin" id="profit_percent"  name="profit_percent" type="text" value="0" >
                                            </td>
                                            <td>
                                                <label class="label_all"><span class="dsp_label">Inc. Tax</span></label>
                                                <input type="hidden" class="form-control input-sm dsp input_number hide" placeholder="Exc. tax" id="single_dsp" required="" name="single_dsp" type="text" >
                                                <input class="form-control input-sm input_number input-class-selling_price" placeholder="Inc. tax" id="single_dsp_inc_tax" required="" name="single_dsp_inc_tax" type="text" aria-required="true">
                                            </td>
                                            <td>
                                                 <label for="select2Multiple" class="label_all">Product Image:</label>
                                                <div class="custom-file">
                                                    <input class="form-control"   name="product_image_inner_table" type="file" style="border: none;">
                                                    <small>
                                                        <p class="help-block" style="font-size: 16px;">
                                                            Max File size: 5MB<br>
                                                            Accept Ratio Should be 1:1
                                                        </p>
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="col-sm-12 col-12">
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button id="opening_stock_button" type="submit" name="submit" value="submit_n_add_opening_stock" class="btn bg-purple submit_product_form">Save &amp; Add Opening Stock</button>
                                        <button type="submit" value="save_n_add_another" name="submit" class="btn bg-maroon submit_product_form">Save And Add Another</button>
                                        <button type="submit" value="submit" name="submit" class="btn btn-primary submit_product_form">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_changes" name="command" value="Add" >Save changes</button>
                </div> -->
            </div>
        </form>
    </div>   
</div>