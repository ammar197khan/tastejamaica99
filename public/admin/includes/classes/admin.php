<?php
	class Admin {
		private $db;
		private $table_name='admin';
		private $imsg;
		function __construct() {
			$this->db=load_class('Database');
			$this->imsg=load_class('InfoMessages');
		}
		function delete_admin($admin_id) {
			$result=$this->db->delete($admin_id, $this->table_name);
			if ($result) {
				$this->imsg->setMessage("Admin is Successfully Deleted!");
			} else {
				$this->imsg->setMessage("Problem Occured While Deleting Admin Details!", "error");
			}
			redirect_header(ADMIN_URL."admin-user.php");
		}
		function get_admin_row($admin_id) {
			if ($admin_id>1) {
				$admin_row=$this->db->get_row($admin_id, $this->table_name);
				return $admin_row;
			} else {
				return false;
			}
		}
		function update_admin($post) {
			$permission=json_encode($post['chk']);
			$check_arr=array($post['email']);
			$query="select * from ".$this->table_name." where id>1 and email=?";
			$c_result=$this->db->fetch_array_by_query($query, $check_arr);
			$count_rows=$this->db->num_rows($c_result);
			if ($count_rows>0 && $c_result['id']!=$post['id']) {
				$this->imsg->setMessage("Email : ".$post['email']." Already Exist!", "error");
				redirect_header(ADMIN_URL."edit-admin.php");
			} else {
				$arr=array('name'=>$post['name'],'email'=>$post['email'],'username'=>$post['username'],'password'=>md5($post['password']),'permissions'=>$permission);
				if ($post['changepass']=='yes') {
					$arr['password']=md5($post['password']);
				}
				$result=$this->db->update($post['id'], $arr, $this->table_name);
				if ($result) {
					$this->imsg->setMessage("Admin Details Updated Successfully!");
					redirect_header(ADMIN_URL."admin-user.php");
				} else {
					$this->imsg->setMessage("Problem Occured While Updating Admin Details!", "error");
					redirect_header(ADMIN_URL."edit-admin.php?command=edit&id=".$post['id']);
				}
			}
		}
		function add_admin($post) {
			$permission=json_encode($post['chk']);
			$check_arr=array($post['email']);
			$query="select * from ".$this->table_name." where email=?";
			$c_result=$this->db->select($query, $check_arr);
			$count_rows=$this->db->num_rows($c_result);//echo $count_rows;die();
			if ($count_rows>0) {
				$this->imsg->setMessage("Email : ".$post['email']." Already Exist!", "error");
				redirect_header("add-admin-user.php");
			} else {
				$arr=array('name'=>$post['name'],'email'=>$post['email'],'username'=>$post['username'],'password'=>md5($post['password']),'permissions'=>$permission);
				$result=$this->db->insert($arr, $this->table_name);
				if ($result) {
					$this->imsg->setMessage("Admin Details Added Successfully!");
					redirect_header(ADMIN_URL."admin-user.php");
				} else {
					$this->imsg->setMessage("Problem Occured While Adding Admin Details!", "error");
					redirect_header(ADMIN_URL."add-admin-user.php");
				}
			}
		}
		function fetch_admin() {
			$query="select * from ".$this->table_name." where id>1 order by id asc";
			$result=$this->db->query($query);
			$b_row=$this->db->fetch_all();
			return $b_row;
		}
		function update_admin_password($post, $mail) {
			$arr['password']=md5($post['password']);
			$arr['forgot_password']='no';
			$result=$this->db->update($post['id'], $arr, $this->table_name);
			$row=$this->db->get_row($post['id'], $this->table_name);
			if ($result) {
				$mail->sendEmail('change-password', $row['email'], '');
				$this->imsg->setMessage("Admin Password Updated Successfully! Please Log into Your Account.");
				redirect_header(ADMIN_URL."login.php");
			} else {
				$this->imsg->setMessage("Problem Occured While Updating Admin Password!", "error");
				redirect_header(ADMIN_URL."edit-admin.php?auth=".$post['auth']."&id=".$post['id']);
			}
		}
	}
?>