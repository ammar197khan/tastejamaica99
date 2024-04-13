<?php
if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete_quotation' && isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
    $id = intval($_REQUEST['id']);
    $result = $db->query("delete from sale_quotation_inventory where quotation_id=" . $id);
    $result = $db->query("delete from s_q_transactions where p_q_id=" . $id);
    $result = $db->query("delete from sale_quotation where id=" . $id);
    if ($result) {
        //$imsg->setMessage('Quotation Deleted Successfully!');
        redirect_header(ADMIN_URL . "purchase/pos.php");
    } else {
        //$imsg->setMessage('Error Occur. Please try again later.', 'error');
        redirect_header(ADMIN_URL . "purchase/pos.php");
    }
}
if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete_invoice' && isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
    $invoice_id = intval($_REQUEST['id']);
    $voucher_row = $db->fetch_array_by_query("select id,purchase_invoice from voucher where purchase_invoice=" . $invoice_id);
    if ($voucher_row) {
        $voucher_id = $voucher_row['id'];
        $db->query("delete from invoice_quotation where invoice_id=" . $invoice_id);
        $db->query("delete from quotation_inventory where voucher_id=" . $voucher_id);
        $db->query("delete from transactions where voucher_id=" . $voucher_id);
        $db->query("delete from voucher where id=" . $voucher_id);
        $db->query("delete from cost_categroy_transactions where voucher_id=" . $voucher_id);
        $db->query("delete from purchase_invoice_inventory where receipt_id=" . $invoice_id);
        $db->query("delete from p_invoice_transaction where p_i_id=" . $invoice_id);
        $result = $db->query("delete from sale_invoice where id=" . $invoice_id);
        if ($result) {
            //$imsg->setMessage('Invoice Deleted Successfully!');
            redirect_header(ADMIN_URL . "purchase/pos.php");
        } else {
            $imsg->setMessage('Error Occur. Please try again later.', 'error');
            redirect_header(ADMIN_URL . "purchase/pos.php");
        }
    } else {
        //$imsg->setMessage('Error Occur. Voucher Are Not Found.', 'error');
        redirect_header(ADMIN_URL . "purchase/pos.php");
    }
}


?>
<style type="text/css">
    .custom_tabs .nav-link {
        border-top-left-radius: .0rem !important;
        border-top-right-radius: .0rem !important;
    }

    .tabs_a {
        font-size: 18px;
        font-weight: bold;
        color: #444444;
    }

    .tabs_a:hover {
        color: #444444;
    }

    .custom_tabs .nav-item.show .nav-link,
    .custom_tabs .nav-link.active {
        color: #000000;
    }

    .custom_tabs {
        border-bottom: 0px solid #dddfeb !important;
    }

    .custom_tabs .nav-item.show .nav-link,
    .custom_tabs .nav-link.active {
        border-top: 3px solid #3c8dbc !important;
    }

    .custom_tabs .nav-link:focus,
    .custom_tabs .nav-link:hover {
        border-color: #3c8dbc;
    }

    .custom_tabs .nav-link:focus,
    .custom_tabs .nav-link {
        border-color: #fff #fff #fff !important;
    }

    .color_recent {
        color: #525f7f !important;
        font-size: 18px;
        font-weight: 400;
    }

    .recent_tran_table td {
        border-top: 0px !important;
        padding: 2px !important;
    }
</style>
<div class="modal fade modal-md" id="recenttranscationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px !important;">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #191939;">Recent Transcation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs custom_tabs">
                        <li class="nav-item">
                            <a class="nav-link active tabs_a" data-toggle="tab" href="#final"><i class="fa-solid fa-check pr-2"></i>Final</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tabs_a" data-toggle="tab" href="#quotation">>_Quotation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tabs_a" data-toggle="tab" href="#Hold">>_Hold</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="final" class="container tab-pane active"><br>
                            <table class="table table-slim no-border dataTable recent_tran_table" id="recent_tran_table">
                                <tbody>
                                    <?php
                                    $db->select('SELECT * FROM sale_invoice ORDER BY id DESC LIMIT 10');
                                    $sale_q_inves = $db->fetch_all();
                                    $k = 1;
                                    foreach ($sale_q_inves as $sale_q_inv) {
                                        //$pro_name = $db->fetch_array_by_query("select * from products where id=".intval($q_inv['item_id']));
                                        //print_r($pro_name);
                                        $ledger_name = $db->fetch_array_by_query("select * from ledger where id=" . $sale_q_inv['ledger_id']);
                                        //$sublocation = $db->fetch_array_by_query("select * from business_sublocations where id=".$sale_q_inv['sub_location_id']);
                                    ?>
                                        <tr class="cursor-pointer" title="Customer: Name">
                                            <td class="color_recent" style="width: 3%;">
                                                <?php echo $k++;  ?>
                                            </td>
                                            <td class="color_recent" style="width: 50%;font-size: 15px;"><?php echo $sale_q_inv['sale_invoice_no']; ?> (<?php echo $ledger_name['name']; ?>)</td>
                                            <td class="display_currency color_recent"><?php echo $sale_q_inv['total_amount']; ?></td>
                                            <td>
                                                <a href="<?php echo ADMIN_URL . 'purchase/edit-pos.php?id=' . $sale_q_inv['id'] . '&pos_type=sale_invoice'; ?>">
                                                    <i class="fas fa-pen text-muted" aria-hidden="true" title="Click to edit"></i>
                                                </a>
                                                <a href="<?php echo ADMIN_URL . 'purchase/pos.php?command=delete_invoice&id=' . $sale_q_inv['id']; ?>" onClick="return confirm('Are you sure? You want to delete this record?')" class="delete-sale" style="padding-left: 20px; padding-right: 20px"><i class="fa fa-trash text-danger" title="Click to delete"></i>
                                                </a>
                                                <?php
                                                $print_q_link = ADMIN_URL . 'sale/recipt-print.php?type=sq&id=' . $sale_q_inv['id'];
                                                $print_link = ADMIN_URL . 'sale/delivery-reciept-print.php?id=' . $sale_q_inv['id'] . '&type=si';
                                                ?>
                                                <a href="#" onclick="openPrint('<?php echo  $print_q_link; ?>')" class="print-invoice-link abc">
                                                    <i class="fa fa-print text-muted" aria-hidden="true" title="Click to print"></i>
                                                </a>
                                                <a href="#" onclick="openPrint('<?php echo  $print_link; ?>')" class="print-invoice-link abc">
                                                    <i class="fa fa-print text-muted" aria-hidden="true" title="Click to print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="quotation" class="container tab-pane fade"><br>
                            <table class="table table-slim no-border dataTable recent_tran_table" id="recent_tran_table">
                                <tbody>
                                    <?php
                                    if($auth_row['super_admin']=='yes'){
                                        $db->select('SELECT * FROM sale_quotation ORDER BY id DESC LIMIT 10');
                                    }else{
                                        $db->select('SELECT * FROM sale_quotation where user_id='.intval($auth_row['id']).' ORDER BY id DESC LIMIT 10');
                                    }
                                    $q_inves = $db->fetch_all();
                                    $j = 1;
                                    foreach ($q_inves as $q_inv) {
                                        //$pro_name = $db->fetch_array_by_query("select * from products where id=".intval($q_inv['item_id']));
                                        //print_r($pro_name);
                                        $ledger_name = $db->fetch_array_by_query("select * from ledger where id=" . $q_inv['ledger_id']);
                                        //$sublocation = $db->fetch_array_by_query("select * from business_sublocations where id=".$q_inv['sub_location']);
                                    ?>
                                        <tr class="cursor-pointer" title="Customer: Name">
                                            <td class="color_recent" style="width: 3%;">
                                                <?php echo $j++;  ?>
                                            </td>
                                            <td class="color_recent" style="width: 50%;font-size: 15px;"><?php echo $q_inv['purch_quotation_no']; ?> (<?php echo $ledger_name['name']; ?>)</td>
                                            <td class="display_currency color_recent"><?php echo $q_inv['total_amount']; ?></td>
                                            <td style="width: 30%;">
                                                <a href="<?php echo ADMIN_URL . 'purchase/edit-pos.php?id=' . $q_inv['id'] . '&pos_type=sale_quotation'; ?>">
                                                    <i class="fas fa-pen text-muted" aria-hidden="true" title="Click to edit"></i>
                                                </a>
                                                <a href="<?php echo ADMIN_URL . 'purchase/pos.php?command=delete_quotation&id=' . $q_inv['id']; ?>" onClick="return confirm('Are you sure? You want to delete this record?')" class="delete-sale" style="padding-left: 20px; padding-right: 20px"><i class="fa fa-trash text-danger" title="Click to delete"></i>
                                                </a>
                                                <?php
                                                $print_q_link = ADMIN_URL . 'sale/recipt-print.php?type=sq&id=' . $q_inv['id'];
                                                $print_link = ADMIN_URL . 'sale/delivery-reciept-print.php?id=' . $q_inv['id'] . '&type=sq';
                                                ?>
                                                <a href="#" onclick="openPrint('<?php echo $print_q_link ?>')" class="print-invoice-link abc">
                                                    <i class="fa fa-print text-muted" aria-hidden="true" title="Click to print"></i>
                                                </a>
                                                <a href="#" onclick="openPrint('<?php echo $print_link ?>')" class="print-invoice-link abc">
                                                    <i class="fa fa-print text-muted" aria-hidden="true" title="Click to print"></i>
                                                </a>
                                                <!-- <a href="<?php //echo ADMIN_URL . 'purchase/pos.php?pos_type=sale_quotation&print_id='.$q_inv['id']  . '&print=yes&type=delivery'
                                                                ?>" class="print-invoice-link abc">
                                                <i class="fa fa-print text-muted" aria-hidden="true" title="Click to print"></i>
                                            </a> -->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="Hold" class="container tab-pane fade"><br>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_close_modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn_save_changes" name="command" value="recent_transcation">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>