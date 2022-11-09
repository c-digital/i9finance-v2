
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('E-Commerce')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('E-Commerce')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(array('url' => 'ecommerce','enctype' => "multipart/form-data"))); ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Información básica</div>

                    <div class="card-body">                    
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" name="name" required value="<?php echo e($ecommerce->name ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" name="logo">

                                    <div class="mt-3">
                                        <?php if(isset($ecommerce->logo)): ?>
                                            <img src="<?php echo e('/storage/shops/logos/' . $ecommerce->logo); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control" name="phone" required value="<?php echo e($ecommerce->phone ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" class="form-control" name="email" required value="<?php echo e($ecommerce->email ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control" name="address" required value="<?php echo e($ecommerce->address ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Título</label>
                                    <input type="text" class="form-control" name="title" required value="<?php echo e($ecommerce->title ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <input type="text" class="form-control" name="description" required value="<?php echo e($ecommerce->description ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type">Tipo</label>

                                    <select name="type" class="form-control">
                                        <option value=""></option>
                                        <option <?php echo e(isset($ecommerce->type) && $ecommerce->type == 'Empresa' ? '' : null); ?> value="Empresa">Empresa</option>
                                        <option <?php echo e(isset($ecommerce->type) && $ecommerce->type == 'Productor' ? '' : null); ?> value="Productor">Productor</option>
                                        <option <?php echo e(isset($ecommerce->type) && $ecommerce->type == 'Distribuidor' ? '' : null); ?> value="Distribuidor">Distribuidor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type_company">Tipo de empresa</label>

                                    <select name="type" class="form-control">
                                        <option value=""></option>
                                        <option <?php echo e(isset($ecommerce->type_company) && $ecommerce->type_company == 'Unipersonal' ? '' : null); ?> value="Unipersonal">Unipersonal</option>
                                        <option <?php echo e(isset($ecommerce->type_company) && $ecommerce->type_company == 'SRL/SA' ? '' : null); ?> value="SRL/SA">SRL/SA</option>
                                        <option <?php echo e(isset($ecommerce->type_company) && $ecommerce->type_company == 'Naturales' ? '' : null); ?> value="Naturales">Naturales</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nit">NIT</label>
                                    <input type="text" class="form-control" name="nit" value="<?php echo e($ecommerce->nit ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="minimum_order">Pedido mínimo</label>
                                    <input type="text" class="form-control" name="minimum_order" value="<?php echo e($ecommerce->minimum_order ?? null); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Banner
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <input type="file" class="form-control" name="banner">

                                    <div class="mt-3">
                                        <?php if(isset($ecommerce->banner)): ?>
                                            <img src="<?php echo e('/storage/shops/banners/' . $ecommerce->banner); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Redes sociales
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="<?php echo e($ecommerce->facebook ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="<?php echo e($ecommerce->instagram ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="google">Google</label>
                                    <input type="text" class="form-control" name="google" value="<?php echo e($ecommerce->google ?? null); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control" name="youtube" value="<?php echo e($ecommerce->youtube ?? null); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="submit" value="Guardar cambios" class="btn btn-primary">
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/i9finance/public_html/resources/views/ecommerce/index.blade.php ENDPATH**/ ?>