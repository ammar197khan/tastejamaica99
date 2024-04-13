<?php
class InfoMessages{
	public function setMessage($msg, $type='success'){
		$_SESSION['msg']=$msg;
		$_SESSION['msg_type']=$type;
	}
	public function getMessage($b=true){
		if($b==false){
			if (isset($_REQUEST['msg']) && $_REQUEST['msg']!=''){
				$message='<div class="alert alert-info alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><b><i class="icon fa fa-info"></i> Alert!</b>&nbsp;&nbsp;'.$_REQUEST['msg'].'</div>';
				return $message;
			}
		}else if ($b==true){
			if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){
				if($_SESSION['msg_type']=='error'){
					$message='<div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><b><i class="icon fa fa-ban"></i> Sorry!</b> '.$_SESSION['msg'].'</div>';
				}else if ($_SESSION['msg_type']=="success"){
					$message='<div class="alert alert-success alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><b><i class="icon fa fa-check"></i> Success!</b> '.$_SESSION['msg'].'</div>';
				}
				unset($_SESSION['msg']);
				unset($_SESSION['msg_type']);
				return $message;
			}
		}
	}
}
$imsg=new InfoMessages();
?>