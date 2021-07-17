<div class="main-content-wrap d-flex flex-column">
<div class="main-header">
    <div class="logo">
        <img src="{{ asset('admin/dist-assets/images/logo.png')}}" alt="">
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    
    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{ asset('admin/dist-assets/images/faces/1.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> Ademola Davies
                    </div>
                    <a class="dropdown-item" href="#">Profile Settings</a>
                    <a class="dropdown-item" href="#">Billing History</a>
                    <a onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="dropdown-item" href="index.php">Sign Out</a>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>