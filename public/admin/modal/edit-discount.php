<style type="text/css">
    .applicable_icon {color: #555555;font-weight: 800;font-size: 16px;}
    
</style>
<div class="modal fade modal-md" id="poseditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="label_all_modal">Edit Discount</p>
                    <div class="row">
                       <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Disount Type:*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 32px;">
                                      <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-info applicable_icon"></i></span>
                                    </div>
                                    <select class="form-control form-control-sm mb-3 total_discount_type" name="total_discount_type">
                                        <option value="">Please select</option>
                                        <option value="no"<?php echo ($pur_row['total_disc_type'] == 'no') ? 'selected' : ''; ?>>Fixed</option>
                                        <option value="%" <?php echo ($pur_row['total_disc_type'] == '%') ? 'selected' : ''; ?>>Precentage</option>
                                    </select>
                                </div>
                            </div>
                       </div>
                        <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Disount Amount:*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 32px;">
                                      <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-info applicable_icon"></i></span>
                                    </div>
                                    <input type="name" class="form-control total_discount_amount" style="height: 32px;" name="total_discount_amount" id=""  placeholder="0.00" value="<?= $pur_row['total_disc_rate'] ?>">
                                </div>
                            </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn_save_changes" name="" value="" onclick="TotalDiscount()">Update</button>
                </div>
            </div>
    </div>   
</div>