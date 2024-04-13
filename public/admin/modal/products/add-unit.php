<div class="modal fade modal-md" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 500px !important;">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Add Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <!--  <p class="label_all_modal">Edit Order tax</p> -->
                    <div class="row">
                       <div class="col-sm-12 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Name:*</label>
                                <input type="text" class="form-control " style="height: 32px;" name="unit_name" id=""  >
                            </div>
                       </div>
                       <div class="col-sm-12 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Short Name:*</label>
                                <input type="text" class="form-control " style="height: 32px;" name="unit_short_desc" id=""  >
                            </div>
                       </div>
                       <div class="col-sm-12 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Allow Decimal:*</label>
                                <select  class="form-control"  name="allow_decimal"  style="height: 32px;">
                                  <option selected="selected" value="">Please Select</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                                </select>
                            </div>
                       </div>
                        
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_changes" name="command" value="add-unit" >Save</button>
                </div>
            </div>
        </form>
    </div>   
</div>