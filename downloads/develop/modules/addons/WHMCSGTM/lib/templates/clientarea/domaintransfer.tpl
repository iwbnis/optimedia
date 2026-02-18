{$whmcsgtm_datalayer_output}
{literal}
  <script type="text/javascript">
    jQuery(document).ready(function() {
      frmDomainTransfer = jQuery('#frmDomainTransfer');

      frmDomainTransfer.submit(function(event) {
        dataLayer.push({
          'event': 'domainTransfer',
          'eventType': 'domainTransfer',
          'eventCategory': 'ecommerce',
          'eventLabel': jQuery('#inputTransferDomain').val()
        });
      });;
    });
  </script>
{/literal}
