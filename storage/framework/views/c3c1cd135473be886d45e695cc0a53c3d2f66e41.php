<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal " href="<?php echo e(route('dashboard')); ?>">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>" class="header-brand-img desktop-logo w-10"
                    alt="logo">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>" class="header-brand-img light-logo1 w-10"
                    alt="logo">
            </a>
            <!-- LOGO -->
            
            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">

                            <!-- COUNTRY -->
                            <div class="d-flex country">
                                <a class="nav-link icon text-center" data-bs-target="#country-selector"
                                    data-bs-toggle="modal">
                                    <i class="fe fe-globe"></i><span class="fs-16 ms-2 d-none d-xl-block">English</span>
                                </a>
                            </div>
                            <!-- SEARCH -->
                            <div class="dropdown  d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <!-- Theme-Layout -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
                            <!-- FULL-SCREEN -->
                            
                            
                            <!-- SIDE-MENU -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                    class="nav-link leading-none d-flex">
                                    <?php if(auth()->user()->image != null): ?>
                                    <img src="<?php echo e(asset('media/users/profiles/'.auth()->user()->image)); ?>" alt="profile-user"
                                        class="avatar  profile-user brround cover-image">
                                    <?php else: ?>
                                    <img src="<?php echo e(asset('assets/images/users/temp.png')); ?>" alt="profile-user"
                                        class="avatar  profile-user brround cover-image">
                                    <?php endif; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <div class="drop-heading">
                                        <div class="text-center">
                                            <h5 class="text-dark mb-0 fs-14 fw-semibold"><?php echo e(auth()->user()->fname); ?>

                                                <?php echo e(auth()->user()->lname); ?></h5>
                                            <small class="text-muted"><?php echo e(auth()->user()->role->role_name); ?></small>
                                        </div>
                                    </div>
                                    
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">
                                        <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->
<?php /**PATH /storage/ssd1/003/20002003/resources/views/layouts/navbar.blade.php ENDPATH**/ ?>