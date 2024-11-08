

<?php $__env->startSection('title', 'Store'); ?>

<?php $__env->startSection('vendor-script'); ?>
    <script src="<?php echo e(asset('assets/vendor/libs/masonry/masonry.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
    <script src="<?php echo e(asset('assets/js/ui-toasts.js')); ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the session has a success message
            <?php if(session('success')): ?>
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                // Show the toast
                toastList.forEach(toast => toast.show());
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Toast for Success -->
    <?php if(session('success')): ?>
        <div class="bs-toast toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-0 p-3 m-2"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo e(session('success')); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- The rest of your content -->

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products</span></h4>

    <!-- Examples -->
    <div class="row mb-5" data-masonry='{"percentPosition": true }'>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($product->name); ?></h5>
                        <h6 class="card-subtitle text-muted"><?php echo e($product->description); ?></h6>
                        <img class="img-fluid d-flex mx-auto my-4"
                            src="<?php echo e(asset('assets/img/products/' . $product->image_url)); ?>" alt="<?php echo e($product->name); ?>" />
                        <p class="card-text mb-0">Quantity: <?php echo e($product->quantity); ?></p>
                        <h3 class="card-text">Price: <?php echo e($product->price); ?> DT</h3>
                        <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="d-flex">
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>" />
                                    <input class="form-control me-3 w-50" name="quantity" type="number" value="1"
                                        min="1" max=<?php echo e($product->quantity); ?>

                                        <?php echo e($product->quantity === 0 ? 'disabled' : ''); ?> />
                                    <button class="btn btn-primary w-100" type="submit"
                                        <?php echo e($product->quantity === 0 ? 'disabled' : ''); ?>>Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\selim\OneDrive\Bureau\ZeroWaste Laravel\resources\views/marketplace/store.blade.php ENDPATH**/ ?>