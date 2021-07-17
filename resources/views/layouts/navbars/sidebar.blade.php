<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item  active" data-item="admin">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Admin</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <i class="sidebar-close i-Close" (click)="toggelSidebar()"></i>
        <header>
            <div class="logo">
                <img src="{{ asset('admin/dist-assets/images/logo.png')}}" alt="">
            </div>
        </header>
        <!-- Submenu Dashboards -->
        
        <div class="submenu-area" data-parent="admin">
            <header>
                <h6>HQ Abuja</h6>
                <p>Super Admin</p>
                
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="admin-dashboard.php">
                        <i class="nav-icon i-Bar-Chart"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-profile.php">
                        <i class="nav-icon i-Bar-Chart"></i>
                        <span class="item-name">Profile</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="admin-users.php">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Admin Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-schools.php">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Training Schools</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-batch.php">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">MEPTP Batches</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-services.php">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Service Fees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin-invoices.php">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="item-name">Payments</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>