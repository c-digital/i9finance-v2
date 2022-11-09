@php
    $settings = Utility::settings();
  //  $logo=asset(Storage::url('public/uploads/logo'));
    $logo=\App\Models\Utility::get_file('public/uploads/logo');


  $company_logo=Utility::getValByName('company_logo_dark');
    $company_logos=Utility::getValByName('company_logo_light');

    $setting = \App\Models\Utility::colorset();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $mode_setting = \App\Models\Utility::mode_layout();
    $SITE_RTL = Utility::getValByName('SITE_RTL');

@endphp
<!DOCTYPE html>
<html lang="en"  dir="{{$setting['SITE_RTL'] == 'on'?'rtl':''}}">
<head>

    <title>{{__('I9 Finance')}}</title>
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
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" />
    <!-- font css -->
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/landing.css')}}" />
</head>

<body class="{{$color}}">
<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-dark default top-nav-collapse">
    <div class="container">
        <a class="navbar-brand bg-transparent" href="">

                <img src="{{ $logo .'/logo-light.png' }}" alt="logo" width="40%"/>

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
                    <a class="btn btn-light ms-2 me-1" href="{{ route('login') }}">{{__('Login')}}</a>
                </li>
                @if($settings['enable_signup'] == 'on')
                    <li class="nav-item">
                        <a class="btn btn-light ms-2 me-1" href="{{ route('register') }}">Registro</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- [ Nav ] start -->
<!-- [ Header ] start -->
<header id="home" class="bg-primary">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-5">
                <h1
                    class="text-white mb-sm-4 wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                >
                    {{__('I9 Finance')}}
                </h1>
                <h2
                    class="text-white mb-sm-4 wow animate__fadeInLeft"
                    data-wow-delay="0.4s"
                >
                    {{__('Todo lo que necesita para administrar tu empresa.(Finanzas, Cuentas, ERP, Proyectos, Recursos Humanos, CRM)')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Obtenga visibilidad y control totales sobre su negócio con el mejor software ERP que miles de empresas adoran.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="{{ route('login') }}" class="btn btn-light me-2"
                    ><i class="far fa-eye me-2"></i>Prueba Gratuita</a
                    >
                    <a href="https://i9finance.com/register/es" class="btn btn-outline-light" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Registrarse</a
                    >
                </div>
            </div>
            <div class="col-sm-5">
                <img
                    src="{{asset('assets/images/front/header-mokeup.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                />
            </div>
        </div>
    </div>
</header>
<!-- [ Header ] End -->
<!-- [ client ] Start -->
<section id="dashboard" class="theme-alt-bg dashboard-block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2><span>Dashboard: Un Resumo total de su empresa</span> </h2>
            </div>
        </div>
        <div class="row align-items-center justify-content-center mobile-screen dashboard_images">
            <div class="col-lg-2">
                <div class="wow animate__fadeInRight mobile-widget" data-wow-delay="0.2s">

                    @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )

                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                             alt="" class="img-fluid ">
                    @else

                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @endif


                </div>
            </div>
            <div class="col-lg-2">
                <div class="wow animate__fadeInRight mobile-widget" data-wow-delay="0.4s">
                    @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )

                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                             alt="" class="img-fluid ">
                    @else

                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @endif
                </div>
            </div>
            <div class="col-lg-2">
                <div class="wow animate__fadeInRight mobile-widget" data-wow-delay="0.6s">
                    @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )

                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                             alt="" class="img-fluid ">
                    @else

                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @endif
                </div>
            </div>
            <div class="col-lg-2">
                <div class="wow animate__fadeInRight mobile-widget" data-wow-delay="0.8s">
                    @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )

                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                             alt="" class="img-fluid ">
                    @else

                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @endif
                </div>
            </div>
            <div class="col-lg-2">
                <div class="wow animate__fadeInRight mobile-widget" data-wow-delay="1s">
                    @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )

                        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @else

                        <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                             alt="" class="img-fluid">
                    @endif
                </div>
            </div>
        </div>
        <img
            src="{{asset('landing/images/dashboard.png')}}"
            alt=""
            class="img-fluid img-dashboard wow animate__fadeInUp mt-5"  style='border-radius: 15px;'
            data-wow-delay="0.2s"
        />
    </div>
</section>
<!-- [ client ] End -->
<!-- [ dashboard ] start -->
<section id="dashboard" class="theme-alt-bg dashboard-block">
    <div class="container">
        <div class="row align-items-center justify-content-end mb-5">
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                >
                    {{__('I9 Finance')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.4s">
                    {{__(' Todo lo que necesita para administrar tu empresa.(Finanzas, Cuentas, ERP, Proyectos, Recursos Humanos, CRM)')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Un Incrivel Dashboard y informes financieros para tomas de decisiones.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="https://i9finance.com/register" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Prueba Gratuita</a
                    >
                </div>
            </div>
            <div class="col-sm-6">
                <img
                    src="{{asset('landing/images/dashboard.png')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                />
            </div>
        </div>
        <div class="row align-items-center justify-content-start">
            <div class="col-sm-6">
                <img
                    src="{{asset('assets/images/front/img-crm-dash-2.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                />
            </div>
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                >
                    {{__('I9 Finance')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.4s">
                    {{__('Todo lo que necesita para administrar tu empresa.(Finanzas, Cuentas, ERP, Proyectos, Recursos Humanos, CRM)')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.6s">
                    Registrese, nuestro sistema siempre será gratis.
                </p>
                <div class="my-4 wow animate__fadeInRight" data-wow-delay="0.8s">
                    <a href="https://i9finance.com/register/es" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Prueba Gratuita</a
                    >
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->
<!-- [ feature ] start -->
<section id="feature" class="feature">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2>
                    <span class="d-block mb-3">Características</span> Todo en un solo Sistema
                </h2>
                <p class="m-0">
                    Registrese, nuestro sistema siempre será gratis.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div
                    class="card wow animate__fadeInUp"
                    data-wow-delay="0.8s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <div class="theme-avtar bg-danger">
                            <i class="ti ti-report-money"></i>
                        </div>
                        <h6 class="text-muted mt-4">.</h6>
                        <h4 class="my-3 f-w-600">Finanzas</h4>
                        <p class="mb-0">
                            Tenga el control de tus finanzas
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div
                    class="card wow animate__fadeInUp"
                    data-wow-delay="0.4s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <div class="theme-avtar bg-success">
                            <i class="ti ti-user-plus"></i>
                        </div>
                        <h6 class="text-muted mt-4">.</h6>
                        <h4 class="my-3 f-w-600">Clientes</h4>
                        <p class="mb-0">
                            Administre tus clientes de una manera rápida y facil
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div
                    class="card wow animate__fadeInUp"
                    data-wow-delay="0.6s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <div class="theme-avtar bg-warning">
                            <i class="ti ti-users"></i>
                        </div>
                        <h6 class="text-muted mt-4">.</h6>
                        <h4 class="my-3 f-w-600">Usuários</h4>
                        <p class="mb-0">
                            Acceso de empleados con Rol de usuario. 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div
                    class="card wow animate__fadeInUp"
                    data-wow-delay="0.8s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <div class="theme-avtar bg-danger">
                            <i class="ti ti-report-money"></i>
                        </div>
                        <h6 class="text-muted mt-4">.</h6>
                        <h4 class="my-3 f-w-600">Cuentas</h4>
                        <p class="mb-0">
                            Tus cuentas de una manera Clara.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center pt-sm-5 feature-mobile-screen">
            <button class="btn px-sm-5 btn-primary me-sm-3 ">Registrese Gratis</button>
            
        </div>
    </div>
</section>
<!-- [ feature ] End -->
<!-- [ dashboard ] start -->
<section class="">
    <div class="container">
        <div class="row align-items-center justify-content-end mb-5">
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                >
                    {{__('I9 Finance')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.4s">
                    {{__('Cards para avisos claro de estados y de tomas')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Registrese, nuestro sistema siempre será gratis.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="https://i9finance.com/register/es" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Prueba Gratis</a
                    >
                </div>
            </div>
            <div class="col-sm-6">
                <img
                    src="{{asset('landing/images/dash-2.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                />
            </div>
        </div>
        <div class="row align-items-center justify-content-start">
            <div class="col-sm-6">
                <img
                    src="{{asset('assets/images/front/img-crm-dash-4.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                />
            </div>
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                >
                    {{__('Slack')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.4s">
                    {{__('Integración con el más famoso app de trabjo en equipe')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.6s">
                    Tenga acceso a todos sus proyectos, sua equipe nunca más perderá um prazo.
                </p>
                <div class="my-4 wow animate__fadeInRight" data-wow-delay="0.8s">
                    <a href="https://i9finance.com/register/es" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Prueba Gratis</a
                    >
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->
<!-- [ price ] start -->
<section id="price" class="price-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2>
                    <span class="d-block mb-3">Precios</span> El mejor ERP con el mejor precio
                </h2>
                <p class="m-0">
                   Vea todas las ventajas y beneficios de usar nuestro sistema
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-1 wow animate__fadeInUp"
                    data-wow-delay="0.2s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge bg-primary">BRONCE</span>
                        <span class="mb-4 f-w-600 p-price"
                        >$0<small class="text-sm">/mensual</small></span
                        >
                        <p class="mb-0">
                            Pra siempre gratis, Todas las funcionalidades <br />
                             com algunos limites de uso.
                        </p>
                        <ul class="list-unstyled my-5">
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                               2 Usuarios
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                               5 Clintes
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Financiero
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Recursos Humanos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                CRM
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Proyectos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración de Soporte
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                5Gb de almacenamiento
                            </li>
                            <li>
                    
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Zoom Meeting
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Slack
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <button
                                class="btn mb-3 btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                            >
                               Registrar Gratis
                                <i class="ti ti-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-2 bg-primary wow animate__fadeInUp"
                    data-wow-delay="0.4s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge">PLATA</span>
                        <span class="mb-4 f-w-600 p-price"
                        >$10<small class="text-sm">/mensual</small></span
                        >
                        <p class="mb-0">
                            Actualizaciones Gratis <br />
                            Soporte Premium.
                        </p>
                        <ul class="list-unstyled my-5">
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                5 Usuarios
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                50 Clintes
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Financiero
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Recursos Humanos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                CRM
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Proyectos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración de Soporte
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                20Gb de almacenamiento Ilimitado
                            </li>
                            <li>
                    
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Zoom Meeting
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Slack
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <button
                                class="btn mb-3 btn-light d-flex justify-content-center align-items-center mx-sm-5"
                            >
                                Contratar
                                <i class="ti ti-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div
                    class="card price-card price-3 wow animate__fadeInUp"
                    data-wow-delay="0.6s"
                    style="
                visibility: visible;
                animation-delay: 0.2s;
                animation-name: fadeInUp;
              "
                >
                    <div class="card-body">
                        <span class="price-badge bg-primary">ORO</span>
                        <span class="mb-4 f-w-600 p-price"
                        >$59<small class="text-sm">/mensual</small></span
                        >
                        <p class="mb-0">
                            Todas Funcionalidades <br />
                            Sin Limites
                        </p>
                        <ul class="list-unstyled my-5">
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Usuarios Ilimitados
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Clintes Ilimitados
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Financiero
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Recursos Humanos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                CRM
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Proyectos
                            </li>
                            <li>
                                <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración de Soporte
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Almacenamiento Ilimitado
                            </li>
                            <li>
                    
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Zoom Meeting
                            </li>
                            <li>
                    <span class="theme-avtar">
                      <i class="text-primary ti ti-circle-plus"></i
                      ></span>
                                Integración con Slack
                            </li>
                        </ul>
                        <div class="d-grid text-center">
                            <button
                                class="btn mb-3 btn-primary d-flex justify-content-center align-items-center mx-sm-5"
                            >
                                Contratar
                                <i class="ti ti-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ price ] End -->
<!-- [ faq ] start -->
<section id="faq" class="price-section">
<section class="faq">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2><span>Preguntas Frecuentes </span></h2>
                <p class="m-0">
                    Use these awesome forms to login or create new account in your
                    project for free.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-xxl-8">
                <div class="accordion accordion-flush" id="accordionExample">
                    <div class="accordion-item card">
                        <h2 class="accordion-header" id="headingOne">
                            <button
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseOne"
                                aria-expanded="true"
                                aria-controls="collapseOne"
                            >
                    <span class="d-flex align-items-center">
                      <i class="ti ti-info-circle text-primary"></i> How do I
                      order?
                    </span>
                            </button>
                        </h2>
                        <div
                            id="collapseOne"
                            class="accordion-collapse collapse show"
                            aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample"
                        >
                            <div class="accordion-body">
                                <strong>This is the first item's accordion body.</strong> It
                                is shown by default, until the collapse plugin adds the
                                appropriate classes that we use to style each element. These
                                classes control the overall appearance, as well as the
                                showing and hiding via CSS transitions. You can modify any
                                of this with custom CSS or overriding our default variables.
                                It's also worth noting that just about any HTML can go
                                within the <code>.accordion-body</code>, though the
                                transition does limit overflow.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item card">
                        <h2 class="accordion-header" id="headingTwo">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                    <span class="d-flex align-items-center">
                      <i class="ti ti-info-circle text-primary"></i> How do I
                      order?
                    </span>
                            </button>
                        </h2>
                        <div
                            id="collapseTwo"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample"
                        >
                            <div class="accordion-body">
                                <strong>This is the second item's accordion body.</strong>
                                It is hidden by default, until the collapse plugin adds the
                                appropriate classes that we use to style each element. These
                                classes control the overall appearance, as well as the
                                showing and hiding via CSS transitions. You can modify any
                                of this with custom CSS or overriding our default variables.
                                It's also worth noting that just about any HTML can go
                                within the <code>.accordion-body</code>, though the
                                transition does limit overflow.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item card">
                        <h2 class="accordion-header" id="headingThree">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseThree"
                                aria-expanded="false"
                                aria-controls="collapseThree"
                            >
                    <span class="d-flex align-items-center">
                      <i class="ti ti-info-circle text-primary"></i> How do I
                      order?
                    </span>
                            </button>
                        </h2>
                        <div
                            id="collapseThree"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample"
                        >
                            <div class="accordion-body">
                                <strong>This is the third item's accordion body.</strong> It
                                is hidden by default, until the collapse plugin adds the
                                appropriate classes that we use to style each element. These
                                classes control the overall appearance, as well as the
                                showing and hiding via CSS transitions. You can modify any
                                of this with custom CSS or overriding our default variables.
                                It's also worth noting that just about any HTML can go
                                within the <code>.accordion-body</code>, though the
                                transition does limit overflow.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ faq ] End -->
<!-- [ dashboard ] start -->
<section id="Layout" class="price-section">
<section class="side-feature">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-3">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                >
                    {{__('I9 Finance')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.4s">
                    {{__('All In One Business ERP With Project, Account, HRM, CRM')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Use these awesome forms to login or create new account in your
                    project for free.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="#" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Prueba Gratis</a
                    >
                </div>
            </div>
            <div class="col-sm-9">
                <div class="row feature-img-row">
                    <div class="col-3">
                        <img
                            src="{{asset('landing/images/dashboard.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.2s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3">
                        <img
                            src="{{asset('landing/images/dash-3.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.4s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3">
                        <img
                            src="{{asset('landing/images/dash-4.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.6s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3">
                        <img
                            src="{{asset('landing/images/dash-5.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.8s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3 mt-5">
                        <img
                            src="{{asset('landing/images/dash-6.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.3s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3 mt-5">
                        <img
                            src="{{asset('landing/images/dash-7.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.5s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3 mt-5">
                        <img
                            src="{{asset('landing/images/dash-8.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.7s"
                            alt="Admin"
                        />
                    </div>
                    <div class="col-3 mt-5">
                        <img
                            src="{{asset('landing/images/dash-9.png')}}"
                            class="img-fluid header-img wow animate__fadeInRight"
                            data-wow-delay="0.9s"
                            alt="Admin"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->
<!-- [ dashboard ] start -->
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                @if($settings['cust_darklayout'] && $settings['cust_darklayout'] == 'on' )

                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                         alt="logo" style="width: 150px;" >
                @else

                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                         alt="logo" style="width: 150px;" >
                @endif
            </div>
            <div class="col-lg-6 col-sm-12 text-end">

                <p class="text-body">Copyright ©2022 | Desarrollado por Criative Digital</p>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->
<!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pages/wow.min.js')}}"></script>
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
</body>
</html>
