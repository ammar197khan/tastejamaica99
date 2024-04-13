<style type="text/css">
    .applicable_icon {
        color: #555555;
        font-weight: 800;
        font-size: 16px;
    }
</style>
<div class="modal fade modal-md" id="shipingposModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1200px !important;">

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
                            <table class="table  table-bordered supp_table">
                                <thead>
                                    <tr class="border_th" style="border: 1px solid #ecf0fd;">
                                        <th class="customer_no" style="width:2% !important;">No</th>
                                        <th style="width:17%">Item</th>
                                        <th style="width:17%">Vehcile No</th>
                                        <th style="width: 18%">Name</th>
                                        <th style="width: 18%">Mobile</th>
                                        <th class="carriage_check" width="17%" style="width: 17%">carriage</th>
                                        <th style="width: 15%">Image</th>
                                        <th style="width: 11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="supp_body">
                                    <tr class="td_colour supp_row">
                                        <td class="supp_no">1</td>
                                        <td>
                                            <div class="form-group ">
                                              <select name="shipped_item1[]" onchange="getMultipleSelectValue(this)" class="chosen-multiplee chosen-items" multiple>

                                              </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <input class="form-control form_height_modal vehcile_no" name="vehcile_no[]" type="text" id="" placeholder="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <input class="form-control form_height_modal  driver_name" name="driver_name[]" type="text" id="" placeholder="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <input class="form-control form_height_modal mobile_no" name="mobile_no[]" type="number" id="" placeholder="">
                                            </div>
                                        </td>
                                        <td class="carriage_check">
                                            <div class="form-group ">
                                                <input class="form-control form_height_modal carriage_amount" name="carriage_amount[]" onkeyup="calcul_carriage()" type="text" id="" placeholder="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <input type="file" name="driver_image[]" class="form-control driver_image img_new" value="">
                                                <div class="col-md-12" style="padding-top: 25px;">
                                                    <div class="img_sec">
                                                        <input type="hidden" name="snap_profile[]" class="snap-id-profile" />
                                                        <img class="snapShot" style="width:100px;height:100px" src="" alt="User profile picture" alt="Avatar">
                                                    </div>
                                                    <div style="width:150px;margin-top:15px;margin-bottom:15px;">
                                                        <button type="button" style="" class="btn btn-primary btn-block" onclick="takeSnapShot1(this,'snapShot','snap-id-profile')">Take Photo</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn_add btn-xs add_row shipping-add-row" id="" onclick="add_supplier_row(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-danger remove_row btn-xs " onclick="remove_row(this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                       <th colspan="5" class="text-center">Total Carriage</th>
                                       <th class="carriage_check text-center tfoot_total_carriage">0</th>
                                       <th colspan="2"></th> 
                                    </tr>
                                </tfoot>
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