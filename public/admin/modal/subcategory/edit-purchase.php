<style type="text/css">
.pointer{ cursor: pointer; }
.error{background-color: white !important;color:red !important;}
.fixed {position: fixed;bottom: 0;right: 15px;width: 300px;height: 200px;border: 3px solid #1367d1;z-index:99999999;}   
</style>
<div class="modal fade modal-md" id="addpurchase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1400px !important;">
        <div class="modal-content">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Purchase</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="label_all">Add Purchase</p>
                    <div class="row">
                       <div class="col-md-12 col-12">
                            <div class="new_table_sec mb-5">
                                <div class="table-responsive" style="height: 320px;">
                                    <table id="" class="table table-bordered new_table">
                                        <thead>
                                            <tr class="new_table_padd">
                                                <td style="width: 1%">No</td>
                                                <td style="width: 15%">Image</td>
                                                <td style="width: 12%">Product Name</td>
                                                <td style="width: 15%">Business Location</td>
                                                <td style="width: 15%">Business Sub Location</td>
                                                <td style="width: 9%">Purchase Price</td>
                                                <td style="width: 9%">Selling Price</td>
                                                <td style="width: 10%">Unit</td>
                                                <td style="width: 10%">SKU</td>
                                                <td style="width: 2%">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody class="new_table_body">
                                            <tr class="new_table_padd new_table_row">
                                                <td class="sr_no">1</td>
                                                <td class="text-center">
                                                <input type="hidden" name="new_table_input" class="new_table_input">
                                                    <input  type="file" name="product_image[]" class="form-control img_new" value="">
                                                    <div class="col-md-12" style="padding-top: 25px;">
                                                        <div class="img_sec">
                                                            <input type="hidden" name="snap_profile[]" class="snap-id-profile" />
                                                            <img class="snapShot" style="width:200px;height:200px" src=""  alt="User profile picture" alt="Avatar">
                                                            </div>
                                                        <div style="width:150px;margin-top:15px;margin-bottom:15px;">
                                                            <button type="button" style="" class="btn btn-primary btn-block" onclick="takeSnapShot1(this,'snapShot','snap-id-profile')">Take Photo</button>
                                                        </div>
                                                    </div>
                                                   <!--  <button type="button" class="btn btn_add px-5 py-2 mt-2 onclick_cam" onclick="openFingerPrintModal(this)"><span class="label_btn_cam">Cam Pic</span></button> -->
                                                </td>
                                                <td>
                                                    <input  type="text" name="product_name[]"  class="form-control product_name_new">
                                                </td>
                                                <td>
                                                    <?php
                                                        $db->select('select * from business_locations where activate="yes" order by id desc');
                                                        $locations = $db->fetch_all();
                                                        $json_loations = json_encode($locations);
                                                    ?>
                                                    <select  class="form-control business_new chosen-loc location"  multiple id="location"  name="location1[]">
                                                        <?php
                                                            foreach ($locations as $loc) {
                                                        ?>
                                                        <option value="<?= $loc['id']; ?>"><?= $loc['name']; ?></option>
                                                       
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                        $db->select('select * from business_sublocations where activate="yes" order by id desc');
                                                        $locations = $db->fetch_all();
                                                        $json_loations = json_encode($locations);
                                                    ?>
                                                    <select  class="form-control sub_business_new chosen-loc sublocation" multiple id="sub_location"   name="sub_location1[]">
                                                        <?php
                                                            foreach ($locations as $loc) {
                                                        ?>
                                                        <option value="<?= $loc['id']; ?>"><?= $loc['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input  type="number" name="default_purchase_price[]" class="form-control purchase_new">
                                                </td>
                                                <td>
                                                    <input  type="number" name="default_sell_price[]" class="form-control selling_new">
                                                </td>
                                                <td>
                                                    <?php
                                                        $db->select('select * from item_unit order by id desc');
                                                        $units = $db->fetch_all();
                                                    ?>
                                                    <select  name="unit_id[]" class="form-control unit_new">
                                                        <?php
                                                            foreach ($units as $unit) {
                                                        ?>
                                                        <option value="<?= $unit['id'] ?>"><?= $unit['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input  type="text" name="sku[]" class="form-control sku_new">
                                                    <input type="hidden" name="subcategory_id[]" class="subcategory_name" value="">
                                                    <input type="hidden" name="subcategory_click_id[]" class="subcategory_name_click" value="">

                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn_add btn-xs add_row px-2 py-1 mb-2" onclick="add_row(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn btn-danger remove_row btn-xs px-2 py-1 mb-2" onclick="remove_row(this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn btn_add  btn-xs px-2 py-1 mb-2" onclick="clone_row(this)"><i class="fa-solid fa-clone"></i></button>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                       </div>
                       <div class="col-md-6">
                            <div class="fixed" id="camera"></div>   
                        </div>  
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_modal" name="command" value="add-purchase" >Save</button>
                </div>
            </form>
        </div>
    </div>   
</div>