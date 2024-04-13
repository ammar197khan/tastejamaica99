 <!-- Modal -->
 <style type="text/css">

 </style>
<div class="modal fade modal-md" id="vendotdetailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Customer Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12">
                             <div class="form-group pr-3 mb-0">
                                <label for="select2Multiple" class="label_all_modal">Account ID:</label>
                              <p class="Account_id"></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 ">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Prefix:</label>
                                <p class="vendor_prefix"></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 individual_show">
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" class="label_all_modal">Name:</label>
                                <p class="vendor_name"></p>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Mobile No:</label>
                                <p class="vendor_mobile"></p>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 hidden">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Email:</label>
                                <p class="vendor_email"></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Address:</label>
                                <p class="vendor_address"></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12"></div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="form-group pr-3">
                                <label for="select2Multiple" class="label_all_modal">Shipping Address:</label>
                                <textarea  class="narration_pos form-control vendor_shipping" name="narration_pos"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 text-center hidden">
                            <button type="button" class="btn btn_save_modal" data-target="#more_div">More Informations <i class="fa fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12 mt-3 text-center hidden">
                        <table class="table table-striped align-items-center table-flush " style="width: 100% !important;">
                            <thead class="">
                                <tr class="border_th">
                                    <th>#</th>
                                    <th>Invoice No</th>
                                    <th>Total Amount</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <ul class="nav nav-tabs ">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#SaleQuotation">Sale Quotation</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#SaleInvoice">Sale Invoice</a>
                        </li>
                    </ul>
                      <!-- Tab panes -->
                    <div class="tab-content ">
                        <div id="SaleQuotation" class="container tab-pane active"><br>
                            <table class="table table-striped align-items-center table-flush table_quotation table-bordered">
                                <thead class="">
                                    <tr class="border_th">
                                         <th>#</th>
                                        <th>Quotation Date</th>
                                        <th>Quotation No</th>
                                        <th>Total Amount</th>                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div id="SaleInvoice" class=" tab-pane fade"><br>
                            <table class="table table-striped align-items-center table-flush table_invoice table-bordered" style="width: 100% !important;" >
                                <thead class="">
                                    <tr class="border_th">
                                        <th>#</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th>Total Amount</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                </div>
            </div>
    </div>   
</div>
</div>