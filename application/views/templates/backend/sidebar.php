<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Fajrian Portfolio</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- QUERY MENU -->
    <?php
    $role_id = $this->session->userdata('role_id');
    $query_menu = "SELECT `menus`.`id`, `menu` 
                        FROM `menus`
                        JOIN `user_access_menus` ON `menus`.`id` = `user_access_menus`.`menu_id`
                        WHERE `user_access_menus`.`role_id` = $role_id
                        ORDER BY `user_access_menus`.`menu_id` ASC";
    $menu = $this->db->query($query_menu)->result_array();
    ?>

    <!-- LOOPING MENU -->
    <?php foreach ($menu as $m) : ?>
        <div class="sidebar-heading">
            <?php echo $m['menu']; ?>
        </div>
        <?php
        $menu_id = $m['id'];
        $query_menu_detail = "SELECT *
                    FROM `menu_details`
                    JOIN `menus` ON `menus`.`id` = `menu_details`.`menu_id`
                    WHERE `menu_details`.`menu_id` = $menu_id 
                    AND `menu_details`.`is_active` = 1";
        $menu_detail = $this->db->query($query_menu_detail)->result_array();
        ?>
        <?php foreach ($menu_detail as $md) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url($md['url']) ?>">
                    <i class="<?php echo $md['icon'] ?>"></i>
                    <span><?php echo $md['title'] ?></span></a>
            </li>
        <?php endforeach; ?>

    <?php endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->