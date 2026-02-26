<style>

    html, body {
        margin: 0;
        padding: 0;
        /* height: 200%; */
    }
    .cart-sidebar {
        display: none;
    }

    #order-standard_cart .cart-body {
        width: 100% !important;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .form-group.user-log {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        width: 100% !important;
        position: relative;
    }

    .form-group.user-log input {
        width: 100%;
        padding: 15px 15px;
        border-radius: 4px;
        border: 1px solid #ddd;
        background-color: #F1F2F3 !important;
    }

    .form-group.user-log input::placeholder {
        color: #626262;
        font-size: 16px;
    }

    #togglePassword {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translate(-50%, 10px);
        cursor: pointer;
    }

    .icon-info-fx {
        position: absolute;
        top: 45px !important;
        right: -45px !important;
    }

    .icon-info-fx svg {
        stroke: #626262;
    }

    #order-standard_cart {
        padding: 30px 40px !important;
    }

div#productConfigurableOptions {
    display: none;
}
    .secondary-cart-body:before {
        position: absolute;
        right: 10px;
        width: 1px;
        height: 100%;
        background: #ddd;
        content: "";
        top: 8%;
        height: 91% !important;
    }

    .form-group label {
        margin-bottom: 12px;
    }

    .group-heading h6 {
        font-size: 24px;
        padding: 20px 0;
        color: #363636;
    }

    .generate-btn {
        background-color: #063970;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 999px;
        cursor: pointer;
        width: 100%;

        display: block;
        margin: 20px auto;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    /* ✅ Bada modal */
    .modal-dialog.modal-xl {
        max-width: 90%;
    }

    .checkbox-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px 40px;
    }

    .checkbox-grid label {
        display: flex;
        align-items: center;
        font-size: 15px;
        white-space: nowrap;
    }

    .checkbox-grid input {
        margin-right: 8px;
    }

    button.pop-btn-fx.px-4 {
        display: inline-block;
        padding: 12px 0;
        border: none;
        outline: none;
        background: #083c72;
        color: #fff;
        font-size: 16px;
        border-radius: 50px;
        cursor: pointer;
    }

    #channelModal .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 20px 30px !important;
    }

    /* Modal Overlay (only for password popup) */
    .pw-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        /* higher than default */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
    }

    /* Modal Box */
    .pw-modal-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        gap: 15px 0;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        width: 450px;
        text-align: center;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
        margin: 12% auto;
        animation: pwFadeIn 0.3s ease-in-out;
    }

    .pw-modal-content h5 {
        font-size: 18px;
        color: #333;
    }

    #generatedPassword {
        font-weight: bold;
        font-size: 18px;
        background: #F4F4F4;
        border-radius: 6px;
        display: inline-block;
    }

    .pw-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px 10px;
    }

    .pw-btn {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .active {
        display: grid !important;
    }

    div#bouquetsList {
        display: grid !important;
    }

    .pw-btn-primary {
        background: #007bff;
        color: #fff;
    }

    .pw-btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .pw-btn-danger {
        background: #dc3545;
        color: #fff;
    }
    #order-standard_cart .secondary-cart-sidebar {
        position: sticky !important;
        overflow: hidden !important;
        box-shadow: none !important;top: 0;
        right: 0;
        width: 400px; /* Adjust as needed */
        max-height: 880px;
        overflow-y: auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        z-index: 1000;
        will-change: transform;
        overflow:  hidden;
    }

    @keyframes pwFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
      .modal-content {
    animation: fadeInUp 0.3s ease-in-out;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .modal-title {
    font-size: 1.15rem;
  }
  .iptv-popup-body {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}
#channelModal .modal .modal-dialog {
    max-width: 900px !important;
    display: flex;
    width: 100% !important; 
    height: 100%;
    align-items: center;
    justify-content: center;
}
button.iptv-sec-button2 {
    display: inline-block;
    border: none;
    outline: none;
    padding: 12px 40px;
    background: gray;
    border-radius: 50px;
    color: #fff;
}
button.iptv-close-btn {
    position: absolute !important;
    top: 10px;
    right: 0;
}
#order-standard_cart .btn-primary {
    width: initial;
}
.iptv-fx-card a:nth-child(2) {
    display: inline-block;
    border-radius: 50px;
}
.iptv-fx-card button {
    display: inline-block;
    border-radius: 50px;
}
button.btn-close {
    position: absolute;
    top: 15px;
    right: 15px;
}
#order-standard_cart .modal-body, #order-standard_cart .modal-footer, #order-standard_cart .modal-header {
    text-align: center!important;
    border: 0;
    padding: 0 20px 30px 20px;
}
.navbar-expand-lg .navbar-nav .dropdown-menu {
    position: absolute !important;
    z-index: 1111;
}

    @media(max-width:1440px){
        #order-standard_cart .secondary-cart-sidebar{
            max-height: 880px !important;
        }
    }
    @media(max-width:1199px) {
        .sidebar-collapsed {
            margin-bottom: 30px;
        }
         /* #order-standard_cart .secondary-cart-sidebar{
            max-height: 140vh !important;
        } */
         #order-standard_cart .secondary-cart-sidebar {
            max-height: 1010px !important;
        }
    }

    @media(max-width:991px) {
        .secondary-cart-body:before {
            display: none !important;
        }
        div#orderSummary {
            transform: translateY(20px) !important;
        }
        #order-standard_cart .secondary-cart-sidebar {
            padding: 0 15px 45px 15px;
            width: 100% !important;
            max-height: none !important;
            position: relative !important;
        }
        #order-standard_cart .secondary-cart-body {
            width: 100% !important;
            padding-right: 0 !important;
        }
        #order-standard_cart .row {
            flex-direction: column;
        }
        .checkbox-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 8px 16px !important;
        }
    }

    @media(max-width:767px) {
        .form-inline {
            display: block;
            width: 100%;
        }
        select.form-control {
            width: 100% !important;
        }
        .icon-info-fx {
            position: relative !important;
            top: auto !important;
            right: auto !important;
            display: inline-block;
            margin-top: 6px;
        }
        .form-group {
            position: relative;
        }
        .product-info .product-title {
            font-size: 18px !important;
            word-break: break-word;
        }
        .modal-dialog.modal-xl {
            max-width: 95% !important;
            margin: 10px auto;
        }
        #channelModal .modal-body {
            padding: 12px !important;
        }
        .checkbox-grid {
            grid-template-columns: 1fr !important;
            gap: 6px !important;
        }
        .checkbox-grid label {
            font-size: 13px !important;
        }
        .pw-modal-content {
            width: 90% !important;
            margin: 20% auto !important;
            padding: 18px !important;
        }
        .nav-tabs {
            flex-wrap: nowrap !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .nav-tabs .nav-item {
            white-space: nowrap;
            flex-shrink: 0;
        }
    }

    @media(max-width:576px) {
        #order-standard_cart {
            padding: 12px 10px !important;
        }
        div#iptv-tvbox {
            padding: 0 !important;
        }
        .panel-body.card-body {
            padding: 10px !important;
        }
        #order-standard_cart .cart-body {
            padding-right: 5px !important;
            padding-left: 5px !important;
        }
        .col-12.primary-content .container {
            padding: 0 !important;
        }
        #order-standard_cart .secondary-cart-body {
            padding-right: 0 !important;
        }
        .secondary-cart-body:before {
            display: none !important;
        }
        #order-standard_cart .sub-heading span,
        #order-standard_cart .sub-heading-borderless span {
            padding: 0px 0px !important;
            top: -19px !important;
            font-size: 13px;
        }
        .generate-btn {
            padding: 10px 18px !important;
            font-size: 13px !important;
        }
        button.pop-btn-fx.px-4 {
            padding: 10px 20px !important;
            font-size: 14px !important;
        }
        .order-summary h2 {
            font-size: 20px !important;
        }
        .header-lined h1 {
            font-size: 22px !important;
        }
        .product-info p {
            font-size: 13px !important;
        }
        #btnCompleteProductConfig {
            width: 100%;
            padding: 14px !important;
            font-size: 16px !important;
        }
        .col-sm-6 {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
    }

 
</style>
<div class="container ">
    <div class="row">
        <div class="col-12 primary-content " id="iptv-tvbox">


            <link rel="stylesheet" type="text/css" href="/templates/orderforms/standard_cart/css/all.min.css?v=7e8304">
            

            <div id="order-standard_cart">

                <div class="row">
                    <div class="cart-sidebar">
                        <div menuitemname="Categories" class="panel card card-sidebar mb-3 panel-sidebar no-shadow">
                            <div class="panel-heading card-header">
                                <h3 class="panel-title">
                                    <i class="fas fa-shopping-cart"></i>&nbsp;

                                    Categories


                                    <i
                                        class="fas fa-chevron-up card-minimise panel-minimise pull-right float-right"></i>
                                </h3>
                            </div>


                            <div class="list-group collapsable-card-body">
                                <a menuitemname="CHOICE (NO ADULT) " href="/index.php/store/choice-no-adult-packages"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-CHOICE_(NO_ADULT)_">

                                    CHOICE (NO ADULT)

                                </a>
                                <a menuitemname="CHOICE (ADULT)" href="/index.php/store/choice-adult-packages"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-CHOICE_(ADULT)">

                                    CHOICE (ADULT)

                                </a>
                                <a menuitemname="AMERICAS TV (NO ADULT)"
                                    href="/index.php/store/americas-tv-no-adult-packages"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-AMERICAS_TV_(NO_ADULT)">

                                    AMERICAS TV (NO ADULT)

                                </a>
                                <a menuitemname="AMERICAS TV (ADULT)" href="/index.php/store/americas"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-AMERICAS_TV_(ADULT)">

                                    AMERICAS TV (ADULT)

                                </a>
                                <a menuitemname="CANADA PREMIUM TV (NO ADULT)"
                                    href="/index.php/store/canada-premium-tv-no-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-CANADA_PREMIUM_TV_(NO_ADULT)">

                                    CANADA PREMIUM TV (NO ADULT)

                                </a>
                                <a menuitemname="CANADA PREMIUM TV (ADULT)"
                                    href="/index.php/store/canada-premium-tv-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-CANADA_PREMIUM_TV_(ADULT)">

                                    CANADA PREMIUM TV (ADULT)

                                </a>
                                <a menuitemname="USA PREMIUM TV (NO ADULT)"
                                    href="/index.php/store/usa-premium-tv-no-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-USA_PREMIUM_TV_(NO_ADULT)">

                                    USA PREMIUM TV (NO ADULT)

                                </a>
                                <a menuitemname="USA PREMIUM TV (ADULT)" href="/index.php/store/usa-premium-tv-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-USA_PREMIUM_TV_(ADULT)">

                                    USA PREMIUM TV (ADULT)

                                </a>
                                <a menuitemname="ENGLISH COUNTRIES TV (NO ADULT)"
                                    href="/index.php/store/english-countries-tv"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-ENGLISH_COUNTRIES_TV_(NO_ADULT)">

                                    ENGLISH COUNTRIES TV (NO ADULT)

                                </a>
                                <a menuitemname="ENGLISH COUNTRIES TV (ADULT)"
                                    href="/index.php/store/english-countries-tv-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-ENGLISH_COUNTRIES_TV_(ADULT)">

                                    ENGLISH COUNTRIES TV (ADULT)

                                </a>
                                <a menuitemname="CHOICE TV - MAG DEVICES ONLY" href="/index.php/store/mag-devices"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-CHOICE_TV_-_MAG_DEVICES_ONLY">

                                    CHOICE TV - MAG DEVICES ONLY

                                </a>
                                <a menuitemname="USA-CAN-UK TV (NO ADULT) "
                                    href="/index.php/store/usa-can-uk-tv-no-adult"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-USA-CAN-UK_TV_(NO_ADULT)_">

                                    USA-CAN-UK TV (NO ADULT)

                                </a>
                                <a menuitemname="Choice Server Reseller Packages"
                                    href="/index.php/store/choice-server-reseller-packages"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-Choice_Server_Reseller_Packages">

                                    Choice Server Reseller Packages

                                </a>
                                <a menuitemname="Flex Server Reseller Package"
                                    href="/index.php/store/flex-reseller-package"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-Flex_Server_Reseller_Package">

                                    Flex Server Reseller Package

                                </a>
                                <a menuitemname="IPTV App Customization" href="/index.php/store/iptv-app-customization"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-IPTV_App_Customization">

                                    IPTV App Customization

                                </a>
                                <a menuitemname="Reseller Website Packages"
                                    href="/index.php/store/reseller-website-packages"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-Reseller_Website_Packages">

                                    Reseller Website Packages

                                </a>
                                <a menuitemname="Web Hosting" href="/index.php/store/web-hosting"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-Web_Hosting">

                                    Web Hosting

                                </a>
                                <a menuitemname="Android TV Box" href="/index.php/store/android-tv-box"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Categories-Android_TV_Box">

                                    Android TV Box

                                </a>
                            </div>

                        </div>

                        <div menuitemname="Actions" class="panel card card-sidebar mb-3 panel-sidebar no-shadow">
                            <div class="panel-heading card-header">
                                <h3 class="panel-title">
                                    <i class="fas fa-plus"></i>&nbsp;

                                    Actions


                                    <i
                                        class="fas fa-chevron-up card-minimise panel-minimise pull-right float-right"></i>
                                </h3>
                            </div>


                            <div class="list-group collapsable-card-body">
                                <a menuitemname="View Cart" href="/cart.php?a=view"
                                    class="list-group-item list-group-item-action"
                                    id="Secondary_Sidebar-Actions-View_Cart">
                                    <i class="fas fa-shopping-cart fa-fw"></i>&nbsp;

                                    View Cart

                                </a>
                            </div>

                        </div>

                        <div menuitemname="Choose Currency"
                            class="panel card card-sidebar mb-3 panel-sidebar no-shadow">
                            <div class="panel-heading card-header">
                                <h3 class="panel-title">
                                    <i class="fas fa-plus"></i>&nbsp;

                                    Choose Currency


                                    <i
                                        class="fas fa-chevron-up card-minimise panel-minimise pull-right float-right"></i>
                                </h3>
                            </div>

                            <div class="panel-body card-body collapsable-card-body">
                                <form method="post" action="cart.php?a=confproduct&amp;i=4">
                                    <input type="hidden" name="token" value="90eff330b163cf09016c95955516bd6c7aaeb622">
                                    <select name="currency" onchange="submit()" class="form-control">
                                        <option value="1" selected="">USD</option>
                                        <option value="6">AUD</option>
                                        <option value="8">BRL</option>
                                        <option value="3">CAD</option>
                                        <option value="5">EUR</option>
                                        <option value="4">GBP</option>
                                        <option value="7">NZD</option>
                                    </select>
                                </form>
                            </div>


                        </div>

                    </div>
                    <div class="cart-body">

                        <div class="header-lined">
                            <h1 class="font-size-36">Configure </h1>
                        </div>

                        <div class="sidebar-collapsed">

                            <div class="panel card panel-default">
                                <div class="m-0 panel-heading card-header">
                                    <h3 class="panel-title">
                                        <i class="fas fa-shopping-cart"></i>&nbsp;

                                        Categories

                                    </h3>
                                </div>

                                <div class="panel-body card-body">
                                    <form role="form">
                                        <select class="form-control custom-select"
                                            onchange="selectChangeNavigate(this)">
                                            <option menuitemname="CHOICE (NO ADULT) "
                                                value="/index.php/store/choice-no-adult-packages"
                                                class="list-group-item">
                                                CHOICE (NO ADULT)

                                            </option>
                                            <option menuitemname="CHOICE (ADULT)"
                                                value="/index.php/store/choice-adult-packages" class="list-group-item">
                                                CHOICE (ADULT)

                                            </option>
                                            <option menuitemname="AMERICAS TV (NO ADULT)"
                                                value="/index.php/store/americas-tv-no-adult-packages"
                                                class="list-group-item">
                                                AMERICAS TV (NO ADULT)

                                            </option>
                                            <option menuitemname="AMERICAS TV (ADULT)" value="/index.php/store/americas"
                                                class="list-group-item">
                                                AMERICAS TV (ADULT)

                                            </option>
                                            <option menuitemname="CANADA PREMIUM TV (NO ADULT)"
                                                value="/index.php/store/canada-premium-tv-no-adult"
                                                class="list-group-item">
                                                CANADA PREMIUM TV (NO ADULT)

                                            </option>
                                            <option menuitemname="CANADA PREMIUM TV (ADULT)"
                                                value="/index.php/store/canada-premium-tv-adult"
                                                class="list-group-item">
                                                CANADA PREMIUM TV (ADULT)

                                            </option>
                                            <option menuitemname="USA PREMIUM TV (NO ADULT)"
                                                value="/index.php/store/usa-premium-tv-no-adult"
                                                class="list-group-item">
                                                USA PREMIUM TV (NO ADULT)

                                            </option>
                                            <option menuitemname="USA PREMIUM TV (ADULT)"
                                                value="/index.php/store/usa-premium-tv-adult" class="list-group-item">
                                                USA PREMIUM TV (ADULT)

                                            </option>
                                            <option menuitemname="ENGLISH COUNTRIES TV (NO ADULT)"
                                                value="/index.php/store/english-countries-tv" class="list-group-item">
                                                ENGLISH COUNTRIES TV (NO ADULT)

                                            </option>
                                            <option menuitemname="ENGLISH COUNTRIES TV (ADULT)"
                                                value="/index.php/store/english-countries-tv-adult"
                                                class="list-group-item">
                                                ENGLISH COUNTRIES TV (ADULT)

                                            </option>
                                            <option menuitemname="CHOICE TV - MAG DEVICES ONLY"
                                                value="/index.php/store/mag-devices" class="list-group-item">
                                                CHOICE TV - MAG DEVICES ONLY

                                            </option>
                                            <option menuitemname="USA-CAN-UK TV (NO ADULT) "
                                                value="/index.php/store/usa-can-uk-tv-no-adult" class="list-group-item">
                                                USA-CAN-UK TV (NO ADULT)

                                            </option>
                                            <option menuitemname="Choice Server Reseller Packages"
                                                value="/index.php/store/choice-server-reseller-packages"
                                                class="list-group-item">
                                                Choice Server Reseller Packages

                                            </option>
                                            <option menuitemname="Flex Server Reseller Package"
                                                value="/index.php/store/flex-reseller-package" class="list-group-item">
                                                Flex Server Reseller Package

                                            </option>
                                            <option menuitemname="IPTV App Customization"
                                                value="/index.php/store/iptv-app-customization" class="list-group-item">
                                                IPTV App Customization

                                            </option>
                                            <option menuitemname="Reseller Website Packages"
                                                value="/index.php/store/reseller-website-packages"
                                                class="list-group-item">
                                                Reseller Website Packages

                                            </option>
                                            <option menuitemname="Web Hosting" value="/index.php/store/web-hosting"
                                                class="list-group-item">
                                                Web Hosting

                                            </option>
                                            <option menuitemname="Android TV Box"
                                                value="/index.php/store/android-tv-box" class="list-group-item">
                                                Android TV Box

                                            </option>
                                            <option value="" class="list-group-item" selected="">- Choose Another
                                                Category -</option>
                                        </select>
                                    </form>
                                </div>

                            </div>
                            <div class="panel card panel-default">
                                <div class="m-0 panel-heading card-header">
                                    <h3 class="panel-title">
                                        <i class="fas fa-plus"></i>&nbsp;

                                        Actions

                                    </h3>
                                </div>

                                <div class="panel-body card-body">
                                    <form role="form">
                                        <select class="form-control custom-select"
                                            onchange="selectChangeNavigate(this)">
                                            <option menuitemname="View Cart" value="/cart.php?a=view"
                                                class="list-group-item">
                                                View Cart

                                            </option>
                                            <option value="" class="list-group-item" selected="">- Choose Another
                                                Category -</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="panel card panel-default">
                                <div class="m-0 panel-heading card-header">
                                    <h3 class="panel-title">
                                        <i class="fas fa-plus"></i>&nbsp;

                                        Choose Currency

                                    </h3>
                                </div>

                                <div class="panel-body card-body">
                                    <form role="form">
                                        <select class="form-control custom-select"
                                            onchange="selectChangeNavigate(this)">
                                            <option value="" class="list-group-item" selected="">- Choose Another
                                                Category -</option>
                                        </select>
                                    </form>
                                </div>

                            </div>

                            <div class="pull-right form-inline float-right">
                                <form method="post" action="/cart.php?a=confproduct">
                                    <input type="hidden" name="token" value="90eff330b163cf09016c95955516bd6c7aaeb622">
                                    <select name="currency" onchange="submit()" class="form-control">
                                        <option value="">Choose Currency</option>
                                        <option value="1" selected="">USD</option>
                                        <option value="3">CAD</option>
                                        <option value="4">GBP</option>
                                        <option value="5">EUR</option>
                                        <option value="6">AUD</option>
                                        <option value="7">NZD</option>
                                        <option value="8">BRL</option>
                                    </select>
                                </form>
                            </div>

                        </div>

                        <form id="frmConfigureProduct">
                            <input type="hidden" name="configure" value="true">
                            <input type="hidden" name="i" value="4">

                            <div class="row">
                                <div class="secondary-cart-body" style="margin-top: 0px;">

                                    <p>Configure your desired options and continue to checkout.</p>

                                    <div class="product-info">
                                        <p class="product-title">CHOICE (NO ADULT): 1 Month (4 Connections)</p>
                                        <p></p>
                                        <p><strong>Android, Apple, PC, Linux, M3u, Smart TV, Firestick Devices
                                                Only</strong></p><br>
                                        <p><strong>8000+ Premium </strong>Channels</p><br>
                                        <p><strong>North, South, Central American, European, Asia, Arabic</strong>
                                            Channels </p><br>
                                        <p><strong>18+ ADULT CONTENT</strong> </p><br>
                                        <p><strong>NBA, NHL, NFL, MLB, EPL &amp; More</strong></p><br>
                                        <p><strong>HD, UHD, 4K</strong> Channels </p><br>
                                        <p><strong>USA, CA, UK Premium Sports</strong> and More</p><br>
                                        <p><strong>4K Channels</strong></p><br>
                                        <p><strong>19,000+ VOD</strong></p><br>
                                        <p><strong>3,000+ TV Series</strong></p>
                                        <p><br>
                                        </p>
                                        <p><strong>500+ 24/7 </strong> Channels</p><br>
                                        <p><strong>PPV </strong> Channels</p><br>
                                        <p><strong>Full EPG Support</strong></p><br>
                                        <p><strong>Customizable Channel Categories</strong></p><br>
                                        <p><strong>99.95% </strong> Up-time</p>
                                        <p></p>
                                    </div>

                                    <div class="alert alert-danger w-hidden" role="alert"
                                        id="containerProductValidationErrors">
                                        <p>Please correct the following errors before continuing:</p>
                                        <ul id="containerProductValidationErrorsList"></ul>
                                    </div>

                                   
                                    <div class="sub-heading">
                                        <span class="primary-bg-color">Configurable Options</span>
                                    </div>
                                         <div class="">
                                                <div class="form-group">
                                                    <label for="selectserviceType">Select service type</label>
                                                   <select name="selectserviceType" id="selectserviceType" class="form-control custom-select">
                                                    <option value="Select Service">Select Service</option>
                                                    <option value="Create new service">Create new service</option>
                                                    <option value="Renew Existing Service">Renew Existing Service</option>
                                                </select>
                                                    <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Select service type">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                                                    </div>
                                                    
                                                </div>
                         
                                            <div class="modal fade" id="loginPopupModal" tabindex="-1" aria-labelledby="loginPopupModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow-lg border-0 rounded-4">
                                                  <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-semibold text-center w-100" id="loginPopupModalLabel">
                                                      Please log in to continue
                                                    </h5>
                                                    <button type="button" class="iptv-close-btn btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body text-center pt-3 pb-4 iptv-popup-body">
                                                    <!-- <button 
                                                      class="btn btn-primary  me-2"
                                                      style="background-color:#003366; border:none;"
                                                      onclick="window.location='{$WEB_ROOT}/login'">
                                                      Login
                                                    </button>
                                                    <button 
                                                      class="btn btn-secondary " 
                                                      style="background-color:#6c757d; border:none;" 
                                                      data-bs-dismiss="modal">
                                                      Cancel
                                                    </button> -->
                                                    <button 
                                                      class="generate-btn"
                                                      onclick="window.location='{$WEB_ROOT}/login'">
                                                      Login
                                                    </button>
                                                    <button 
                                                      class="iptv-sec-button2"
                                                      data-bs-dismiss="modal">
                                                      Cancel
                                                    </button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            </div>
                                    <div class="product-configurable-options" id="productConfigurableOptions">
                                       <div class="row">
                                       <div class="col-sm-6 group-heading" id="userServicesDiv" style="display:none;">
                                              <div class="form-group user-log">
                                                <label for="userServices">Select account</label>
                                                <select id="userServices" class="form-control select-inline custom-select">
                                                  <option value="">Select account</option>
                                                  {foreach from=$userServices item=userService}
                                                    <option value="{$userService->id}">{$userService->username}</option>
                                                  {/foreach}
                                                </select>

                                                <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Username">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 9h.01"></path>
                                                    <path d="M11 12h1v4h1"></path>
                                                    <path d="M19.875 6.27c.7.398 1.13 1.143 1.125 1.948v7.284c0 .809-.443 1.555-1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1-2.184 0l-6.75-4.27A2.23 2.23 0 0 1 3 15.502V8.217c0-.809.443-1.554 1.158-1.947l6.75-3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98z"></path>
                                                  </svg>
                                                </div>
                                              </div>
                                            </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputProvider">IPTV Provider</label>
                                                        <select id="inputProvider" class="form-control select-inline custom-select">
                                                            <option value="">Select Service Provider</option>
                                                            {foreach from=$xuiData item=row}
                                                                <option value="{$row->identifier}">{$row->identifier}</option>
                                                            {/foreach}
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="IPTV Provider">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                            <div class="form-group">
                                                <!-- <label for="inputCustomChannels">Channel List</label> -->
                                                <button type="button" class="btn btn-primary btn-block mt-3" 
                                                        style="background-color: #083c74; border-radius: 25px;" 
                                                        data-toggle="modal" data-target="#channelListModal">
                                                    Channel List
                                                </button>                                                
                                            </div>
                                        </div>


                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputAdult">Include Adult Content</label>
                                                        <select id="inputAdult" class="form-control select-inline custom-select">
                                                            <option value="ADULT">Yes</option>
                                                            <option value="NO ADULT">No</option>
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Include Adult Content">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputDuration">Duration</label>
                                                        <select id="inputDuration" class="form-control select-inline custom-select">
                                                            <option value="1 Month">1 Month</option>
                                                            <option value="3 Months">3 Months</option>
                                                            <option value="6 Months">6 Months</option>
                                                            <option value="12 Months">12 Months</option>
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Duration">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputConnections">Number of Connections</label>
                                                        <select id="inputConnections" class="form-control select-inline custom-select">
                                                            <option value="1 Connection">1</option>
                                                            <option value="2 Connection">2</option>
                                                            <option value="3 Connection">3</option>
                                                            <option value="4 Connection">4</option>
                                                            <option value="5 Connection">5</option>
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of Connection">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        
                                                            <label for="inputConfigOptionDevice">Your Device</label>
                                                            <select name="configoptionDevice" id="inputConfigOption15Device" class="form-control  select-inline custom-select">
                                                            <option value="32" selected="selected">
                                                                Select your deveice
                                                            </option>
                                                            <option value="Firestick">
                                                                Firestick
                                                            </option>
                                                            <option value="MAG">
                                                                MAG
                                                            </option>
                                                            <option value="Android">
                                                                Android
                                                            </option>
                                                            <option value="Apple">
                                                                Apple
                                                            </option>
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Device">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                        </div>                                                   
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="selectedProductId">IPTV Package / Product</label>
                                                        <select id="selectedProductId" name="selectedProductId" class="form-control select-inline custom-select">
                                                            <option value="">Select Package / Product</option>
                                                            {foreach from=$allProducts item=prod}
                                                                <option value="{$prod->id}">
                                                                    {$prod->name}
                                                                </option>
                                                            {/foreach}
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="IPTV Package / Product">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
    {literal}
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById("selectserviceType");
        const panel = document.getElementById("scrollingPanelContainer");
        const cartBody = document.querySelector("#order-standard_cart .secondary-cart-body");

        function togglePanel() {
            if (select.value === "Select Service") {
                panel.style.display = "none";
                if (cartBody) {
                    cartBody.style.setProperty("width", "100%", "important");
                }
            } else {
                panel.style.display = "block";
                if (cartBody) {
                    cartBody.style.setProperty("width", "60%", "");
                }
            }
        }

        togglePanel();

        select.addEventListener("change", togglePanel);
    });
    </script>
    {/literal}


{literal}
<script>
document.addEventListener("DOMContentLoaded", function() {
    let provider = document.getElementById("inputProviders");
    let adult = document.getElementById("inputAdult");
    let duration = document.getElementById("inputDuration");
    let connections = document.getElementById("inputConnections");
    let selectedProductId = document.getElementById("selectedProductId");
    let device = document.getElementById("inputConfigOption15Device"); 

    // ✅ Global object to reuse prices anywhere
    window.selectedProductData = {
        pid: null,
        setupFee: 0,
        recurringPrice: 0,
        totalPrice: 0,
        duration: "monthly"
    };

    let allProducts = {/literal}{$allProducts|@json_encode nofilter}{literal};

    function updateProductDropdown(products) {
        selectedProductId.innerHTML = '<option value="">Select Package / Product</option>';
        products.forEach(prod => {
            let opt = document.createElement("option");
            opt.value = prod.id;
            opt.textContent = prod.name;
            selectedProductId.appendChild(opt);
        });
    }

    function fetchProductPrice(pid, keyName = "") {
        if (!pid) return;

        document.getElementById("orderSummaryLoader").style.display = "block";

        fetch("getProductPrice010.php", {   
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ pid: pid })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("orderSummaryLoader").style.display = "none";

            if (data.result === "success") {
                let pricing = data.product.pricing.USD || data.product.pricing;
                let durationValue = duration ? duration.value.trim().toLowerCase() : "monthly";
                let price = 0;
                let setupFee = parseFloat(pricing.setup || 0);

                switch (durationValue) {
                    case "1 month":
                    case "monthly":
                        price = parseFloat(pricing.monthly || 0);
                        break;
                    case "3 month":
                    case "3 months":
                    case "quarterly":
                        price = parseFloat(pricing.quarterly || 0);
                        break;
                    case "6 month":
                    case "6 months":
                    case "semiannually":
                        price = parseFloat(pricing.semiannually || 0);
                        break;
                    case "12 month":
                    case "12 months":
                    case "annually":
                        price = parseFloat(pricing.annually || 0);
                        break;
                    default:
                        price = parseFloat(pricing.monthly || 0);
                }

                let total = setupFee + price;

                // ✅ Save globally for reuse
                window.selectedProductData = {
                    pid: pid,
                    setupFee: setupFee,
                    recurringPrice: price,
                    totalPrice: total,
                    duration: durationValue
                };

                console.log("✅ Product Data Saved:", window.selectedProductData);

                // Update summary section
                document.querySelector(".product-name").textContent = keyName || 
                    (allProducts.find(p => p.id == pid)?.name || "Selected Product");

                document.querySelector(".summary-totals .clearfix:nth-child(1) .pull-right")
                    .textContent = `$${setupFee.toFixed(2)} USD`;

                document.querySelector(".summary-totals .clearfix:nth-child(2) .pull-right")
                    .textContent = `$${price.toFixed(2)} USD`;

                document.querySelector(".total-due-today .amt")
                    .textContent = `$${total.toFixed(2)} USD`;
            }
        })
        .catch(err => {
            document.getElementById("orderSummaryLoader").style.display = "none";
            console.error("AJAX Error:", err);
        });
    }

    function matchProduct() {
        let a = adult ? adult.value.trim() : "";
        let d = duration ? duration.value.trim() : "";
        let c = connections ? connections.value.trim() : "";
        let dev = device ? device.value.trim() : "";

        if (c && !c.startsWith("1 ")) {
            c = c.replace("Connection", "Connections");
        }

        let productsToSearch = allProducts;

        if (dev && dev !== "32") {
            let filtered = allProducts.filter(prod => 
                prod.name.toLowerCase().includes(dev.toLowerCase())
            );

            if (filtered.length > 0) {
                updateProductDropdown(filtered);
                productsToSearch = filtered;
            } else {
                updateProductDropdown(allProducts);
                productsToSearch = allProducts;
            }
        } else {
            updateProductDropdown(allProducts);
        }

        let key = `CHOICE (${a}): ${d} (${c})`;

        let found = productsToSearch.find(prod => 
            prod.name.trim().toLowerCase() === key.trim().toLowerCase()
        );

        if (found) {
            selectedProductId.value = found.id;
            fetchProductPrice(found.id, key);
        } else {
            selectedProductId.value = "";
        }
    }

    [provider, adult, duration, connections, device].forEach(el => {
        if (el) el.addEventListener("change", matchProduct);
    });

    if (selectedProductId) {
        selectedProductId.addEventListener("change", function() {
            let pid = this.value;
            if (pid) {
                fetchProductPrice(pid);
            }
        });
    }

    updateProductDropdown(allProducts);
});
</script>
{/literal}


                                            {literal}
                                                <!-- <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        let btnContinue = document.getElementById("btnCompleteProductConfig");
                                                        let selectedProductId = document.getElementById("selectedProductId");
                                                        let hiddenInput = document.getElementById("selectedChannels"); 
                                                        let billingCycleSelect = document.getElementById("billing_cycle"); 
                                                        

                                                        btnContinue.addEventListener("click", function(e) {
                                                            e.preventDefault(); 

                                                            let pid = selectedProductId.value;
                                                            if (pid) {
                                                            
                                                                let selectedBouquets = hiddenInput.value; 
                                                                //    alert(selectedBouquets);
                                                                let billingCycle = encodeURIComponent(billingCycleSelect.value); 
                                                                    // alert(billingCycle);
                                                               
                                                                let username = document.getElementById("username").value; 
                                                                let password = document.getElementById("password").value; 

                                                                    let url = `cart.php?a=add&pid=${pid}&skipconfig=1&billingcycle=${billingCycle}&cf_username=${username}&cf_password=${password}&cf_selectbouquets=${selectedBouquets}`;
                                                                    let url = `cart.php?a=add&pid=${pid}&skipconfig=1&billingcycle=${billingCycle}&cf_magaddress=${username}&cf_selectbouquets=${selectedBouquets}`;
                                                                
                                                                    console.log("Redirecting to:", url);

                                                                window.location.href = url;
                                                            } else {
                                                                alert("Please select a valid product before continuing.");
                                                            }
                                                        });
                                                    });
                                                    </script> -->
                                                    <script>
                                                     document.addEventListener("DOMContentLoaded", function() {
                                                        let btnContinue = document.getElementById("btnCompleteProductConfig");
                                                        let selectedProductId = document.getElementById("selectedProductId");
                                                        let hiddenInput = document.getElementById("selectedChannels"); 
                                                        let billingCycleSelect = document.getElementById("billing_cycle"); 
                                                        let deviceSelect = document.getElementById("inputConfigOption15Device");
                                                        let magInput = document.getElementById("magIp"); // MAG Address input
                                                        let usernameInput = document.getElementById("username");
                                                        let passwordInput = document.getElementById("password");
                                                        let vpnToggle = document.getElementById("vpnToggle");
                                                        
                                                        
                                                        btnContinue.addEventListener("click", function(e) {
                                                            e.preventDefault();         
                                                            var vpnVal = "";
                                                            if(vpnToggle.checked){
                                                                vpnVal = "&vpn=173";
                                                            }

                                                            var androidVal = "";
                                                            let androidProducts = document.getElementById("androidProducts");
                                                            let selectedValue = androidProducts.value;

                                                            if(selectedValue && selectedValue !== '0' && !window.androidBoxIsFree){
                                                                androidVal = "&android=" + selectedValue;
                                                            }
                                                            

                                                            let selectserviceType = document.getElementById("selectserviceType").value;
                                                            let userServices = document.getElementById("userServices").value;

                                                            let provider01 = document.getElementById("inputProvider").value;
                                                            if (!provider01) {
                                                                alert("Please select Provider before continuing.");
                                                                return;
                                                            }

                                                            let pid = selectedProductId.value;
                                                            if (!pid) {
                                                                alert("Please select a valid product before continuing.");
                                                                return;
                                                            }
                                                            let selectedBouquets = hiddenInput.value; 
                                                            let billingCycle = encodeURIComponent(billingCycleSelect.value); 

                                                            if (deviceSelect.value === "MAG") {
                                                                let magAddress = magInput.value;
                                                             
                                                                   // alert(magAddress);

                                                                let url = `customcart.php?a=add&pid=${pid}&skipconfig=1&billingcycle=${billingCycle}&cf_magaddress=${encodeURIComponent(magAddress)}&cf_selectbouquets=${selectedBouquets}&cf_selectservicetype=${selectserviceType}&cf_selectaccount=${userServices}${vpnVal}${androidVal}`;
                                                                console.log("Redirecting to (MAG):", url);
                                                                window.location.href = url;

                                                            } else {
                                                               
                                                                let username = usernameInput.value; 
                                                                let password = passwordInput.value; 

                                                                if ((!username || !password) && selectserviceType!='Renew Existing Service') {
                                                                    alert("Please enter username and password.");
                                                                    return;
                                                                }

                                                                let url = `customcart.php?a=add&pid=${pid}&skipconfig=1&billingcycle=${billingCycle}&cf_username=${encodeURIComponent(username)}&cf_password=${encodeURIComponent(password)}&cf_selectbouquets=${selectedBouquets}&cf_selectservicetype=${selectserviceType}&cf_selectaccount=${userServices}${vpnVal}${androidVal}`;
                                                                console.log("Redirecting to (Other):", url);
                                                                window.location.href = url;
                                                            }
                                                        });
                                                    });
                                                    </script>

                                                 <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        const productSelect = document.getElementById("selectedProductId");
                                                        const billingSelect = document.getElementById("billing_cycle");
                                                        const billingLabel = document.querySelector(".summary-totals .pull-left.float-left.changedes");
                                                        const duration = document.getElementById("inputDuration"); 

                                                        const durationMap = {
                                                            "1 Month": "monthly",
                                                            "3 Months": "quarterly",
                                                            "6 Months": "semiannually",
                                                            "12 Months": "annually"
                                                        };

                                                        const billingTextMap = {
                                                            "monthly": "Monthly:",
                                                            "quarterly": "Quarterly:",
                                                            "semiannually": "Semi-Annually:",
                                                            "annually": "Annually:"
                                                        };

                                                        function updateBillingLabel(cycle) {
                                                            if (billingLabel && billingTextMap[cycle]) {
                                                                billingLabel.textContent = billingTextMap[cycle];
                                                            }
                                                        }

                                                        if (productSelect) {
                                                            productSelect.addEventListener("change", function () {
                                                                const selectedText = productSelect.options[productSelect.selectedIndex].text;
                                                                const pid = productSelect.value;

                                                                let matchedCycle = null;
                                                                for (let key in durationMap) {
                                                                    if (selectedText.includes(key)) {
                                                                        matchedCycle = durationMap[key];
                                                                        break;
                                                                    }
                                                                }

                                                                if (matchedCycle && billingSelect) {
                                                                
                                                                    billingSelect.value = matchedCycle;
                                                                    billingSelect.dispatchEvent(new Event("change"));

                                                                    if (duration) {
                                                                        switch (matchedCycle) {
                                                                            case "monthly":
                                                                                duration.value = "1 Month";
                                                                                break;
                                                                            case "quarterly":
                                                                                duration.value = "3 Months";
                                                                                break;
                                                                            case "semiannually":
                                                                                duration.value = "6 Months";
                                                                                break;
                                                                            case "annually":
                                                                                duration.value = "12 Months";
                                                                                break;
                                                                        }
                                                                    }

                                                                    updateBillingLabel(matchedCycle);
                                                                }

                                                                if (pid) {
                                                                    fetchProductPrice(pid, selectedText);
                                                                }
                                                            });
                                                        }

                                                        // Initial label sync
                                                        updateBillingLabel(billingSelect.value);
                                                    });
                                                    </script>




                                            {/literal}

                                        <div class="row">
                                          
                                              
                                          
                                            <!-- <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="inputChannelList">Channel List</label>
                                                        <select id="inputChannelList" name="channel_list" class="form-control select-inline custom-select">
                                                            <option value="">Select Category</option>
                                                            {foreach $xui_catss as $cat}
                                                                <option value="{$cat->id}">{$cat->cat_name}</option>
                                                            {/foreach}
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Channel List">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                                    </div>
                                                    </div>
                                                </div> -->
                                            <!-- Channel list API script disabled
                                            <script>
                                                $(document).ready(function() {
                                                var apiUrl = "https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_category&type=streams";
                                                var selectBox = $("#inputChannelList");

                                                selectBox.html('<option value="">Loading categories...</option>');

                                                $.ajax({
                                                    url: apiUrl,
                                                    method: "GET",
                                                    dataType: "json",
                                                    timeout: 10000,
                                                    success: function(response) {
                                                    console.log("API Response:", response);

                                                    selectBox.empty();

                                                    if (response && response.data && response.data.length > 0) {
                                                        selectBox.append('<option value="">Select Category</option>');
                                                        $.each(response.data, function(index, item) {
                                                        selectBox.append('<option value="' + item.id + '">' + item.category_name + '</option>');
                                                        });
                                                    } else {
                                                        selectBox.append('<option value="">No categories found</option>');
                                                    }
                                                    },
                                                    error: function(xhr, status, error) {
                                                    console.error("API Error:", status, error);
                                                    selectBox.html('<option value="">Failed to load categories</option>');
                                                    }
                                                });
                                                });
                                            </script>
                                            -->
                                       
                                          <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inputCustomChannels" class="form-label d-block mb-2">
                                                        Customize Your Channels
                                                    </label>

                                                    <button type="button" onclick="openBouquetModal()"
                                                            class="btn btn-primary btn-block mt-3"
                                                            style="background-color: #083c74; border-radius: 25px;">
                                                        Customize Channel
                                                    </button>

                                                    <div class="icon-info-fx d-inline-block" 
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Customize Your Channels">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                                                            <path d="M12 9h.01"></path>
                                                            <path d="M11 12h1v4h1"></path>
                                                        </svg>
                                                    </div>

                                                    <div id="selectedChannelsDisplay" class="mt-3"></div>
                                                </div>
                                            </div>

                                          <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="billing_cycle">Payment Terms</label>
                                                    <select name="billing_cycle" id="billing_cycle" class="form-control select-inline custom-select">
                                                        <option value="monthly" selected>Monthly</option>
                                                        <option value="quarterly">Quarterly</option>
                                                        <option value="semiannually">Semi-Annually</option>
                                                        <option value="annually">Annually</option>
                                                    </select>
                                                    <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Payment Terms">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                                                            <path d="M12 9h.01"></path>
                                                            <path d="M11 12h1v4h1"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- ✅ Hidden input for form submission -->
                                            <input type="hidden" id="selectedChannels" name="selected_channels" value="">
                                            <style>
                                            li.nav-item .nav-link {
                                                color: #363636;
                                            }
                                            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                                                color: #083c72 !important;
                                                background-color: #fff;
                                                border-color: #dee2e6 #dee2e6 #fff;
                                            }

                                            </style>

                                            <div class="modal fade" id="channelListModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document"> 
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <h4 class="modal-title font-weight-bold">Channel List
                                                                <span style="float: right; cursor:pointer;" data-dismiss="modal" aria-label="Close">&times;</span>
                                                            </h4>                                                             
                                                            <iframe src="channel-list.html" scrolling="no" frameborder="0" height="500" width="100%"></iframe>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">          
                                                            <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="channelModal" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document"> 
                                                <div class="modal-content">

                                                <div class="modal-header text-center w-100">
                                                    <div class="w-100">
                                                    <h4 class="modal-title font-weight-bold">Select your IPTV Package</h4>
                                                    <!-- Tabs -->
                                                <ul class="nav nav-tabs justify-content-center border-bottom">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#" id="showDefaultBtn">All</a>
                                                    </li>
                                                    {foreach $xui_catss as $cat}
                                                    <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#" data-id="{$cat->id}">{$cat->cat_name}</a>
                                                    <input type="hidden" id="catInput{$cat->id}" value="">
                                                    </li>
                                                    {/foreach}
                                                    
                                                </ul>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    
                                                </div>

                                                <div class="text-center py-2 border-top border-bottom">
                                                    <h5 class="font-weight-bold mb-0">Bouquets Lists</h5>
                                                </div>

                                                <div class="modal-body">
                                                    <form id="channelForm">
                                                        <div class="tab-content">
                                                    </div>
                                                    <div id="bouquetsList" class="checkbox-grid" style="display: grid !important;">
                                                        
                                                    </div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="pop-btn-fx px-4" data-dismiss="modal">save</button>
                                                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Cancel</button>
                                                </div>

                                                </div>
                                            </div>
                                            </div>
                                            
                                            <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                            const bouquetsList = document.getElementById('bouquetsList');
                                            const showBtn = document.getElementById('showDefaultBtn');

                                            bouquetsList.style.display = 'grid';

                                            const tabLinks = document.querySelectorAll('.nav-link[data-toggle="tab"]');
                                            tabLinks.forEach(tab => {
                                                tab.addEventListener('click', function() {
                                                bouquetsList.style.display = 'none';
                                                });
                                            });

                                            showBtn.addEventListener('click', function() {
                                                bouquetsList.style.display = 'grid';
                                            });
                                            });
                                            </script>

                                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                                            <script>
                                                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                                                const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
                                            </script>
                                            <script>
                                            (function(){
                                            var hidden = document.getElementById('selectedChannels');
                                            if (!hidden) {
                                                console.error('Hidden input #selectedChannels not found.');
                                                return;
                                            }

                                            function updateFromCheckboxes() {
                                                var nodes = document.querySelectorAll('#bouquetsList input[name="selectedbouquets"]');
                                                var selected = [];
                                                nodes.forEach(function(ch) {
                                                if (ch.checked) selected.push(ch.value);
                                                });
                                                hidden.value = selected.join(',');
                                                console.log('selectedChannels =', hidden.value);
                                            }

                                            function syncCheckboxesFromHidden() {
                                                var values = hidden.value ? hidden.value.split(',') : [];
                                                var nodes = document.querySelectorAll('#bouquetsList input[name="selectedbouquets"]');
                                                nodes.forEach(function(ch) {
                                                ch.checked = values.includes(ch.value);
                                                });
                                            }

                                            document.addEventListener('change', function(e) {
                                                if (e.target && e.target.matches && e.target.matches('#bouquetsList input[name="selectedbouquets"]')) {
                                                updateFromCheckboxes();
                                                }
                                            });

                                            if (document.readyState === 'loading') {
                                                document.addEventListener('DOMContentLoaded', function() {
                                                syncCheckboxesFromHidden();
                                                updateFromCheckboxes();
                                                });
                                            } else {
                                                syncCheckboxesFromHidden();
                                                updateFromCheckboxes();
                                            }

                                            var popup = document.getElementById('channelModal');
                                            if (popup) {
                                                popup.addEventListener('show.bs.modal', function() {
                                                syncCheckboxesFromHidden(); 
                                                });
                                            }

                                            if (window.jQuery) {
                                                (function($){
                                                $(document).on('change.selectedChannels', '#bouquetsList input[name="selectedbouquets"]', function(){
                                                    var arr = $('#bouquetsList input[name="selectedbouquets"]:checked').map(function(){ return $(this).val(); }).get();
                                                    $('#selectedChannels').val(arr.join(','));
                                                });

                                                $(function(){
                                                    var arr = $('#bouquetsList input[name="selectedbouquets"]:checked').map(function(){ return $(this).val(); }).get();
                                                    $('#selectedChannels').val(arr.join(','));

                                                    $('#channelModal').on('show.bs.modal', function(){
                                                    var values = $('#selectedChannels').val().split(',');
                                                    $('#bouquetsList input[name="selectedbouquets"]').each(function(){
                                                        $(this).prop('checked', values.includes($(this).val()));
                                                    });
                                                    });
                                                });
                                                })(jQuery);
                                            }

                                            })();
                                            </script>

                                        </div>
                                        <div class="row">
                                              <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="vpnToggle">Add VPN (Optional)</label><br>                                                                                                    
                                                    <label style="position: relative; display: inline-block; width: 60px; height: 30px;">
                                                        <input type="checkbox" id="vpnToggle" name="addVpn" value="1" style="display:none;">
                                                        <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 30px;">
                                                            <span style="position: absolute; content: ''; height: 22px; width: 22px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                                                        </span>
                                                    </label>

                                                    <small class="form-text text-muted">Toggle to include VPN add-on</small>
                                                </div>
                                            </div>
                                            
                                        {literal}
                                            <script>
                                            document.addEventListener('DOMContentLoaded', function () {

                                                window.selectedProductData = window.selectedProductData || {};
                                                window.selectedProductData.totalPrice = window.selectedProductData.totalPrice || 0;
                                                window.selectedProductData.androidPrice = 0;
                                                window.selectedProductData.vpnPrice = 0;

                                                const totalDueEl = document.querySelector('#orderSummary .total-due-today .amt');
                                                const summaryTotalsEl = document.querySelector('.summary-totals');

                                                const androidSelect = document.getElementById('androidProducts');
                                                const androidPriceTag = document.getElementById('androidBoxPriceTag');
                                                const androidBoxNote = document.getElementById('androidBoxNote');
                                                const durationSelect = document.getElementById('inputDuration');
                                                window.androidBoxIsFree = false;
                                                window.androidBoxPaidPrice = 0;

                                                function isAnnualPlan() {
                                                    if (!durationSelect) return false;
                                                    var val = durationSelect.value.trim().toLowerCase();
                                                    return val === '12 months' || val === 'annually';
                                                }

                                                function updateAndroidBoxLabel() {
                                                    var isFree = isAnnualPlan();
                                                    window.androidBoxIsFree = isFree;
                                                    if (androidPriceTag) {
                                                        androidPriceTag.textContent = isFree ? '— FREE' : (window.androidBoxPaidPrice > 0 ? '— $' + window.androidBoxPaidPrice.toFixed(2) + ' USD' : '');
                                                        androidPriceTag.style.color = isFree ? '#48bb78' : '#6c5ce7';
                                                    }
                                                    if (androidBoxNote) {
                                                        androidBoxNote.style.display = isFree ? 'block' : 'none';
                                                    }
                                                    // Recalculate price if box is selected
                                                    if (androidSelect && androidSelect.value !== '0') {
                                                        var existingRow = document.querySelector('#androidProductPrice');
                                                        if (existingRow) {
                                                            var priceSpan = existingRow.querySelector('.float-right');
                                                            if (priceSpan) {
                                                                priceSpan.textContent = isFree ? 'FREE' : '$' + window.androidBoxPaidPrice.toFixed(2) + ' USD';
                                                            }
                                                        }
                                                        window.selectedProductData.androidPrice = isFree ? 0 : window.androidBoxPaidPrice;
                                                        updateGrandTotal();
                                                    }
                                                }

                                                // Listen for duration changes to update free/paid status
                                                if (durationSelect) {
                                                    durationSelect.addEventListener('change', function() {
                                                        updateAndroidBoxLabel();
                                                    });
                                                }

                                                // Fetch android box price once on load
                                                if (androidSelect && androidSelect.options.length > 1) {
                                                    var boxPid = androidSelect.options[1].value;
                                                    fetch('getProductPrice010.php', {
                                                        method: 'POST',
                                                        headers: { 'Content-Type': 'application/json' },
                                                        body: JSON.stringify({ pid: boxPid })
                                                    })
                                                    .then(function(res) { return res.json(); })
                                                    .then(function(data) {
                                                        if (data.result === 'success') {
                                                            window.androidBoxPaidPrice = parseFloat(data.product.pricing.monthly || 0);
                                                            updateAndroidBoxLabel();
                                                        }
                                                    })
                                                    .catch(function() {});
                                                }

                                                if (androidSelect) {
                                                    androidSelect.addEventListener('change', function () {
                                                        const pid = this.value;
                                                        const existingAndroidRow = document.querySelector('#androidProductPrice');
                                                        if (existingAndroidRow) existingAndroidRow.remove();

                                                        if (pid == '0' || pid === '') {
                                                            window.selectedProductData.androidPrice = 0;
                                                            updateGrandTotal();
                                                            return;
                                                        }

                                                        var isFree = window.androidBoxIsFree;
                                                        var price = isFree ? 0 : window.androidBoxPaidPrice;
                                                        window.selectedProductData.androidPrice = price;

                                                        var newDiv = document.createElement('div');
                                                        newDiv.classList.add('clearfix');
                                                        newDiv.id = 'androidProductPrice';
                                                        newDiv.innerHTML = '<span class="pull-left float-left">TVHub Android Box:</span>' +
                                                            '<span class="pull-right float-right">' + (isFree ? 'FREE' : '$' + price.toFixed(2) + ' USD') + '</span>';
                                                        summaryTotalsEl.appendChild(newDiv);
                                                        updateGrandTotal();
                                                    });
                                                }

                                                const vpnToggle = document.getElementById('vpnToggle');
                                                if (vpnToggle) {
                                                    vpnToggle.addEventListener('change', function () {
                                                        var vpnProducts = {/literal}{json_encode($vpnProducts)}{literal};
                                                        if (this.checked) {
                                                            if (vpnProducts.length > 0) {
                                                                const vpnProduct = vpnProducts[0];
                                                                const pid = vpnProduct.id;

                                                                fetch('getProductPrice010.php', {
                                                                    method: 'POST',
                                                                    headers: { 'Content-Type': 'application/json' },
                                                                    body: JSON.stringify({ pid: pid })
                                                                })
                                                                    .then(res => res.json())
                                                                    .then(data => {
                                                                        if (data.result === "success") {
                                                                            const name = data.product.name;
                                                                            const vpnPrice = parseFloat(data.product.pricing.monthly || 0);

                                                                            window.selectedProductData.vpnPrice = vpnPrice;

                                                                            const existingVpnRow = document.querySelector('#vpnProductPrice');
                                                                            if (existingVpnRow) existingVpnRow.remove();

                                                                            const newDiv = document.createElement('div');
                                                                            newDiv.classList.add('clearfix');
                                                                            newDiv.id = 'vpnProductPrice';
                                                                            newDiv.innerHTML = `
                                                                                <span class="pull-left float-left">${name}:</span>
                                                                                <span class="pull-right float-right">$${vpnPrice.toFixed(2)} USD</span>
                                                                            `;
                                                                            summaryTotalsEl.appendChild(newDiv);


                                                                            updateGrandTotal();
                                                                        } else {
                                                                            alert("Failed to load VPN price!");
                                                                        }
                                                                    })
                                                                    .catch(err => {
                                                                        console.error("Error fetching VPN product price:", err);
                                                                    });
                                                            }
                                                        } else {
                                                            window.selectedProductData.vpnPrice = 0;
                                                            const vpnRow = document.querySelector('#vpnProductPrice');
                                                            if (vpnRow) vpnRow.remove();
                                                            
                                                            updateGrandTotal();
                                                        }
                                                    });
                                                }

                                                function updateGrandTotal() {
                                                    const main = parseFloat(window.selectedProductData.totalPrice || 0);
                                                    const android = parseFloat(window.selectedProductData.androidPrice || 0);
                                                    const vpn = parseFloat(window.selectedProductData.vpnPrice || 0);

                                                    const grandTotal = main + android + vpn;

                                                    totalDueEl.textContent = `$${grandTotal.toFixed(2)} USD`;

                                                    console.log("💰 Updated Grand Total:", grandTotal);
                                                }

                                            });
                                            </script>
                                            {/literal}


                                            <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const vpnToggle = document.getElementById("vpnToggle");
                                                const slider = vpnToggle.nextElementSibling;
                                                const knob = slider.querySelector("span");

                                                vpnToggle.addEventListener("change", function() {
                                                    if (vpnToggle.checked) {
                                                        slider.style.backgroundColor = "#083C72"; 
                                                        knob.style.transform = "translateX(30px)";
                                                    } else {
                                                        slider.style.backgroundColor = "#ccc"; 
                                                        knob.style.transform = "translateX(0px)";
                                                    }
                                                });
                                            });
                                            </script>
                                      <div class="form-group" id="androidBoxGroup">
                                            <label for="androidProducts">Add TVHub Android IPTV Box <span id="androidBoxPriceTag" style="font-weight:600;color:#6c5ce7;"></span></label>
                                            <select id="androidProducts" class="form-control">
                                                  <option value="0">No thanks</option>
                                                {foreach from=$androidProducts item=product}
                                                    <option value="{$product->id}">{$product->name}</option>
                                                {/foreach}
                                            </select>
                                            <small id="androidBoxNote" class="form-text" style="color:#48bb78;display:none;"><strong>FREE</strong> with 12-month plans!</small>
                                        </div>



                                            <div class="col-sm-6">
                                               <!--  <div class="form-group">
                                                    <label for="selectserviceType">Select service type</label>
                                                    <select name="selectserviceType" id="selectserviceType"
                                                        class="form-control  select-inline custom-select">
                                                        <option value="Select Service">Select Service</option>
                                                        <option value="Create new service">Create new service</option>
                                                        <option value="Renew Existing Service">Renew Existing Service</option>
                                                    </select>
                                                    <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Select service type">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                                                    </div>
                                                    
                                                </div> -->
                         
                                            <div class="modal fade" id="loginPopupModal" tabindex="-1" aria-labelledby="loginPopupModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow-lg border-0 rounded-4">
                                                  <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-semibold text-center w-100" id="loginPopupModalLabel">
                                                      Please log in to continue
                                                    </h5>
                                                    <button type="button" class="iptv-close-btn btn-close position-absolute end-0 me-3 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body text-center pt-3 pb-4 iptv-popup-body">
                                                    <!-- <button 
                                                      class="btn btn-primary  me-2"
                                                      style="background-color:#003366; border:none;"
                                                      onclick="window.location='{$WEB_ROOT}/login'">
                                                      Login
                                                    </button>
                                                    <button 
                                                      class="btn btn-secondary " 
                                                      style="background-color:#6c757d; border:none;" 
                                                      data-bs-dismiss="modal">
                                                      Cancel
                                                    </button> -->
                                                    <button 
                                                      class="generate-btn"
                                                      onclick="window.location='{$WEB_ROOT}/login'">
                                                      Login
                                                    </button>
                                                    <button 
                                                      class="iptv-sec-button2"
                                                      data-bs-dismiss="modal">
                                                      Cancel
                                                    </button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            </div>
                                            <div class="col-sm-6" style="display:none;">
                                                <h4 style="margin: 15px 0px 15px 0px !important; color: #363636;">Bundle & Save : Get more for less</h4>
                                                <div class="form-group">
                                                    <label for="vpnBillingCycle">Choose VPN Billing Cycle</label>
                                                   
                                                        <select id="vpnBillingCycle" class="form-control select-inline custom-select">
                                                            <option value="">Choose vpn billing cycle</option>
                                                            <option value="monthly">Monthly</option>
                                                            <option value="quarterly">Quarterly</option>
                                                            <option value="annually">Annually</option>
                                                        </select>
                                                        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose VPN Billing Cycle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- New input field for Android Box -->
                                            <div class="col-sm-6" style="display:none;">
                                                <div class="form-group">
                                                    <label for="androidBox">Choose Your Android Box</label>
                                                   
                                                        <select id="androidBox" class="form-control select-inline custom-select">
                                                            <option value="">Choose your android box</option>
                                                            <option value="box1">Android Box 1</option>
                                                            <option value="box2">Android Box 2</option>
                                                            <option value="box3">Android Box 3</option>
                                                        </select>
                                                       
                                                    <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose Your Android Box">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 group-heading" id="userServicesDiv" style="display:none;">
                                              <div class="form-group user-log">
                                                <label for="userServices">Select account</label>
                                                <select id="userServices" class="form-control select-inline custom-select">
                                                  <option value="">Select account</option>
                                                  {foreach from=$userServices item=userService}
                                                    <option value="{$userService->id}">{$userService->username}</option>
                                                  {/foreach}
                                                </select>

                                                <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Username">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 9h.01"></path>
                                                    <path d="M11 12h1v4h1"></path>
                                                    <path d="M19.875 6.27c.7.398 1.13 1.143 1.125 1.948v7.284c0 .809-.443 1.555-1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1-2.184 0l-6.75-4.27A2.23 2.23 0 0 1 3 15.502V8.217c0-.809.443-1.554 1.158-1.947l6.75-3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98z"></path>
                                                  </svg>
                                                </div>
                                              </div>
                                            </div>

                                            <!-- Popup Modal -->
                                            <div class="modal fade" id="accountActionModal" tabindex="-1" aria-labelledby="accountActionModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body text-center ">
                                                    <p>Please select one of the options to continue:</p>
                                                    <div class="iptv-fx-card">
                                                    <a href="{$WEB_ROOT}/clientarea.php?action=invoices"
                                                       target="_blank"
                                                       class="btn btn-primary"
                                                       id="payInvoiceBtn">Pay invoice</a>

                                                    <a href="#" target="_blank" class="btn btn-secondary" id="upgradeBtn">Upgrade/Downgrade</a>

                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>



                                           
<div class="col-sm-6 group-heading" id="loginDetails">
    <h6>Login Details</h6>

    <!-- Username -->
    <div class="form-group user-log position-relative">
        <label for="username">Username *</label>
        <input type="text" placeholder="username" id="username" name="username" class="form-control">
        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Username">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 9h.01"></path>
                <path d="M11 12h1v4h1"></path>
                <path d="M19.875 6.27c.7.398 1.13 1.143 1.125 1.948v7.284c0 .809-.443 1.555-1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1-2.184 0l-6.75-4.27A2.23 2.23 0 0 1 3 15.502V8.217c0-.809.443-1.554 1.158-1.947l6.75-3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98z"></path>
            </svg>
        </div>
    </div>

    <!-- Password -->
    <div class="form-group user-log position-relative">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" class="form-control pe-5">

        <!-- Eye icon for show/hide password -->
        <span class="toggle-password" onclick="togglePassword()" 
              style="position:absolute; right:18px; top:48px; cursor:pointer;">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" 
                 fill="none" stroke="currentColor" stroke-width="2" 
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </span>

        <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="Password">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 9h.01"></path>
                <path d="M11 12h1v4h1"></path>
                <path d="M19.875 6.27c.7.398 1.13 1.143 1.125 1.948v7.284c0 .809-.443 1.555-1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1-2.184 0l-6.75-4.27A2.23 2.23 0 0 1 3 15.502V8.217c0-.809.443-1.554 1.158-1.947l6.75-3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98z"></path>
            </svg>
        </div>
    </div>

    <button type="button" class="generate-btn" id="generatePassword">Generate Password</button>
</div>

 {literal}
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        // Change eye icon to eye-off
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20C5 20 1 12 1 12a18.05 18.05 0 0 1 4.58-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4c7 0 11 8 11 8a18.37 18.37 0 0 1-2.63 3.69M15 12a3 3 0 1 1-3-3"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        password.type = "password";
        // Change icon back to normal eye
        eyeIcon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}
</script>
 {/literal}

                                           <div class="form-group user-log" id="magAddress" style="display:none;">
                                            <div class="form-group">
                                                <label for="magIp">MAG Address</label>
                                                <input 
                                                type="text" 
                                                id="magIp" 
                                                name="magIp" 
                                                placeholder="Format 00:1A:79:12:34:5A" 
                                                maxlength="17"
                                                required
                                                >
                                                <div class="icon-info-fx" data-bs-toggle="tooltip" data-bs-placement="top" title="MAG Address">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path><path d="M19.875 6.27c.7.398 1.13 1.143 1.125 1.948v7.284c0 .809-.443 1.555-1.158 1.948l-6.75 4.27a2.27 2.27 0 0 1-2.184 0l-6.75-4.27A2.23 2.23 0 0 1 3 15.502V8.217c0-.809.443-1.554 1.158-1.947l6.75-3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98z"></path></svg>
                                                </div>
                                                <div id="magError" style="color:red; display:none;">Invalid MAG Address</div>
                                            </div>
                                            </div>

                                            <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                            const magInput = document.getElementById('magIp');
                                            const magError = document.getElementById('magError');

                                            magInput.addEventListener('input', function() {
                                                let value = this.value.toUpperCase();

                                                value = value.replace(/[^0-9A-F:]/g, '');

                                                const parts = value.split(':').map(part => part.substring(0, 2)); 
                                                if (parts.length > 6) parts.length = 6; 
                                                value = parts.join(':');

                                                this.value = value;

                                                if (value.length === 40) {
                                                const isValid = /^([0-9A-F]{2}:){5}([0-9A-F]{2})$/.test(value);
                                                magError.style.display = isValid ? 'none' : 'inline';
                                                } else {
                                                magError.style.display = 'none';
                                                }
                                            });
                                            });
                                            </script>
                                             <script>
                                            const deviceSelect = document.getElementById('inputConfigOption15Device');
                                            const loginDetails = document.getElementById('loginDetails');
                                            const magAddress = document.getElementById('magAddress');

                                            function toggleFields() {
                                                if (deviceSelect.value === 'MAG') {
                                                    loginDetails.style.display = 'none';   
                                                    magAddress.style.display = 'block';    
                                                } else {
                                                    loginDetails.style.display = 'block';  
                                                    magAddress.style.display = 'none';     
                                                }
                                            }

                                            // Run on page load
                                            toggleFields();

                                            // Run on change
                                            deviceSelect.addEventListener('change', toggleFields);
                                        </script>

                                            <div id="passwordModal" class="pw-modal">
                                                <div class="pw-modal-content">
                                                    <h5>🔐 Generated Password</h5>
                                                    <p id="generatedPassword"></p>
                                                    <div class="pw-modal-actions">
                                                        <button type="button" id="changePasswordBtn" class="pw-btn pw-btn-secondary">Re-Generate Password</button>
                                                        <button type="button" id="usePasswordBtn" class="pw-btn pw-btn-primary">Use Password</button>
                                                        <button type="button" id="closeModalBtn" class="pw-btn pw-btn-danger">Close</button>
                                                    </div>
                                                </div>
                                            </div>


                                            <script>
                                            function generateRandomPassword(length = 12) {
                                                const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";
                                                let password = "";
                                                for (let i = 0; i < length; i++) {
                                                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                                                }
                                                return password;
                                            }

                                            const modal = document.getElementById("passwordModal");
                                            const generatedPasswordEl = document.getElementById("generatedPassword");
                                            let currentPassword = "";

                                            // Open modal
                                            document.getElementById("generatePassword").addEventListener("click", () => {
                                                currentPassword = generateRandomPassword(12);
                                                generatedPasswordEl.textContent = currentPassword;
                                                modal.style.display = "block";
                                            });

                                            // Change password inside modal
                                            document.getElementById("changePasswordBtn").addEventListener("click", () => {
                                                currentPassword = generateRandomPassword(12);
                                                generatedPasswordEl.textContent = currentPassword;
                                            });

                                            // Use password
                                            document.getElementById("usePasswordBtn").addEventListener("click", (e) => {
                                                e.preventDefault();
                                                document.getElementById("password").value = currentPassword;
                                                modal.style.display = "none";
                                            });

                                            // Close modal
                                            document.getElementById("closeModalBtn").addEventListener("click", () => {
                                                modal.style.display = "none";
                                            });

                                            // Click outside to close
                                            window.addEventListener("click", (event) => {
                                                if (event.target == modal) {
                                                    modal.style.display = "none";
                                                }
                                            });
                                            </script>


                                        </div>
                                        <div class="row">
                                        </div>
                                    </div>




                                </div>
                                <div class="secondary-cart-sidebar" id="scrollingPanelContainer">

                                    <div id="orderSummary" style="margin-top: 0px;">
                                        <div class="order-summary">
                                            <div class="loader" id="orderSummaryLoader" style="display: none;">
                                                <i class="fas fa-fw fa-sync fa-spin"></i>
                                            </div>
                                            <h2 class="font-size-30">Order Summary</h2>
                                            <div class="summary-container" > 
                                                <span
                                                    class="product-name">CHOICE (NO ADULT): 1 Month (4
                                                    Connections)</span>
                                                


                                                <div class="summary-totals">
                                                    <div class="clearfix">
                                                        <span class="pull-left float-left">Setup Fees:</span>
                                                        <span class="pull-right float-right">$0.00USD</span>
                                                    </div>
                                                    <div class="clearfix">
                                                        <span class="pull-left float-left changedes">Monthly:</span>
                                                        <span class="pull-right float-right">$0.00USD</span>
                                                    </div>
                                                </div>

                                                <div class="total-due-today">
                                                    <span class="amt">$0.00USD</span>
                                                    <span>Total Due Today</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="btnCompleteProductConfig"
                                                class="btn btn-primary btn-lg">
                                                Continue
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- Duplicate togglePassword and tooltip scripts removed (already defined above) -->
            <!-- recalctotals not available on custom cart page -->

            <div class="hidden" id="divProductHasRecommendations" data-value=""></div>
            <div class="modal fade" id="recommendationsModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="float-left pull-left">
                                Added to Cart
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-body">
                            <div class="product-recommendations-container">
                                <div class="product-recommendations">
                                    <p>Based on this product, we recommend:</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary" href="#" id="btnContinueRecommendationsModal"
                                data-dismiss="modal" role="button">
                                <span class="w-hidden hidden"><i
                                        class="fas fa-spinner fa-spin"></i>&nbsp;</span>Continue
                            </a>
                        </div>
                    </div>
                </div>
                <div class="product-recommendation clonable w-hidden hidden">
                    <div class="header">
                        <div class="cta">
                            <div class="price">
                                <span class="w-hidden hidden">FREE!</span>
                                <span class="breakdown-price"></span>
                                <span class="setup-fee"><small>&nbsp;Setup Fee</small></span>
                            </div>
                            <button type="button" class="btn btn-sm btn-add">
                                <span class="text">Add to Cart</span>
                                <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                            </button>
                        </div>
                        <div class="expander">
                            <i class="fas fa-chevron-right rotate" data-toggle="tooltip" data-placement="right"
                                title="Click to learn more."></i>
                        </div>
                        <div class="content">
                            <div class="headline truncate"></div>
                            <div class="tagline truncate">
                                A description (tagline) is not available for this product.
                            </div>
                        </div>
                    </div>
                    <div class="body clearfix">
                        <p></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

    $(document).on('click', '.nav-link', function(e){
        e.preventDefault();
         $('.nav-link').removeClass('active');
        $(this).addClass('active');
        if ($(this).attr('id') === 'showDefaultBtn') {
                    $('.allCatchanl').show();
                    return;
                }
        var categoryId = $(this).data('id'); 
          var cat = $('#catInput'+categoryId).val();
            $('.allCatchanl').hide();
            cat.split(',').filter(item => item.trim() !== "").forEach(function(value) {
                console.log('catchanl'+value);
                 $('.catchanl'+value).show();
          
});

});
});
function openBouquetModal() {
    var pid = $('#selectedProductId').val();
    if (!pid) {
        // Remove any existing warning
        $('#packageWarning').remove();
        // Show warning near the package select
        var warning = '<div id="packageWarning" style="background:#fff3cd;border:1px solid #ffc107;color:#856404;padding:10px 15px;border-radius:8px;margin-top:8px;font-size:14px;">' +
            '<strong>Please select a package first!</strong> Choose your IPTV Package above before customizing channels.' +
            '</div>';
        $('#selectedProductId').closest('.form-group').append(warning);
        // Scroll to the package select
        $('html, body').animate({
            scrollTop: $('#selectedProductId').offset().top - 100
        }, 500);
        // Flash the select border
        $('#selectedProductId').css('border-color', '#ffc107');
        setTimeout(function() { $('#selectedProductId').css('border-color', ''); }, 2000);
        setTimeout(function() { $('#packageWarning').fadeOut(300, function(){ $(this).remove(); }); }, 5000);
        return;
    }
    selectbouquetsFirst();
    $('#channelModal').modal('show');
}

function selectbouquetsFirst() {
    $.ajax({
        type: "POST",
        url: "modules/servers/XUIResellerPanel/Config.php",
        data: {
            action: 'getBouquetCategoriesOnClientArea',
            productid: $('#selectedProductId').val(),
            serviceid: ''
        },
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            var bouquetsList = '';
            if (obj.status == "success") {
                var bouquets = obj.bouquets;
                var catData = obj.cat_data;
               
                var hiddenVal = $('#selectedChannels').val(); 
                var selectedArr = hiddenVal ? hiddenVal.split(',') : [];

                $.each(catData, function(key, value) {
                      var catInptData = $('#catInput'+value).val();
                      $('#catInput'+value).val(catInptData+','+key);
                });  

                $.each(bouquets, function(key, value) {
                    var isChecked = selectedArr.includes(key.toString()) ? 'checked' : '';
                    var catId = '';
                     

                    bouquetsList += '<label class="allCatchanl catchanl'+key+'"><input type="checkbox" name="selectedbouquets" value="'+ key +'" '+isChecked+'> '+ value +'</label>';
                });

                $('#bouquetsList').html(bouquetsList);

                var arr = $('#bouquetsList input[name="selectedbouquets"]:checked').map(function(){ return $(this).val(); }).get();
                $('#selectedChannels').val(arr.join(','));

            } else {
                alert('No Bouquets found!');
            }
        },
        error: function() {
            alert('No Bouquets found!');
        }
    });                        
}
</script>
<script>
    $(document).ready(function () {
        var $panel = $('#orderSummary');

        if ($panel.length === 0) {
            console.error("Element with ID 'scrollingPanelContainer' not found.");
            return;
        }

        var currentY = 0;
        var targetY = 0;
        var ease = 0.1;

        function smoothScroll() {
            var scrollY = $(window).scrollTop();
            targetY = scrollY * 0.5;

            currentY += (targetY - currentY) * ease;
            $panel.css('transform', 'translateY(' + currentY + 'px)');

            requestAnimationFrame(smoothScroll);
        }

        smoothScroll();

$(document).ready(function () {
    var selectedAccountId = "";
    var loginCheck = '{$loginCheck}'; // from PHP

    // Existing dropdown change logic + new productConfigurableOptions logic
    $('#selectserviceType').change(function () {
        var serviceVal = $(this).val();

        if (serviceVal === 'Create new service') {
            // Show product configuration options
            $('#productConfigurableOptions').show();
            $('#userServicesDiv').hide();
            $('#loginDetails').hide();
        } 
        else if (serviceVal === 'Renew Existing Service') {
            if (loginCheck === 'yes') {
                // User is logged in → show config options and user services
                $('#productConfigurableOptions').show();
                $('#userServicesDiv').show();
                $('#loginDetails').hide();
            } else {
                // User not logged in → show login popup
                $('#loginPopupModal').modal('show');
                // Hide product options section
                $('#productConfigurableOptions').hide();
                $('#userServicesDiv').hide();
            }
        } 
        else {
            // Default selection
            $('#productConfigurableOptions').hide();
            $('#userServicesDiv').hide();
            $('#loginDetails').show();
        }
    });

    // Show popup when user selects an account
    $('#userServices').change(function () {
        selectedAccountId = $(this).val();

        if (selectedAccountId !== "") {
            // Update dynamic upgrade link before showing popup
            var upgradeLink = "{$WEB_ROOT}/clientarea.php?action=productdetails&id=" + selectedAccountId;
            $('#upgradeBtn').attr('href', upgradeLink);

            // Show the modal
            $('#accountActionModal').modal('show');
        }
    });
});


        
    });
</script>
