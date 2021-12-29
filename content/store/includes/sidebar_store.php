<?php
$user_id = $_SESSION['user_id'];
$function_id = $user->get_user_info($user_id, "user_function");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page-sidebar">
    <a class="logo-box" href="warehouse.php">
        <span><?php echo get_option('site_name'); ?></span>

        <i class="icon-close" id="sidebar-toggle-button-close"></i>
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                <li class="active-page">
                    <a href="warehouse.php">
                        <i class="menu-icon icon-home4"></i><span>Dashboard</span>
                    </a>
                </li>


                <!-- from MAddy -->
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-credit-card"></i><span>Orders <i class="accordion-icon fa fa-angle-right"></i> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="store_owner_orders_list.php"><span class="text-success"><i class="fa fa-caret-right"></i> All Orders</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-truck"></i><span>Tracking <i class="accordion-icon fa fa-angle-right"></i> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="track_order.php"><span class="text-success"><i class="fa fa-caret-right"></i> Track Order</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-dollar"></i><span>Payments <i class="accordion-icon fa fa-angle-right"></i> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="store_payment_list.php"><span class="text-success"><i class="fa fa-caret-right"></i> Transaction History</span></a></li>
                    </ul>
                </li>



            </ul>
        </div>
    </div>
</div><!-- /Page Sidebar -->