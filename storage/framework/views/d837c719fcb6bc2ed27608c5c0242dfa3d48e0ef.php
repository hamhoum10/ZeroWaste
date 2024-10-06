<?php
  $containerNav = $containerNav ?? 'container-fluid';
  $navbarDetached = $navbarDetached ?? '';

?>

  <!-- Navbar -->
<?php if(isset($navbarDetached) && $navbarDetached == 'navbar-detached'): ?>
  <nav
    class="layout-navbar <?php echo e($containerNav); ?> navbar navbar-expand-xl <?php echo e($navbarDetached); ?> align-items-center bg-navbar-theme"
    id="layout-navbar">
    <?php endif; ?>
    <?php if(isset($navbarDetached) && $navbarDetached == ''): ?>
      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="<?php echo e($containerNav); ?>">
          <?php endif; ?>

          <!--  Brand demo (display only for navbar-full and hide on below xl) -->
          <?php if(isset($navbarFull)): ?>
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
              <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                <?php echo $__env->make('_partials.macros', ['width' => 25, 'withbg' => '#696cff'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </span>
                <span class="app-brand-text demo menu-text fw-bolder"><?php echo e(config('variables.templateName')); ?></span>
              </a>
            </div>
          <?php endif; ?>

          <!-- ! Not required for layout-without-menu -->
          <?php if(!isset($navbarHideToggle)): ?>
            <div
              class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0<?php echo e(isset($menuHorizontal) ? ' d-xl-none ' : ''); ?> <?php echo e(isset($contentNavbar) ? ' d-xl-none ' : ''); ?>">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
          <?php endif; ?>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                       aria-label="Search...">
              </div>
            </div>
            <!-- /Search -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">

              <a href="<?php echo e(route('cart.index')); ?>">
                <i class="menu-icon bx bx-cart"></i>
              </a>

              <!-- Place this tag where you want the button to render. -->
              <li class="nav-item lh-1 me-3">
                <a class="github-button" href="https://github.com/themeselection/sneat-html-laravel-admin-template-free"
                   data-icon="octicon-star" data-size="large" data-show-count="true"
                   aria-label="Star themeselection/sneat-html-laravel-admin-template-free on GitHub">Star</a>
              </li>

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="<?php echo e(asset('assets/img/avatars/1.png')); ?>" alt class="w-px-40 h-auto rounded-circle">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="<?php echo e(asset('assets/img/avatars/1.png')); ?>" alt
                                 class="w-px-40 h-auto rounded-circle">
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block"><?php echo e($connectedUser->name); ?></span>
                          <small class="text-muted"><?php echo e($connectedUser->role); ?></small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class='bx bx-cog me-2'></i>
                      <span class="align-middle">Settings</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            <span
                              class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                      <?php echo csrf_field(); ?>
                    </form>
                    <a class="dropdown-item" href="javascript:void(0);"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class='bx bx-power-off me-2'></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>

          <?php if(!isset($navbarDetached)): ?>
        </div>
        <?php endif; ?>
      </nav>
      <!-- / Navbar -->
<?php /**PATH C:\Users\selim\OneDrive\Bureau\ZeroWaste Laravel\resources\views/layouts/sections/navbar/navbar.blade.php ENDPATH**/ ?>