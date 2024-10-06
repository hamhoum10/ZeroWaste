

<?php $__env->startSection('title', 'Register Basic - Pages'); ?>

<?php $__env->startSection('page-style'); ?>
  <!-- Page -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/pages/page-auth.css')); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">

        <!-- Register Card -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
                <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros',["width"=>25,"withbg"=>'#696cff'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></span>
                <span class="app-brand-text demo text-body fw-bolder"><?php echo e(config('variables.templateName')); ?></span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Adventure starts here 🚀</h4>
            <p class="mb-4">Make your app management easy and fun!</p>

            <form id="formAuthentication" class="mb-3" action="<?php echo e(route('register-basic')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username"
                       autofocus>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                         placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                         aria-describedby="password"/>
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                       placeholder="Confirm your password">
              </div>
              <button class="btn btn-primary d-grid w-100">Sign up</button>
            </form>


            <p class="text-center">
              <span>Already have an account?</span>
              <a href="<?php echo e(url('auth/login-basic')); ?>">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/blankLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\selim\OneDrive\Bureau\ZeroWaste Laravel\resources\views/content/authentications/auth-register-basic.blade.php ENDPATH**/ ?>