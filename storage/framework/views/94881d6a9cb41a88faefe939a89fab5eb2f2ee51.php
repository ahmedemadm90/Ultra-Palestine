<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="<?php echo e(route('dashboard')); ?>">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>" class="header-brand-img desktop-logo w-50 m-auto p-2"
                    alt="logo">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>" class="header-brand-img toggle-logo"
                    alt="logo">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>" class="header-brand-img light-logo"
                    alt="logo">
                <img src="<?php echo e(asset('assets/images/brand/logo.png')); ?>"
                    class="header-brand-img light-logo1 w-50 m-auto p-2" alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>الرئيسية</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="<?php echo e(route('dashboard')); ?>"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">لوحة التحكم</span></a>
                </li>
                <li class="sub-category">
                    <h3>أدارة التطبيق</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">المستخدمين</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('users.index')); ?>" class="slide-item"> المستخدمين</a></li>
                        <li><a href="<?php echo e(route('drivers.index')); ?>" class="slide-item"> السائقين</a></li>
                        <li><a href="<?php echo e(route('users.create')); ?>" class="slide-item">مستخدم جديد</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">المناطق</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('areas.index')); ?>" class="slide-item"> المناطق</a></li>
                        <li><a href="<?php echo e(route('areas.create')); ?>" class="slide-item"> منطقة جديدة</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">القرى</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('villages.index')); ?>" class="slide-item"> القرى</a></li>
                        <li><a href="<?php echo e(route('villages.create')); ?>" class="slide-item">قرية جديدة</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">الطرود</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('packages.index')); ?>" class="slide-item"> الطرود</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">مكاتب شركتنا</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('offices.index')); ?>" class="slide-item"> مكاتب شركتنا</a></li>
                        <li><a href="<?php echo e(route('offices.create')); ?>" class="slide-item"> أضافة مكتب جديد</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-slack"></i><span class="side-menu__label">الحركات المالية</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Apps</a></li>
                        <li><a href="<?php echo e(route('transactions.index')); ?>" class="slide-item"> سجل الحركات المالية</a></li>
                    </ul>
                </li>
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>
<?php /**PATH /home/u447710865/domains/jaberandrabiacompanyforlogistics.com/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>