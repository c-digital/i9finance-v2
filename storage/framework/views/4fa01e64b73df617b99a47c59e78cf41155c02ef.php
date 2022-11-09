<?php
    $settings = Utility::settings();
  //  $logo=asset(Storage::url('public/uploads/logo'));
    $logo=\App\Models\Utility::get_file('public/uploads/logo');


  $company_logo=Utility::getValByName('company_logo_dark');
    $company_logos=Utility::getValByName('company_logo_light');

    $setting = \App\Models\Utility::colorset();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $mode_setting = \App\Models\Utility::mode_layout();
    $SITE_RTL = Utility::getValByName('SITE_RTL');

?>
<!DOCTYPE html>
<html lang="en"  dir="<?php echo e($setting['SITE_RTL'] == 'on'?'rtl':''); ?>">
<head>

    <title><?php echo e(__('I9 Finance')); ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/animate.min.css')); ?>" />
    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <!-- vendor css -->
    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if($setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/landing.css')); ?>" />
</head>

<body class="<?php echo e($color); ?>">
<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-dark default top-nav-collapse">
    <div class="container">
        <a class="navbar-brand bg-transparent" href="">

                <img src="<?php echo e($logo .'/logo-light.png'); ?>" alt="logo" width="40%"/>

        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dashboard">Características</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#price">Precios</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="#Layout">Layouts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#faq">Faq</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-light ms-2 me-1" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                </li>
                <?php if($settings['enable_signup'] == 'on'): ?>
                    <li class="nav-item">
                        <a class="btn btn-light ms-2 me-1" href="<?php echo e(route('register')); ?>">Registro</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Header ] End -->
<section id="dashboard" class="theme-alt-bg dashboard-block">
    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</section>
<!-- [ dashboard ] End -->
<!-- Required Js -->
<script src="/js/jquery.min.js"></script>
<script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/pages/wow.min.js')); ?>"></script>
<script>
    // Start [ Menu hide/show on scroll ]
    let ost = 0;
    document.addEventListener("scroll", function () {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
        } else if (cOst > ost) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
            document.querySelector(".navbar").classList.remove("default");
        } else {
            document.querySelector(".navbar").classList.add("default");
            document
                .querySelector(".navbar")
                .classList.remove("top-nav-collapse");
        }
        ost = cOst;
    });
    // End [ Menu hide/show on scroll ]
    var wow = new WOW({
        animateClass: "animate__animated", // animation css class (default is animated)
    });
    wow.init();
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: "#navbar-example",
    });
</script>

<?php echo $__env->yieldContent('js'); ?>
</body>
</html>
<?php /**PATH /home/i9finance/public_html/resources/views/layouts/shop.blade.php ENDPATH**/ ?>