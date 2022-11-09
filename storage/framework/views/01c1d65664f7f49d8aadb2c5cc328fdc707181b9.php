<?php $__env->startPush('script-page'); ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script type="text/javascript">
        <?php if($plan->price > 0.0 && $admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])): ?>
        var stripe = Stripe('<?php echo e($admin_payment_setting['stripe_key']); ?>');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style,
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    show_toastr('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        <?php endif; ?>

        $(document).ready(function () {
            $(document).on('click', '.apply-coupon', function () {

                var ele = $(this);
                var coupon = ele.closest('.row').find('.coupon').val();
                $.ajax({
                    url: '<?php echo e(route('apply.coupon')); ?>',
                    datType: 'json',
                    data: {
                        plan_id: '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>',
                        coupon: coupon
                    },
                    success: function (data) {
                        $('.final-price').text(data.final_price);
                        $('#stripe_coupon, #paypal_coupon').val(coupon);
                        if (data != '') {
                            if (data.is_success == true) {
                                show_toastr('Success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }

                        } else {
                            show_toastr('Error', "<?php echo e(__('Coupon code required.')); ?>", 'error');
                        }
                    }
                })
            });
        });
        <?php if(isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on'): ?>
        $(document).on("click", "#pay_with_paystack", function () {
            $('#paystack-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var paystack_callback = "<?php echo e(url('/plan/paystack')); ?>";
                    var order_id = '<?php echo e(time()); ?>';
                    var coupon_id = res.coupon;
                    var handler = PaystackPop.setup({
                        key: '<?php echo e($admin_payment_setting['paystack_public_key']); ?>',
                        email: res.email,
                        amount: res.total_price * 100,
                        currency: res.currency,
                        ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                            1
                        ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                        metadata: {
                            custom_fields: [{
                                display_name: "Email",
                                variable_name: "email",
                                value: res.email,
                            }]
                        },

                        callback: function (response) {
                            console.log(response.reference, order_id);
                            window.location.href = paystack_callback + '/' + response.reference + '/' + '<?php echo e(encrypt($plan->id)); ?>' + '?coupon_id=' + coupon_id
                        },
                        onClose: function () {
                            alert('window closed');
                        }
                    });
                    handler.openIframe();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });

        <?php endif; ?>
        //    Flaterwave Payment

        <?php if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
        $(document).on("click", "#pay_with_flaterwave", function () {

            $('#flaterwave-payment-form').ajaxForm(function (res) {

                if (res.flag == 1) {
                    var coupon_id = res.coupon;
                    var API_publicKey = '<?php echo e($admin_payment_setting['flutterwave_public_key']); ?>';
                    var nowTim = "<?php echo e(date('d-m-Y-h-i-a')); ?>";
                    var flutter_callback = "<?php echo e(url('/plan/flaterwave')); ?>";
                    var x = getpaidSetup({
                        PBFPubKey: API_publicKey,
                        customer_email: '<?php echo e(Auth::user()->email); ?>',
                        amount: res.total_price,
                        currency: '<?php echo e(env('CURRENCY')); ?>',
                        txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' + <?php echo e(date('Y-m-d')); ?>,
                        meta: [{
                            metaname: "payment_id",
                            metavalue: "id"
                        }],
                        onclose: function () {
                        },
                        callback: function (response) {
                            var txref = response.tx.txRef;
                            if (
                                response.tx.chargeResponseCode == "00" ||
                                response.tx.chargeResponseCode == "0"
                            ) {
                                window.location.href = flutter_callback + '/' + txref + '/' + '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>?coupon_id=' + coupon_id;
                            } else {
                                // redirect to a failure page.
                            }
                            x.close(); // use this to close the modal immediately after payment.
                        }
                    });
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        <?php endif; ?>
        // Razorpay Payment
        <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
        $(document).on("click", "#pay_with_razorpay", function () {
            $('#razorpay-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {

                    var razorPay_callback = '<?php echo e(url('/plan/razorpay')); ?>';
                    var totalAmount = res.total_price * 100;
                    var coupon_id = res.coupon;
                    var options = {
                        "key": "<?php echo e($admin_payment_setting['razorpay_public_key']); ?>", // your Razorpay Key Id
                        "amount": totalAmount,
                        "name": 'Plan',
                        "currency": '<?php echo e(env('CURRENCY')); ?>',
                        "description": "",
                        "handler": function (response) {
                            window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>?coupon_id=' + coupon_id;
                        },
                        "theme": {
                            "color": "#528FF0"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        <?php endif; ?>
    </script>

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })
        $(".list-group-item").click(function(){
            $('.list-group-item').filter(function(){
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css-page'); ?>
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php
    $dir= asset(Storage::url('uploads/plan'));
       $dir_payment= asset(Storage::url('uploads/payments'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Order Summary')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('plans.index')); ?>"><?php echo e(__('Plan')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Order Summary')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="sticky-top" style="top:30px">
                        <div class="mt-5">
                            <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                                                                        visibility: visible;
                                                                        animation-delay: 0.2s;
                                                                        animation-name: fadeInUp;
                                                                      ">
                                <div class="card-body">
                                    <span class="price-badge bg-primary"><?php echo e($plan->name); ?></span>

                                    <h3 class="mb-4 f-w-600  ">
                                        <?php echo e((env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$'); ?><?php echo e($plan->price . ' / ' . __(\App\Models\Plan::$arrDuration[$plan->duration])); ?></small>
                                        </small>
                                    </h3>

                                    <ul class="list-unstyled my-5 mt-3">
                                        <li>
                                            <span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>
                                            <?php echo e(($plan->max_users==-1)?__('Unlimited'):$plan->max_users); ?> <?php echo e(__('Users')); ?>

                                        </li>
                                        <li>
                                            <span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>
                                            <?php echo e(($plan->max_customers==-1)?__('Unlimited'):$plan->max_customers); ?> <?php echo e(__('Customers')); ?>

                                        </li>
                                        <li>
                                            <span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>
                                            <?php echo e(($plan->max_venders==-1)?__('Unlimited'):$plan->max_venders); ?> <?php echo e(__('Vendors')); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="card ">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                <?php if($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])): ?>
                                    <a href="#stripe_payment"
                                       class="list-group-item list-group-item-action border-0 active"><?php echo e(__('Stripe')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key'])): ?>
                                    <a href="#paypal_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Paypal')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if($admin_payment_setting['is_paystack_enabled'] == 'on' && !empty($admin_payment_setting['paystack_public_key']) && !empty($admin_payment_setting['paystack_secret_key'])): ?>
                                    <a href="#paystack_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Paystack')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                                    <a href="#flutterwave_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Flutterwave')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                                    <a href="#razorpay_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Razorpay')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on'): ?>
                                    <a href="#mercado_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Mercado Pago')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on'): ?>
                                    <a href="#paytm_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Paytm')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on'): ?>
                                    <a href="#mollie_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Mollie')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on'): ?>
                                    <a href="#skrill_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Skrill')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                                    <a href="#coingate_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Coingate')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                                    <a href="#paymentwall_payment"
                                       class="list-group-item list-group-item-action border-0"><?php echo e(__('Paymentwall')); ?><div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                            </div>
                        </div>



                    </div>
                </div>

                <div class="col-xl-9">
                    
                    <?php if($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])): ?>
                        <div id="stripe_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Stripe')); ?></h5>
                        </div>

                            <div class="tab-pane <?php echo e(($admin_payment_setting['is_stripe_enabled'] == 'on' &&!empty($admin_payment_setting['stripe_key']) &&!empty($admin_payment_setting['stripe_secret'])) == 'on'? 'active': ''); ?>"
                                 id="stripe_payment">
                                <form role="form" action="<?php echo e(route('stripe.post')); ?>" method="post"
                                      class="require-validation" id="payment-form">
                                    <?php echo csrf_field(); ?>
                                    <div class="border p-3 rounded stripe-payment-div">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="custom-radio">
                                                    <label
                                                        class="font-16 font-weight-bold"><?php echo e(__('Credit / Debit Card')); ?></label>
                                                </div>
                                                <p class="mb-0 pt-1 text-sm">
                                                    <?php echo e(__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')); ?>

                                                </p>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="card-name-on"
                                                           class="form-label text-dark"><?php echo e(__('Name on card')); ?></label>
                                                    <input type="text" name="name" id="card-name-on"
                                                           class="form-control required"
                                                           placeholder="<?php echo e(\Auth::user()->name); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="card-element">
                                                    <!-- A Stripe Element will be inserted here. -->
                                                </div>
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="paypal_coupon"
                                                               class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                        <input type="text" id="stripe_coupon" name="coupon"
                                                               class="form-control coupon"
                                                               placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                           title="<?php echo e(__('Apply')); ?>"><i
                                                                class="ti ti-square-check btn-apply"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                   value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                            <input type="submit" value="<?php echo e(__('Pay Now')); ?>"
                                                   class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>

                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key'])): ?>
                        <div id="paypal_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Paypal')); ?></h5>
                        </div>
                        <div class="tab-pane <?php echo e(($admin_payment_setting['is_stripe_enabled'] != 'on' && $admin_payment_setting['is_paypal_enabled'] == 'on' &&!empty($admin_payment_setting['paypal_client_id']) &&!empty($admin_payment_setting['paypal_secret_key'])) == 'on'? 'active': ''); ?>"
                                 id="paypal_payment">
                                
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                      action="<?php echo e(route('plan.pay.with.paypal')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="paypal_coupon"
                                                               class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                        <input type="text" id="paypal_coupon" name="coupon"
                                                               class="form-control coupon"
                                                               placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                    </div>

                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                           title="<?php echo e(__('Apply')); ?>"><i
                                                                class="ti ti-square-check btn-apply"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="<?php echo e(__('Pay Now')); ?>"
                                                   class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on'): ?>
                        <div id="paystack_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Paystack')); ?></h5>
                        </div>
                        <div id="paystack-payment" class="tabs-card">
                                <div class="">
                                    <form class="w3-container w3-display-middle w3-card-4" method="POST" id="paystack-payment-form"
                                          action="<?php echo e(route('plan.pay.with.paystack')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="plan_id"
                                               value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">

                                        <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="paystack_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="paystack_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 text-right paymentwall-coupon-tr" style="display: none">
                                            <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="paymentwall-coupon-price"></b>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="button"  id="pay_with_paystack" value="<?php echo e(__('Pay Now')); ?>"
                                                   class="btn btn-primary">
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                        <div id="flutterwave_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Flutterwave')); ?></h5>
                        </div>
                        <div class="tab-pane " id="flutterwave_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="flaterwave-payment-form"
                                      action="<?php echo e(route('plan.pay.with.flaterwave')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">

                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="flutterwave_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="flutterwave_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input id="pay_with_flaterwave" type="button" value="<?php echo e(__('Pay Now')); ?>"
                                                   class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>

                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                        <div id="razorpay_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Razorpay')); ?> </h5>

                        </div>
                        
                        <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                            <div class="tab-pane " id="razorpay_payment">

                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="razorpay-payment-form"
                                      action="<?php echo e(route('plan.pay.with.razorpay')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">

                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="razorpay_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="razorpay_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="button" id="pay_with_razorpay" value="<?php echo e(__('Pay Now')); ?>" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    


                    
                    <?php if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on'): ?>
                        <div id="mercado_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Mercado Pago')); ?></h5>
                        </div>
                        <div class="tab-pane " id="mercado_payment">

                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                      action="<?php echo e(route('plan.pay.with.mercado')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">

                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="mercado_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="mercado_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" id="pay_with_mercado" value="<?php echo e(__('Pay Now')); ?>" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>

                            </div>

                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on'): ?>
                        <div id="paytm_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Paytm')); ?></h5>
                        </div>
                        <div class="tab-pane " id="paytm_payment">
                                <form role="form" action="<?php echo e(route('plan.pay.with.paytm')); ?>" method="post" class="require-validation" id="paytm-payment-form">

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                    <input type="hidden" name="total_price" id="paytm_total_price"
                                           value="<?php echo e($plan->price); ?>" class="form-control">
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="mobile_number" class="form-label"><?php echo e(__('Mobile Number')); ?></label>
                                                    <input type="text" id="mobile_number" name="mobile_number"
                                                           class="form-control coupon"
                                                           placeholder="<?php echo e(__('Enter Mobile Number')); ?>">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="form-group w-100">
                                                    <label for="paytm_coupon"
                                                           class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paytm_coupon" name="coupon"
                                                           class="form-control coupon"
                                                           placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>

                                                <div class="form-group ms-3 mt-4">
                                                    <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                       title="<?php echo e(__('Apply')); ?>"><i
                                                            class="ti ti-square-check btn-apply"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <button class="btn btn-primary"  id="pay_with_paytm" type="submit">
                                                <?php echo e(__('Pay Now')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on'): ?>
                        <div id="mollie_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Mollie')); ?></h5>
                        </div>
                        <div class="tab-pane " id="mollie_payment">
                                <form role="form" action="<?php echo e(route('plan.pay.with.mollie')); ?>" method="post" class="require-validation" id="mollie-payment-form">

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                    <input type="hidden" name="total_price" id="mollie_total_price"
                                           value="<?php echo e($plan->price); ?>" class="form-control">
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="mollie_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="mollie_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <button class="btn btn-primary" id="pay_with_mollie" type="submit">
                                                <?php echo e(__('Pay Now')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on'): ?>
                        <div id="skrill_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Skrill')); ?></h5>
                        </div>
                            <div class="tab-pane " id="skrill_payment">

                                <form role="form" action="<?php echo e(route('plan.pay.with.skrill')); ?>" method="post" class="require-validation" id="skrill-payment-form">

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id"
                                           value="<?php echo e(date('Y-m-d')); ?>-<?php echo e(strtotime(date('Y-m-d H:i:s'))); ?>-payatm">
                                    <input type="hidden" name="order_id"
                                           value="<?php echo e(str_pad(!empty($order->id) ? $order->id + 1 : 0 + 1, 4, '100', STR_PAD_LEFT)); ?>">
                                    <?php
                                        $skrill_data = [
                                            'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                            'user_id' => 'user_id',
                                            'amount' => 'amount',
                                            'currency' => 'currency',
                                        ];
                                        session()->put('skrill_data', $skrill_data);

                                    ?>
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                    <input type="hidden" name="total_price" id="skrill_total_price"
                                           value="<?php echo e($plan->price); ?>" class="form-control">
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="skrill_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="skrill_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>
                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <button class="btn btn-primary" id="pay_with_skrill" type="submit">
                                                <?php echo e(__('Pay Now')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                    </div>
                    <?php endif; ?>

                    

                    
                    <?php if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                        <div id="coingate_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Coingate')); ?></h5>
                        </div>
                        <div class="tab-pane " id="coingate_payment">
                                <form role="form" action="<?php echo e(route('plan.pay.with.coingate')); ?>" method="post" class="require-validation" id="coingate-payment-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="counpon" id="coingate_coupon" value="">
                                    <input type="hidden" name="plan_id"
                                           value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                    <input type="hidden" name="total_price" id="coingate_total_price"
                                           value="<?php echo e($plan->price); ?>" class="form-control">
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="coingate_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="coingate_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <button class="btn btn-primary" id="pay_with_coingate" type="submit">
                                                <?php echo e(__('Pay Now')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <?php endif; ?>
                    

                    
                    <?php if(isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                        <div id="paymentwall_payment" class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Paymentwall')); ?></h5>
                        </div>
                        <div class="tab-pane " id="paymentwall_payment">

                                <form role="form" action="<?php echo e(route('plan.paymentwallpayment')); ?>" method="post"
                                      id="paymentwall-payment-form" class="w3-container w3-display-middle w3-card-4">
                                    <?php echo csrf_field(); ?>
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="paymentwall_coupon"
                                                       class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                <input type="text" id="paymentwall_coupon" name="coupon"
                                                       class="form-control coupon"
                                                       placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="#" class="text-muted " data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Apply')); ?>"><i
                                                        class="ti ti-square-check btn-apply"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                   value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                            <button class="btn btn-primary" type="submit"
                                                    id="pay_with_paymentwall">
                                                <?php echo e(__('Pay Now')); ?>

                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                    </div>
                    <?php endif; ?>
                    


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/i9finance/public_html/resources/views/stripe.blade.php ENDPATH**/ ?>