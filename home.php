<?php session_start();

include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$function = new custom_functions;
date_default_timezone_set('Asia/Kolkata');
// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;
// if session not set go to login page
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}
$date = date('Y-m-d');
// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;
$function = new custom_functions;
include "header.php";
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pocket Farm- Dashboard</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Home</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                </li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php
                            $sql = "SELECT id FROM users ";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-orange">
                        <div class="inner">
                        <h3><?php
                            $branch_id = (isset($_POST['branch_id']) && $_POST['branch_id']!='') ? $_POST['branch_id'] :"";
                            if ($branch_id != '') {
                                $join1="AND users.branch_id='$branch_id'";
                            } else {
                                $join1="";
                            }
                            $sql = "SELECT SUM(withdrawals.amount) AS amount,withdrawals.user_id,users.id FROM withdrawals,users WHERE withdrawals.user_id=users.id AND withdrawals.status=0 $join1";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $totalamount = $res[0]['amount'];
                            echo "Rs.".$totalamount;
                             ?></h3>
                            <p>Unpaid Withdrawals</p>
                        </div>
                        
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php
                             $sql = "SELECT SUM(recharge_amount) AS recharge_amount  FROM recharge WHERE recharge.status=0 ";
                             $db->sql($sql);
                             $res = $db->getResult();
                             $totalamount = $res[0]['recharge_amount'];
                             echo "Rs.".$totalamount;
                              ?></h3>
                            <p>Pending Recharge</p>
                        </div>
                       
                        <a href="recharge.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php
                             $sql = "SELECT SUM(recharge_amount) AS recharge_amount  FROM recharge WHERE recharge.status=1 ";
                             $db->sql($sql);
                             $res = $db->getResult();
                             $totalamount = $res[0]['recharge_amount'];
                             echo "Rs.".$totalamount;
                              ?></h3>
                            <p>Today Recharge Amount</p>
                        </div>
                       
                        <a href="recharge.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        
                    </div>
                </div>
             </div>
        </section>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>