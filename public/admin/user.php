<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/site-master.php') ?>
    <style type="text/css">
        body {
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        #wrapper #content-wrapper {
            background-color: #f8f9fe !important;
        }

        .manage_user {
            color: #777;
            font-size: 14px !important;
        }

        .text_sup {
            color: #32325d;
            font-size: 22px;
            font-weight: 600;
        }

        .exp_card {
            padding: 15px;
            background-color: #fff;
            border-top: 3px solid #3c8dbc;
            border-radius: 6px;
        }

        .btn_add {
            background-color: #1367d1;
            color: #fff;
            border-color: #1367d1;
        }

        .border_th>th {
            color: #525f7f;
            font-size: 16px;
            border: 1px solid #e3e6f0;
        }

        .td_colour>td {
            color: #525f7f;
            font-size: 17px;
            border: 1px solid #e3e6f0;
        }

        .btn_close_modal {
            background-color: #ede9e9;
            border-color: #ede9e9;
        }

        .btn_save_modal {
            background-color: #1367d1;
            border-color: #1367d1;
            color: #fff;
        }

        .btn_default {
            background-color: #f4f4f4;
            color: #444;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .label_all {
            color: #525f7f;
            font-weight: 700;
            font-size: 18px;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .dataTables_info {
            color: #525f7f;
        }

        .all_supp {
            font-size: 17px;
            font-weight: 600;
            color: #32325d;
            letter-spacing: 1px;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php') ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('includes/header.php') ?>
                <!-- Topbar -->
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <h1 class="h3 mb-0 text_sup mb-3">User<span class="pl-2 manage_user">Manage Users</span></h1>
                    <div class="exp_card card">
                        <div class="d-flex justify-content-between  mb-4">
                            <div class="p-2 all_supp">All User</div>
                            <div class="p-2">
                                <a href="add-user.php" type="button" class="btn btn_add btn-sm" style="color: #fff;">
                                    <span class="pr-2"><i class="fa-solid fa-plus"></i></span>Add</a>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center  mb-3 pt-3">
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to CV</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-excel px-2"></i>Export to Excel</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-print px-2"></i>Print</div>
                            <div class="p-2 btn_default"> <i class="fa-regular fa-columns-3 px-2"></i>Coloumn Visibility</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to Pdf</div>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table table-striped align-items-center table-flush" id="dataTable">
                                <thead class="">
                                    <tr class="border_th">
                                        <th>User Name</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $db->select('select * from admin order by id desc');
                                    $users=$db->fetch_all();
                                    $json_data = json_encode($users);
                                    foreach($users as $user){
                                        // print_r($user);
                                        $role=$db->fetch_array_by_query('select * from roles where id='.intval($user['role_id']));
                                    ?>
                                    <tr class="td_colour">
                                        <td><?= $user['username']; ?></td>
                                        <td><?= $user['name']; ?></td>
                                        <td><?= $role['role']; ?></td>
                                        <td><?= $user['email']; ?></td>
                                        <td><?= $user['hint']; ?></td>
                                        <td>
                                            <a href="<?php echo 'edit-user.php?id='. $user['id']; ?>" class="btn btn-xs btn-primary py-0 px-2" id="page_link">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit</a>&nbsp;
                                            <a href="#" class="btn btn-xs btn-info py-0 px-2"><i class="fa fa-eye"></i> View</a>&nbsp;
                                            <button data-href="#" class="btn btn-xs btn-danger delete_user_button py-0 px-2"><i class="fa-sharp fa-solid fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <?php include('includes/footer.php') ?>
            <!-- Footer -->
        </div>
    </div>

    <?php include('includes/commonjs.php') ?>
    <script type="text/javascript">
        // function edit_model(val_this, id) {
        //         json_data = <?= $json_data; ?>;
        //         var selected_row = $.grep(json_data, function(item) {
        //             if (item.id == id) {
        //                 return item;
        //             }
        //         });
        //         try {
        //             var page_link = '';
        //             var decode_json = selected_row;
        //              var pageURL = $('#page_link').attr("href");
        //             console.log(pageURL);
        //             decode_json.forEach(function(obj) {
        //                 for (var key in obj) {
        //                     if (obj.hasOwnProperty(key)) {
        //                         var val = obj[key];
        //                         console.log(val);
        //                         // if(key=='cash'){
        //                         //  if(val=='yes'){
        //                         //      modal.find('#loc-'+key).prop('checked',true);
        //                         //  }else{
        //                         //      modal.find('#loc-'+key).prop('checked',false);
        //                         //  }
        //                         // }

        //                         // console.log(key + '  ' + val);
        //                         if (pageURL.find('.input-class-' + key).attr('type') != 'checkbox') {
        //                             pageURL.find('.input-class-' + key).val(val);
        //                         }
        //                     }
        //                 }

        //             });
        //             pageURL.find('#exampleModalLabel').html('');
        //             pageURL.find('#exampleModalLabel').html('Edit Product');
        //             // modal.modal('show');
        //         } catch (error) {
        //             console.log('invalid' + error);
        //         }

        //         // console.log(selected_row);

        //     }
    </script>
</body>

</html>