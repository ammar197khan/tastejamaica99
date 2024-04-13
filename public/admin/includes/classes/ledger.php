<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);
class Ledger extends Database
{
	private $table = 'ledger';
	function __construct()
	{
		parent::__construct();
		$this->obj_imsg = load_class('InfoMessages');
	}

	function getCities()
	{
		$this->query('select * from ' . $this->table . ' order by id desc');
		$rows = $this->fetch_all();
		return $rows;
	}

	function getUnlockCities($parent_id = 0)
	{
		$this->select("SELECT * from $this->table WHERE parent_id=$parent_id AND locked='no' order by name asc");
		$rows = $this->fetch_all();
		return $rows;
	}

	function countTotalCities()
	{
		$count_row = $this->fetch_array_by_query("SELECT count(*) as total from $this->table  order by name asc");
		$count = $count_row['total'];
		return $count;
	}
	function addRecord($post)
	{

		

		if ($post['contact_type'] == 'supplier') {

			$suplier_ledger = 'yes';
		} else {

			$suplier_ledger = 'no';
		}
		if ($post['contact_type'] == 'customer') {
			$customer_ledger = 'yes';
		} else {
			$customer_ledger = 'no';
		}
		if ($post['contact_type'] == 'simple') {
			$simple_ledger = 'yes';
			$employee = 'yes';
		} else {
			$simple_ledger = 'no';
			$employee = 'no';
		}
		if ($post['cash'] == '') {
			$cash = 'no';
		} else {
			$cash = 'yes';
		}
		if ($post['bank'] == '') {
			$bank = 'no';
		} else {
			$bank = 'yes';
		}
		if ($post['cheque'] == '') {
			$cheque = 'no';
		} else {
			$cheque = 'yes';
		}
		if ($post['contact_type'] == 'customer') {
			$customer_group = $post['customer_group'];
		}
		if ($post['shipping_address'] != '') {
			$shipping_address = $post['shipping_address'];
		}

		if ($post['individual'] == 'individual') {
			$indiv='yes';
		}else{
			$indiv='no';
		}
			if ($post['business'] == 'business') {
			$business='yes';
			$l_name=$post['business_name'];
		}else{
			$business='no';
			$l_name=$post['first_name'];

		}

		$first_name = $post['first_name'];
		$dob = $post['date_birth'];
		$prefix = $post['prefix'];
		$company_name = $post['business_name'];

		$arr = array(
			'active_supplier' => $suplier_ledger,
			'active_customer' => $customer_ledger,
			'simple_ledger' => $simple_ledger,
			'contact_id' => intval($post['contact_id']),
			'indvidual' => $indiv,
			'business' => $business,
			'prefix' => $prefix,
			'name' => $l_name,
			'cheque'=>$cheque,
			'under_group' => $customer_group,
			'opening_balance' => $post['opening_blnce'],
			'address' => $post['address_line1'],
			'permanent_address' => $post['address_lin2'],
			'company_name' => $company_name,
			'assinged' => $post['assinged_to'],
			'dob' => $dob,
			'ntn' => $post['tax_number'],
			'mobile' => $post['mob_no'],
			'email' => $post['email'],
			'phone_office' => $post['land_number'],
			'pay_term' => $post['pay_cond'],
			'pay_due' => $post['pay_term'],
			'city' => $post['city'],
			'state' => $post['state'],
			'country' => $post['country'],
			'zip_code' => $post['zip_code'],
			'postal_address' => $post['shiping_address'],
			'created_at' => time(),
			'updated_at' => time(),
			'company_id' => intval(1),
			'user_id' => getUSerId(),
			'parent_company' => intval(1),
			'membership_file_no' => ContactAccountNo($this),
			"created_by" => getUSerId(),
			'cash' => $cash,
			'bank' => $bank,
			'employee' => $employee,
			'shipping_address'=>$shipping_address,
		);
		

		$result_id = $this->insert($arr, $this->table);
		// die($query);


		$arr['id'] = $result_id;






		if ($result_id > 0) {

			$ledger_supp_field = array();
			foreach ($post['Customer_filed'] as $key => $value) {
				if ($post['Customer_filed'][$key] != "") {
					$ledger_supp_field['name'] = $post['Customer_filed'][$key];
					$ledger_supp_field['ledger_supp_id'] = $result_id;
					$ledger_supp_field['user_id'] = getUSerId();
					$ledger_supp_field['company_id'] = intval(1);
					$ledger_supp_field['created_at'] = time();
					$ledger_supp_field['updated_at'] = time();
					$ledger_supp_field['updated_by'] = getUSerId();
					$op_result = $this->insert($ledger_supp_field, 'ledger_fields');
				}
			}


		}
		return $result_id;
	}

	function add_nominee($request, $id, $post)
	{
		if (isset($request['nominee']) && $request['nominee'] == 'yes') {
			if (isset($request['nomi_name']) && $request['nomi_name'] != '') {
				foreach ($request['nomi_name'] as $key => $value) {
					$arr_nomi['nomi_name'] = $request['nomi_name'][$key];
					$nomi_nic = str_replace("-", "", strval($request['nomi_nic'][$key]));
					$arr_nomi['nomi_nic'] = $nomi_nic;
					$arr_nomi['type'] = $request['type_nominee'][$key];
					$arr_nomi['f_h_relation'] = $request['f_h_relation'][$key];
					$arr_nomi['nomi_father_husband'] = $request['nomi_father_husband'][$key];
					$arr_nomi['nomi_address'] = $request['nomi_address'][$key];
					$arr_nomi['nomi_permanent_address'] = $request['nomi_permanent_address'][$key];
					$arr_nomi['nomi_relation'] = $request['nomi_relation'][$key];
					$arr_nomi['nomi_dob'] = $request['nomi_dob'][$key];
					$arr_nomi['nomi_country'] = $request['nomi_country'][$key];
					$arr_nomi['nomi_city'] = $request['nomi_city'][$key];
					$arr_nomi['nomi_phone'] = $request['nomi_phone'][$key];
					$nomi_mobile = str_replace("-", "", strval($request['nomi_mobile'][$key]));
					$arr_nomi['nomi_mobile'] = '+92' . $nomi_mobile;
					$arr_nomi['nomi_fax'] = $request['nomi_fax'][$key];
					$arr_nomi['nomi_email'] = $request['nomi_email'][$key];
					$arr_nomi['ledger_id'] = $id;
					$arr_nomi['created_at'] = time();
					$arr_nomi['updated_at'] = time();
					$arr_nomi['company_id'] = getCompanyId();
					$arr_nomi['user_id'] = getUSerId();
					//$arr_nomi['nomi_id_images'] =$request['nomi_id_images'];
					if (isset($post['nomi_image']) && $post['nomi_image'] != '') {
						$arr_nomi['nomi_image'] = $post['nomi_image'][$key];
					}
					if (isset($post['nomi_front_id_image']) && $post['nomi_front_id_image'] != '') {
						$arr_nomi['nomi_front_id_image'] = $post['nomi_front_id_image'][$key];
					}
					if (isset($post['nomi_back_id_image']) && $post['nomi_back_id_image'] != '') {
						$arr_nomi['nomi_back_id_image'] = $post['nomi_back_id_image'][$key];
					}
					$result_nominie = $this->insert($arr_nomi, 'nominee');
				}
			}

			if (!($result_nominie)) {
				$this->obj_imsg->setMessage('Error Occur. Please try again later.', 'error');
				redirect_header(ADMIN_URL . 'ledgers.php');
			}
		}
	}

	function updateRecord($post)
	{
		if(isset($_REQUEST['edit_ledger_id']) && intval($_REQUEST['edit_ledger_id'])>0){
			$_REQUEST['ledger_id']=intval($_REQUEST['edit_ledger_id']);
		}
		$id = intval($post['ledger_id']);
		// print_r($id);
		// die();

		if ($post['contact_type'] == 'supplier') {

			$suplier_ledger = 'yes';
		} else {

			$suplier_ledger = 'no';
		}
		if ($post['contact_type'] == 'customer') {
			$customer_ledger = 'yes';
		} else {
			$customer_ledger = 'no';
		}
		if ($post['contact_type'] == 'simple') {
			$simple_ledger = 'yes';
		} else {
			$simple_ledger = 'no';
		}
		if ($post['cash'] == '') {
			$cash = 'no';
		} else {
			$cash = 'yes';
		}
		if ($post['bank'] == '') {
			$bank = 'no';
		} else {
			$bank = 'yes';
		}
		if ($post['employee'] == '') {
			$employee = 'no';
		} else {
			$employee = 'yes';
		}
		if ($post['contact_type'] == 'customer') {
			$customer_group = $post['customer_group'];
		}
		
		if ($post['individual'] == 'individual') {
			$indiv='yes';
		}else{
			$indiv='no';
		}
		if ($post['business'] == 'business') {
			$business='yes';
			$l_name=$post['business_name'];
		}else{
			$business='no';
			$l_name=$post['first_name'];

		}

		if ($post['shipping_address'] != '') {
			$shipping_address = $post['shipping_address'];
		}

		$first_name = $post['first_name'];
		$dob = $post['date_birth'];
		$prefix = $post['prefix'];
		$company_name = $post['business_name'];




		$arr = array(
			'active_supplier' => $suplier_ledger,
			'active_customer' => $customer_ledger,
			'simple_ledger' => $simple_ledger,
			'contact_id' => intval($post['contact_id']),
			'indvidual' => $indiv,
			'business' => $business,
			'prefix' => $prefix,
			'name' => $l_name,
			'under_group' => $customer_group,
			'opening_balance' => $post['opening_blnce'],
			'address' => $post['address_line1'],
			'permanent_address' => $post['address_lin2'],
			'company_name' => $company_name,
			'assinged' => $post['assinged_to'],
			'dob' => $dob,
			'ntn' => $post['tax_number'],
			'mobile' => $post['mob_no'],
			'email' => $post['email'],
			'phone_office' => $post['land_number'],
			'pay_term' => $post['pay_cond'],
			'pay_due' => $post['pay_term'],
			'city' => $post['city'],
			'state' => $post['state'],
			'country' => $post['country'],
			'zip_code' => $post['zip_code'],
			'postal_address' => $post['shiping_address'],
			'created_at' => time(),
			'updated_at' => time(),
			'company_id' => intval(1),
			'user_id' => getUSerId(),
			'parent_company' => intval(1),
			"created_by" => getUSerId(),
			'cash' => $cash,
			'bank' => $bank,
			'employee' => $employee,
			'shipping_address'=>$shipping_address
		);
		// echo '<pre>';
		// print_r($post);
		// print_r($arr);
		// die();


		$result_id = $this->update($id, $arr, $this->table);
		$result_id = $id;
		// print_r($result_id);
		// die();
		if ($result_id) {


			$this->query("delete from ledger_fields where ledger_supp_id=".$id);
			
			$ledger_supp_field = array();
			foreach ($post['Customer_filed'] as $key => $value) {
				if ($post['Customer_filed'][$key] != "") {
					$ledger_supp_field['name'] = $post['Customer_filed'][$key];
					$ledger_supp_field['ledger_supp_id'] = $id;
					$ledger_supp_field['user_id'] = getUSerId();
					$ledger_supp_field['company_id'] = intval(1);
					$ledger_supp_field['created_at'] = time();
					$ledger_supp_field['updated_at'] = time();
					$ledger_supp_field['updated_by'] = getUSerId();
					$op_result = $this->insert($ledger_supp_field, 'ledger_fields');
				}
			}
		}
		return $result_id;
	}

	function convertSubledgerToLedger($subledger_id, $new_ledger)
	{
		if (isset($new_ledger) && intval($new_ledger) > 0) {
			$subledger = $this->fetch_array_by_query("Select * from sub_ledgers where id = " . $subledger_id);
			$conversion = array();
			$conversion['sub_ledger_id'] = $subledger_id;
			$conversion['sub_parent'] = $subledger['ledger_id'];
			$conversion['ledger_id'] = $new_ledger;
			$SubledgerToLedger = $this->insert($conversion, 'subledger_to_ledger');
			if ($SubledgerToLedger) {
				$this->Select("Select * from transactions where ledger_id = " . $subledger['ledger_id'] . " and sub_ledger_id  = " . $subledger['id']);
				$transactions = $this->fetch_all();
				foreach ($transactions as $tr) {
					$temp_arr  = array();
					$temp_arr['trans_id'] = $tr['id'];
					$temp_arr['ledger_id'] = $tr['ledger_id'];
					$temp_arr['sub_ledger_id'] = $tr['sub_ledger_id'];
					$temp_arr['voucher_id'] = $tr['voucher_id'];
					$temp_arr['new_ledger'] = $new_ledger;
					$temp = $this->insert($temp_arr, 'temp_transactions');
					if ($temp) {
						$res = $this->update($tr['id'], array('ledger_id' => $new_ledger), 'transactions');
						if ($res) {
							$res2 = $this->update($tr['id'], array('sub_ledger_id' => 0), 'transactions');
						}
					}
				}

				$this->Select("Select * from sale_invoice where customer_id = " . $subledger['ledger_id'] . " and sub_ledger_id = " . $subledger['id']);
				$sales = $this->fetch_all();
				foreach ($sales as $s) {
					$this->select("Select * from s_invoice_transaction where s_i_id = " . $s['id']);
					$s_trans = $this->fetch_all();
					foreach ($s_trans as $st) {
						$this->select("Select * from sale_invoice_inventory where receipt_id = " . $s['id'] . " and receipt_transaction_id = " . $st['id']);
						$s_invs = $this->fetch_all();
						foreach ($s_invs as $inv) {
							$this->update($inv['id'], array('debit_ledger_id' => $new_ledger), 'sale_invoice_inventory');
						}
						$this->update($st['id'], array('customer_id' => $new_ledger, 'debit_ledger_id' => $new_ledger), 's_invoice_transaction');
					}
					$this->update($s['id'], array('customer_id' => $new_ledger, 'sub_ledger_id' => 0), 'sale_invoice');
				}

				$this->Select("Select * from dc_challan where debit_ledger_id = " . $subledger['ledger_id'] . " and sub_ledger_id = " . $subledger['id']);
				$challans = $this->fetch_all();
				foreach ($challans as $c) {
					$this->select("Select * from dc_transaction where dc_challan_id = " . $c['id']);
					$s_trans = $this->fetch_all();
					foreach ($s_trans as $st) {
						$this->select("Select * from dc_inventory where dc_challan_id = " . $c['id'] . " and dc_transaction_id = " . $st['id']);
						$s_invs = $this->fetch_all();
						foreach ($s_invs as $inv) {
							$this->update($inv['id'], array('debit_ledger_id' => $new_ledger), 'dc_inventory');
						}
						$this->update($st['id'], array('customer_id' => $new_ledger), 'dc_transaction');
					}
					$quotation = $this->update($c['id'], array('debit_ledger_id' => $new_ledger, 'sub_ledger_id' => 0), 'dc_challan');
					if ($quotation) {
						$this->select("Select * from quotation_inventory where dc_challan_id = " . $c['id']);
						$quotations = $this->fetch_all();
						foreach ($quotations as $q) {
							$this->update($q['id'], array('ledger_id' => $new_ledger), 'quotation_inventory');
						}
						$this->select("Select * from sales_inventory where dc_challan_id = " . $c['id']);
						$sales = $this->fetch_all();
						foreach ($sales as $s) {
							$this->update($s['id'], array('ledger_id' => $new_ledger), 'sales_inventory');
						}
					}
				}
				$this->Select("Select * from sale_return where customer_id = " . $subledger['ledger_id'] . " and sub_ledger_id = " . $subledger['id']);
				$returns = $this->fetch_all();
				foreach ($returns as $r) {
					$this->select("Select * from s_return_transaction where s_r_id = " . $r['id']);
					$s_trans = $this->fetch_all();
					foreach ($s_trans as $st) {
						$this->select("Select * from sale_return_inventory where receipt_id = " . $r['id'] . " and receipt_transaction_id = " . $st['id']);
						$s_invs = $this->fetch_all();
						foreach ($s_invs as $inv) {
							$this->update($inv['id'], array('debit_ledger_id' => $new_ledger), 'sale_return_inventory');
						}
						$this->update($st['id'], array('debit_ledger_id' => $new_ledger, 'customer_id' => $new_ledger), 's_return_transaction');
					}
					$r_quotation = $this->update($r['id'], array('customer_id' => $new_ledger, 'sub_ledger_id' => 0), 'sale_return');
					$this->select("Select * from voucher where sale_return = " . $r['id']);
					$vouchers = $this->fetch_all();
					foreach ($vouchers as $vc) {
						$this->select("Select * from quotation_inventory where voucher_id = " . $vc['id']);
						$quotations = $this->fetch_all();
						foreach ($quotations as $q) {
							$this->update($q['id'], array('ledger_id' => $new_ledger), 'quotation_inventory');
						}
					}
				}
				$this->Select("Select * from sale_order where customer_id = " . $subledger['ledger_id'] . " and sub_ledger_id = " . $subledger['id']);
				$orders = $this->fetch_all();
				foreach ($orders as $o) {
					$this->select("Select * from s_order_transaction where order_id = " . $o['id']);
					$s_trans = $this->fetch_all();
					foreach ($s_trans as $st) {
						$this->select("Select * from sale_order_inventory where order_id = " . $o['id'] . " and o_transaction_id = " . $st['id']);
						$s_invs = $this->fetch_all();
						foreach ($s_invs as $inv) {
							$this->update($inv['id'], array('debit_ledger_id' => $new_ledger), 'sale_order_inventory');
						}
						$this->update($st['id'], array('customer_id' => $new_ledger, 'debit_ledger_id' => $new_ledger), 's_order_transaction');
					}
					$this->update($o['id'], array('customer_id' => $new_ledger, 'sub_ledger_id' => 0), 'sale_order');
				}
				$subledger = $this->update($subledger_id, array('locked' => 'yes'), 'sub_ledgers');
			}
		}
	}

	function update_nominee($request, $id, $post)
	{

		if (isset($request['nominee']) && $request['nominee'] == 'yes') {
			if (isset($request['nomi_name']) && $request['nomi_name'] != '') {
				foreach ($request['nomi_name'] as $key => $value) {
					$arr_nomi['nomi_name'] = $request['nomi_name'][$key];
					$nomi_nic = str_replace("-", "", strval($request['nomi_nic'][$key]));
					$arr_nomi['nomi_nic'] = $nomi_nic;
					$arr_nomi['type'] = $request['type_nominee'][$key];
					$arr_nomi['f_h_relation'] = $request['f_h_relation'][$key];
					$arr_nomi['nomi_father_husband'] = $request['nomi_father_husband'][$key];
					$arr_nomi['nomi_address'] = $request['nomi_address'][$key];
					$arr_nomi['nomi_permanent_address'] = $request['nomi_permanent_address'][$key];
					$arr_nomi['nomi_relation'] = $request['nomi_relation'][$key];
					$arr_nomi['nomi_dob'] = $request['nomi_dob'][$key];
					$arr_nomi['nomi_country'] = $request['nomi_country'][$key];
					$arr_nomi['nomi_city'] = $request['nomi_city'][$key];
					$arr_nomi['nomi_phone'] = $request['nomi_phone'][$key];
					$nomi_mobile = str_replace("-", "", strval($request['nomi_mobile'][$key]));
					$arr_nomi['nomi_mobile'] = '+92' . $nomi_mobile;
					$arr_nomi['nomi_fax'] = $request['nomi_fax'][$key];
					$arr_nomi['nomi_email'] = $request['nomi_email'][$key];
					$arr_nomi['ledger_id'] = $id;
					$arr_nomi['created_at'] = time();
					$arr_nomi['updated_at'] = time();
					$arr_nomi['company_id'] = getCompanyId();
					$arr_nomi['user_id'] = getUSerId();

					if ($post['nomi_image'] != '') {
						$arr_nomi['nomi_image'] = $post['nomi_image'][$key];
					}
					if ($post['nomi_front_id_image'] != '') {
						$arr_nomi['nomi_front_id_image'] = $post['nomi_front_id_image'][$key];
					}
					if ($post['nomi_back_id_image'] != '') {
						$arr_nomi['nomi_back_id_image'] = $post['nomi_back_id_image'][$key];
					}
					if ($request['nomineee_id'][$key] != '') {
						$result_nominie = $this->update($request['nomineee_id'][$key], $arr_nomi, 'nominee');
					} else {
						$result_nominie = $this->insert($arr_nomi, 'nominee');
					}
				}
			}

			if (!($result_nominie)) {
				$this->obj_imsg->setMessage('Error Occur. Please try again later.', 'error');
				redirect_header(ADMIN_URL . 'ledgers.php');
			}
		}
	}

	function getRow($id)
	{
		$id = $id;
		$row = $this->fetch_array_by_query('select * from ' . $this->table . " where find_in_set(" . getCompanyId() . ",company_id) and id=" . $id);
		return $row;
	}

	function getAllRecords()
	{
		$query = 'select l.*,n.name as nature_group from ' . $this->table . ' as l , ledger_group n  where   n.id=l.under_group and l.company_id=' . getCompanyId() . '   order by l.id desc';
		$this->select($query);
		$ledgers = $this->fetch_all();
		return $ledgers;
	}
	function add_company_docuemnts($array, $type, $ledger_id)
	{

		foreach ($array as $arr) {
			$doc_arr = array();
			$doc_arr['ledger_id'] = $ledger_id;
			$doc_arr['type'] = $type;
			$doc_arr['image_name'] = $arr;
			$doc_arr['created_by'] = getUSerId();
			$doc_arr['updated_by'] = getUSerId();
			$doc_arr['company_id'] = getCompanyId();
			$doc_arr['created_at'] = time();
			$doc_arr['updated_at'] = time();
			$this->insert($doc_arr, 'company_documents');
		}
	}
}
