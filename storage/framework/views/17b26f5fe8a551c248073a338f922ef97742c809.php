

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col" style="text-align: right; margin: auto">
            <img src="<?php echo e('/storage/shops/logos/' . $ecommerce->logo); ?>" alt="">
        </div>

        <div class="col">
            <h1><?php echo e($ecommerce->name); ?></h1>

            <?php if($ecommerce->nit): ?>
                <p>NIT: <?php echo e($ecommerce->nit); ?></p>
            <?php endif; ?>

            <?php if($ecommerce->address): ?>
                <p>Dirección: <?php echo e($ecommerce->address); ?></p>
            <?php endif; ?>

            <?php if($ecommerce->phone): ?>
                <p>Dirección: <?php echo e($ecommerce->phone); ?></p>
            <?php endif; ?>

            <?php if($ecommerce->email): ?>
                <p>Correo electrónico: <?php echo e($ecommerce->email); ?></p>
            <?php endif; ?>

            <div>
                <?php if($ecommerce->facebook): ?>
                    <a style="margin-right: 10px" target="_blank" href="<?php echo e($ecommerce->facebook); ?>">
                        <i class="fab fa-facebook"></i>
                    </a>
                <?php endif; ?>

                <?php if($ecommerce->instagram): ?>
                    <a style="margin-right: 10px" target="_blank" href="<?php echo e($ecommerce->instagram); ?>">
                        <i class="fab fa-instagram"></i>
                    </a>
                <?php endif; ?>

                <?php if($ecommerce->google): ?>
                    <a style="margin-right: 10px" target="_blank" href="<?php echo e($ecommerce->google); ?>">
                        <i class="fab fa-google"></i>
                    </a>
                <?php endif; ?>

                <?php if($ecommerce->youtube): ?>
                    <a style="margin-right: 10px" target="_blank" href="<?php echo e($ecommerce->youtube); ?>">
                        <i class="fab fa-youtube"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col" style="text-align: center;">
            <img src="<?php echo e('/storage/shops/banners/' . $ecommerce->banner); ?>" alt="">

            <form class="mt-5">
                <div class="input-group">
                    <button class="btn btn-secondary toggle-categories" type="button">
                        <i class="fa fa-bars"></i>
                    </button>

                    <input type="text" name="search" class="form-control" value="<?php echo e($request->search); ?>" placeholder="Ingrese el nombre del producto que desea buscar...">

                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> 
                        Buscar
                    </button>
                </div>
            </form>

            <div class="mt-5 categories d-none">
                <ul class="list-group">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item"><?php echo e($category->name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 100px">
        <hr>

        <h3>Productos</h3>

        <div class="col">
            <div class="row">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img class="img-fluid" src="<?php echo e('/storage/uploads/pro_image/' . $product->pro_image); ?>" alt="">
                                
                                <?php echo e($product->name); ?> <br>

                                Precio: <?php echo e($product->sale_price); ?> <br>

                                <div class="mt-3">
                                    <form class="add-to-order">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" min="1" placeholder="Ingrese cantidad">

                                            <input type="hidden" name="id_product" value="<?php echo e($product->id); ?>">

                                            <button type="submit" title="Agregar al pedido" class="btn btn-primary">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function () {
            $('.add-to-order').submit(function (event) {
                event.preventDefault();

                quantity = $(this).find('[name=quantity]').val();
                id_product = $(this).find('[name=id_product]').val();

                console.log(quantity, id_product);
            });

            $('.toggle-categories').click(function () {
                hasClass = $('.categories').hasClass('d-none');

                if (hasClass) {
                    $('.categories').removeClass('d-none');
                } else {
                    $('.categories').addClass('d-none');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.shop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/i9finance/public_html/resources/views/shops/index.blade.php ENDPATH**/ ?>