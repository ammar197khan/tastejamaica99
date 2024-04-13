 <!-- Modal -->
<div class="modal fade modal-md" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px !important;">
        <form action=""  class="NewContactForm" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Add New Contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12">
                             <div class="form-group pr-3 mb-0">
                                <label for="select2Multiple" class="label_all_modal">Account ID:</label>
                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-address-book"></i></span>
                                    </div>
                                    <input Readonly class="form-control form_height_modal"  name="contact_id" type="test" id="" value="<?php echo ContactAccountNo($db);?>">
                                </div>
                            </div>
                            <span style="color: #9fa0a7;">Leave Empty Auto Generated</span>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-check-inline mt-3">
                                <label class="form-check-label" for="check1">
                                    <input type="checkbox" class="form-check-input individual_check" id="check1" name="individual" value="individual" id="check1" onchange="modal_supp(this,'business_check','business_show','individual_show')" checked="checked">Individual
                                </label>
                            </div>
                            <div class="form-check-inline mt-4">
                                <label class="form-check-label" for="check2">
                                    <input type="checkbox" class="form-check-input business_check" id="check2" name="business" value="business" id="check2" onchange="modal_supp(this,'individual_check','individual_show','business_show')">Business
                                </label>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-12 col-12 hidden">
                            <div class="form-group pr-3 cust_group  ">
                                <label for="select2Multiple" class="label_all_modal">Customer Group:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend height_37">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-address-book"></i></span>
                                    </div>
                                    <select class="form-control form_height_modal mb-3" name="customer_group">
                                        <option value="none">None</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-12 col-12"></div>
                        <div class="col-md-4 col-sm-12 col-12"></div> -->
                        <div class="col-md-6 col-sm-12 col-12  hidden">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Prefix:</label>
                                <!-- <input type="name" class="form-control form_height_modal" name="prefix" id=""  placeholder="Mr, Mrs"> -->
                                <select class="form-control form_height_modal" name="prefix" id="">
                                    <option value="Mr" selected>Mr</option>
                                    <option value="Mrs">Mrs</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Mobile No:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-mobile"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal" onchange="ContactCustomer(this)"  name="mob_no" type="number" id="newContact-mob" placeholder="Mobile Number">
                                </div>
                            </div>
                        <?php if (isset($_REQUEST) && $_REQUEST['pos_type'] == 'sale_invoice' || $_REQUEST['pos_type'] == 'sale_quotation') { ?> 
                            <input type="hidden" name="contact_type" value="customer">
                        <?php }else{ ?>
                            <input type="hidden" name="contact_type" value="supplier">
                        <?php } ?>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 individual_show">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Name:</label>
                                <input type="name" class="form-control form_height_modal" name="first_name" id=""  placeholder="Name" readonly>
                            </div>
                        </div> 
                        <!-- <div class="col-md-3 col-sm-12 col-12 individual_show">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Middle Name:</label>
                                <input type="name" class="form-control form_height_modal" name="middle_name" id=""  placeholder="Middle Name">
                            </div>
                        </div> 
                        <div class="col-md-3 col-sm-12 col-12 individual_show">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Last Name:</label>
                                <input type="name" class="form-control form_height_modal" name="last_name" id=""  placeholder="Last Name">
                            </div>
                        </div> -->
                        <div class="col-md-6 col-sm-12 col-12 business_show">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Business Name:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-user-group"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal"  name="business_name" type="text" id="" readonly>
                                </div>
                            </div>
                        </div>
                       <!--  <div class="col-md-4 col-sm-12 col-12  individual_show"></div> -->
                        <!-- <div class="col-md-4 col-sm-12 col-12  individual_show"></div> -->
                        <div class="clearfix"></div>
                  
                        <!-- <div class="col-md-3 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Alernate:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal"  name="alternate" type="number" id="" placeholder="Alternate">
                                </div>
                            </div>
                        </div>  -->
                       <!--  <div class="col-md-4 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Land Line:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1" ><i class="fa-solid fa-phone"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal"  name="land_number" type="number" id="" placeholder="Land line">
                                </div>
                            </div>
                        </div>  -->
                        <div class="col-md-4 col-sm-12 col-12 hidden">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Email:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1" ><i class="fa-solid fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal"  name="email" type="text" id="" placeholder="Email" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-12 col-12 individual_show">
                            <div class="form-group" id="simple-date1">
                                <label for="simpleDataInput" class="label_all_modal">Date Of Birth:</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text span_set"><i class="fas fa-calendar bir_calendar" style="color: #555555;"></i></span>
                                    </div>
                                    <input type="text" name="date_birth" class="form-control height_birth" style="" value="" id="simpleDataInput">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-4 col-sm-12 col-12 hidden">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Assinged To:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input class="form-control form_height_modal"  name="assinged_to" type="text" id="" placeholder="">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 col-sm-12 col-12" style="display: none;">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Address:</label>
                                <div class="input-group mb-3">
                                    <input class="form-control form_height_modal"  name="address_line1" type="text" id="" placeholder="Address" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Shipping Address:</label>
                                <div class="input-group mb-3">
                                    <input class="form-control form_height_modal"  name="shipping_address" type="text" id="" placeholder="Shipping Address" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 text-center hidden">
                            <button type="button" class="btn btn_save_modal" data-target="#more_div">More Informations <i class="fa fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <div class="modal_menu" style="display: none;">
                        <div class="mt-3 py-4 tax_field_br">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">Tax Number:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1" ><i class="fa-solid fa-money-bill-1"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="tax_number" type="number" id="" placeholder="">
                                          </div>
                                      </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">Openning Balance:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-money-bill-1"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="opening_blnce" type="number" id="" placeholder="">
                                          </div>
                                      </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="form-group" id="simple-date4">
                                        <label for="" class="label_all_modal">Pay Term</label>
                                        <div class=" input-group">
                                             <input type="text" class="input-sm form-control" name="pay_cond" style="height:37px;">
                                             <div class="input-group-prepend" style="height: 37px;">
                                                  
                                             </div>
                                             <select class="form-control form_height_modal mb-3" name="pay_term">
                                                  <option value="months">Months</option>
                                                  <option value="days">Days</option>
                                          
                                              </select>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class=" py-4">
                            <div class="row">
                                  <div class="col-md-6 col-sm-12 col-12">
                                      <div class="form-group mb-3">
                                          <label for="" class="label_all_modal">Address Line 1:</label>
                                          <input type="name" class="form-control form_height_modal" name="address_line11" id="" aria-describedby="" placeholder="Address Line 1">
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-sm-12 col-12">
                                      <div class="form-group mb-3">
                                          <label for="" class="label_all_modal">Address Line 2:</label>
                                          <input type="name" class="form-control form_height_modal" name="address_lin22" id="" aria-describedby="" placeholder="Address Line 2">
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">City:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-droplet"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="city" type="text" id="" placeholder="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">State:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1" ><i class="fa-solid fa-droplet"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="state" type="text" id="" placeholder="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">Country:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1" ><i class="fa-solid fa-globe"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="country" type="text" id="" placeholder="">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-12">
                                      <div class="form-group pr-3">
                                          <label for="select2Multiple" class="label_all_modal">Zip Code:</label>
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text span_set" id="basic-addon1"><i class="fa-solid fa-droplet"></i></span>
                                              </div>
                                              <input class="form-control form_height_modal"  name="zip_code" type="number" id="" placeholder="">
                                          </div>
                                      </div>
                                  </div>
                          </div>
                      </div>
                      <div class="py-4 custom_field_br">
                          <div class="row mt-2 mb-2">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive p-3">
                                        <table class="table  table-striped table-bordered supp_cust_table" id="dataTable" style="border: 1px solid #e3e6f0; ">
                                            <thead>
                                                <tr class="border_th">
                                                    <th class="customer_no">No</th>
                                                    <th>Customer Field</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="supp_cust_body">
                                                 <tr class="td_colour supp_cust_row">
                                                    <td class="supp_cust_no">1</td>
                                                    <td>
                                                        <div class="form-group ">
                                                            <input class="form-control form_height_modal Customer_filed"  name="Customer_filed[]" type="text" id="" placeholder="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn_add btn-xs add_row" onclick="add_row(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                
                                                        <button type="button" class="btn btn-danger remove_row btn-xs " onclick="remove_customer(this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                      
                                </div>

                          </div>
                      </div>
                      <div class="py-4">
                          <div class="row">
                              <div class="col-md-2 col-sm-12 col-12"></div>
                              <div class="col-md-8 col-sm-12 col-12">
                                  <div class="form-group ">
                                      <label for="select2Multiple" class="label_all_modal">Shipping Address:</label>
                                          <input class="form-control form_height_modal"  name="shiping_address" type="text" id="" placeholder="">
                                  </div>
                              </div>
                              <div class="col-md-2 col-sm-12 col-12"></div>
                              <input name="command" value="AddContact"  type="hidden">
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="button" onclick="AddContact(this)" class="btn btn_save_changes btn_contact"  >Save changes</button>
                </div>
            </div>
        </form>
    </div>   
</div>