<style type="text/css">
    .applicable_icon {color: #555555;font-weight: 800;font-size: 16px;}

    
</style>
<div class="modal fade modal-md" id="shipingposModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 900px !important;">
    
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Shipping</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <!--  <p class="label_all_modal">Edit Order tax</p> -->
                     <div class="row mt-2 mb-2">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="table-responsive p-3">
                                <table class="table  table-striped table-bordered supp_table" id="dataTable" style="border: 1px solid #e3e6f0; ">
                                        <thead>
                                            <tr class="border_th">
                                              <th class="customer_no">No</th>
                                              <th>Vehcile No</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="supp_body">
                                            <?php 
                                                $db->select("select * from  purchase_shipping where p_q_id =".$pq_row['id']);
                                                $pur_shippings = $db->fetch_all();
                                                $supp_no = 0;
                                                foreach ($pur_shippings as $pur_shipping) {?>
                                           <tr class="td_colour supp_row">
                                                <td class="supp_no"><?php echo ++$supp_no;  ?></td>
                                                <td>
                                                    <div class="form-group ">
                                                        <input class="form-control form_height_modal vehcile_no"  name="vehcile_no[]" type="text" id="" placeholder="" value="<?= $pur_shipping['vehcile_no'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group ">
                                                        <input class="form-control form_height_modal  driver_name"  name="driver_name[]" type="text" id="" placeholder="" value="<?= $pur_shipping['shipping_name'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group ">
                                                        <input class="form-control form_height_modal mobile_no"  name="mobile_no[]" type="number" id="" placeholder="" value="<?= $pur_shipping['mobile_no'] ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group ">
                                                         <input  type="file" name="driver_image[]" class="form-control driver_image img_new" value="">
                                                         <?php
                                                            if (strpos($pur_shipping['image'], "data:image/jpeg;base64,/") !== false) {
                                                                $img = $pur_shipping['image'];
                                                            } else {
                                                                $img = '../purchase/img/' . $pur_shipping['image'];
                                                            }
                                                        ?>
                                                        <img src="<?= $img; ?>" class="image-container" style="width: 100px;height: 100px;">
                                                         <div class="col-md-12" style="padding-top: 25px;">
                                                            <div class="img_sec">
                                                                <input type="hidden" name="snap_profile[]" class="snap-id-profile" />
                                                                <img class="snapShot" style="width:100px;height:100px" src=""  alt="User profile picture" alt="Avatar">
                                                                </div>
                                                            <div style="width:150px;margin-top:15px;margin-bottom:15px;">
                                                                <button type="button" style="" class="btn btn-primary btn-block" onclick="takeSnapShot1(this,'snapShot','snap-id-profile')">Take Photo</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn_add btn-xs add_row" onclick="add_supplier_row(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                
                                                    <button type="button" class="btn btn-danger remove_row btn-xs " onclick="remove_row(this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fixed" id="camera"></div>   
                            </div>  
                         </div>
                </div>
                <div class="modal-footer">
                   <!--  <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn_save_changes" name="" value="" onclick="shipping_close()">Save</button>
                </div>
            </div>
     
    </div>   
</div>