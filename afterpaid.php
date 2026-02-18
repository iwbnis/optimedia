<?php
$invoiceId = $_GET['invoiceid'];
$key = 'Vq5frG6JcNEkPgbp9SWDhCvjRnsFYaxX';
$ciphering = "AES-256-CBC";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '5334567891011121';

if (!isset($invoiceId))
{
	die('no invoice Id detected');
}

$encryptedInvoiceId = openssl_encrypt($invoiceId, $ciphering, $key, $options, $encryption_iv);

?>

<!DOCTYPE html>
<html style="height: 100%">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Airwallex Checkout</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Airwallex Checkout</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <style>
@keyframes blink {
    0% {
      opacity: .2;
    }
    20% {
      opacity: 1;
    }
    100% {
      opacity: .2;
    }
}
.saving span {
    animation-name: blink;
    animation-duration: 1.4s;
    animation-iteration-count: infinite;
    animation-fill-mode: both;
}

.saving span:nth-child(2) {
    animation-delay: .2s;
}

.saving span:nth-child(3) {
    animation-delay: .4s;
</style>
  </head>
  <body style="height: 100%">
    <div class="container h-100">
      <div class="row align-items-center h-100">
        <div class="col-12 mx-auto">
          <div class="h-100 justify-content-center">
            <div>
              <h1 class="text-secondary">
                <div class="saving text-center">
                  Please wait while we update your transaction status <span>.</span><span>.</span><span>.</span>
                </div>
              </h1>
            </div>
            <div class="row justify-content-center d-none" id="showHide">
              <div class="col-12 text-center">
                <button
                  type="button"
                  class="btn btn-primary btn-lg mr-3"
                  id="retryBtn"
                >
                  Retry
                </button>
                <button
                  type="button"
                  id="backToHome"
                  class="btn btn-danger btn-lg ml-3"
                >
                  Homepage
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>

     $.ajax({
        url: 'https://optimedia.tv/invoicestatus.php',
        type : "POST",
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        retryLimit: 20,
	tryCount: 0,
        data :
        JSON.stringify({
            invoiceId: <?= $invoiceId ?>,
            token: '<?= $encryptedInvoiceId ?>'
            }),

        success : function(response)
        {

           if (response && response.data === "SUCCESSED" )
           {

            window.location.href = "https://optimedia.tv/viewinvoice.php?id=<?= $invoiceId ?>&paid=paid";
           }
           else
           {
          this.tryCount++;
		console.log(this.tryCount);
          if (this.tryCount <= this.retryLimit) {
            console.log("failure");
            setTimeout(() => {
              console.log("retrying");
              $.ajax(this);
            }, 3000);
            return;
          } else {
            console.log("update failed!");
            $("#showHide").removeClass("d-none");
          }
           }
        },
        error: function(response, status, error) {
          if (response.status !== 200) {
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
              console.log('failure');
              setTimeout(() => {
                console.log('retrying');
                $.ajax(this);
              }, 3000);
              return;
            } else {
	    console.log("update failed!");
            $("#showHide").removeClass("d-none");
            }
          }
        }
    });


  </script>
</html>
