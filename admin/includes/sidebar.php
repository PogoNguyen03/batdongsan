<?php
// Lấy tên file hiện tại để xác định active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="bi bi-house"></i>
                    Quản lý bất động sản
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'contacts.php' ? 'active' : ''; ?>" href="contacts.php">
                    <i class="bi bi-envelope"></i>
                    Quản lý liên hệ
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'seo_settings.php' ? 'active' : ''; ?>" href="seo_settings.php">
                    <i class="bi bi-graph-up"></i>
                    Quản lý SEO
                </a>
            </li> -->
        </ul>
    </div>
</nav> 