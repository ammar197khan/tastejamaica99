<style type="text/css">
    .date_tax_app {height: 32px;background-color: #eee;opacity: 1;}
    .exp_border {border-bottom: 1px solid black;}
    
</style>
<div class="modal fade modal-md" id="addexpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px !important;">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Add Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group  mb-0">
                                <label for="select2Multiple" class="label_all_modal">Business Location:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="expense_business">
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
                         <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group  cust_group">
                                <label for="select2Multiple" class="label_all_modal">Category:*</label>
                                <select class="form-control choosen-index form_height_modal mb-3" name="expense_category">
                                    <option  value="">Please Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group mb-0">
                                <label for="select2Multiple" class="label_all_modal">Reference No:*</label>
                                    <input class="form-control form_height_modal"  name="reference_no" type="text" id="" placeholder="">
                            </div>
                            <span style="color: #9fa0a7;">Leave Empty Auto Generated</span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group" id="simple-date1">
                                <label for="simpleDataInput" class="label_all">Date:*</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text span_set"><i class="fas fa-calendar" style="color: #555555;"></i></span>
                                    </div>
                                    <input type="text" class="form-control date_tax_app" value="01/06/2020" id="simpleDataInput" name="date_expense">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Expense For:*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 32px;">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-info applicable_icon"></i>
                                        </span>
                                    </div>
                                    <select class="form-control form-control-sm mb-3" name="shiping_status">
                                        <option value="">Please select</option>
                                        <option value="" selected="selected">None</option>
                                        <option value=""> Muhammad Aamir</option>
                                        <option value=""> Muhammad Aamir</option>
                                        <option value=""> Muhammad Husnain</option>
                                        <option value=""> Rameez Sindhu</option>
                                        <option value=""> waqas </option>
                                        <option value=""> Zaheer </option>
                                        <option value=""> AllahDitta </option>
                                    </select>
                                </div>
                            </div>
                       </div>
                       <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Applicable Tax:*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" style="height: 32px;">
                                      <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-info applicable_icon"></i></span>
                                    </div>
                                    <select class="form-control form-control-sm mb-3" name="applicable_tax">
                                        <option value="">None</option>
                                    </select>
                                </div>
                            </div>
                       </div>
                       <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Total Amount:*</label>
                                <input type="text" class="form-control " style="height: 32px;" name="total_amount" id=""  placeholder="0">
                            </div>
                       </div>
                       <div class="col-sm-6 col-12">
                           <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Expense Note:*</label>
                                <textarea class="form-control" rows="3" name="expense_note" cols="50" id="" placeholder=""></textarea>
                            </div>
                       </div>
                       <div class="col-md-12 col-12">
                           <p class="label_all">Add Payment</p>
                       </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Amount:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text span_set height_input" id="basic-addon1"><i class="fa-solid fa-money-bill-1 applicable_icon"></i></span>
                                    </div>
                                    <input type="text" class="form-control " style="height: 32px;" name="expense_amount" id=""  placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group" id="simple-date1">
                                <label for="simpleDataInput" class="label_all">Pain on:</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text span_set"><i class="fas fa-calendar" style="color: #555555;"></i></span>
                                    </div>
                                    <input type="text" class="form-control date_tax_app" value="01/06/2020" id="simpleDataInput" name="paid_expense">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all">Payment Method:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text span_set height_input" id="basic-addon1"><i class="fa-solid fa-money-bill-1 applicable_icon"></i></span>
                                    </div>
                                     <select class=" form-control  mb-sm-3 mb-0 height_input " name="expense_payment_method">
                                        ><option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="other">Other</option>
                                        <option value="custom_pay_1">Custom Payment 1</option>
                                        <option value="custom_pay_2">Custom Payment 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12"></div>
                        <div class="col-md-12 col-12 exp_border pb-4">
                           <div class="form-group ">
                                <label for="select2Multiple" class="label_all">Payment Note:*</label>
                                <textarea class="form-control" rows="3" name="payment_note" cols="50" id="" placeholder=""></textarea>
                            </div> 
                        </div>
                        <div class="col-md-12 col-12 text-right mt-2">
                            <p class="label_all">Payment due: 0.00</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_changes" name="command" value="expens_update" >Save changes</button>
                </div>
            </div>
        </form>
    </div>   
</div>