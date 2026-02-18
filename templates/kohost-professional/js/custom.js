/*================
 Template Name: Kohost Hosting Provider with WHMCS Template
 Description: All type of web hosting provider or company with WHMCS template.
 Version: 1.0
 Author: https://themeforest.net/user/themetags
=======================*/

// hide whmcs powerd by text
function hideWhmcs() {
    var poweredBySelector = $("p:contains('Powered by')");
    if(poweredBySelector.length) {
        poweredBySelector.hide();
    }
}
hideWhmcs();

// fixed navbar
$(function(){
    $(window).on('scroll', function () {
        // checks if window is scrolled more than 500px, adds/removes solid class
        if ($(this).scrollTop() > 0) {
            $('.header-main-menu').addClass('header-fixed');
        } else {
            $('.header-main-menu').removeClass('header-fixed');
        }
    });
});

// order form update summary
$("#frmConfigureProduct").on("change", "select", function () {
    recalctotals()
});

// order form update summary
$("#frmConfigureProduct .radioBillingcycle").on("ifChecked", "input", function () {
    var itemIndex  = $(this).closest("label").data("config-i");
    var billingVal = $(this).closest("label").data("config-value");
    WHMCS.http.jqClient.post("cart.php", "a=cyclechange&ajax=1&i=" + itemIndex + "&billingcycle=" + billingVal, function (e) {
        $("#productConfigurableOptions")
          .html($(e).find("#productConfigurableOptions").html())
          .promise()
          .done(function () {})
    });
      
    setTimeout(function () {
        recalctotals()
    }, 150)
});

// order form update summary
jQuery("#frmConfigureProduct .selectBillingCycle")
    .not("#inputBillingcycle")
    .on("ifChecked", "input", function () {
      recalctotals()
});

// order form update summary
jQuery("#frmConfigureProduct .selectBillingCycle")
    .not("#inputBillingcycle")
    .on("ifUnchecked", 'input[type="checkbox"]', function () {
      recalctotals()
});

const backLink = $('#frmRemoteCardProcess div a.btn.btn-sm.btn-default').attr('href');
$('#frmRemoteCardProcess div a.btn.btn-sm.btn-default').attr('href', `${backLink}&device=appInvoicepage`)
