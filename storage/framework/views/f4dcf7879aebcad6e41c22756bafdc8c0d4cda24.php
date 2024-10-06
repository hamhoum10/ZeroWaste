

<?php $__env->startSection('title', 'Login Basic - Pages'); ?>

<?php $__env->startSection('page-style'); ?>
<!-- Page -->
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/pages/page-auth.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
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
          <h4 class="mb-2">Welcome to <?php echo e(config('variables.templateName')); ?>! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          <form id="formAuthentication" class="mb-3" action="<?php echo e(route('login-basic')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <label for="password" class="form-label">Password</label>
              <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>


          <p class="text-center">
            <span>New on our platform?</span>
            <a href="<?php echo e(url('auth/register-basic')); ?>">
              <span>Create an account</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/blankLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\selim\OneDrive\Bureau\ZeroWaste Laravel\resources\views/content/authentications/auth-login-basic.blade.php ENDPATH**/ ?>