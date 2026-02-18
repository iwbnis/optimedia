{$whmcsgtm_datalayer_output}
{literal}
<script type="text/javascript">
  $(document).ready(function() {
    var btnCheckAvailability = $('#btnCheckAvailability');

    btnCheckAvailability.click(function(event) {
      // event.preventDefault();

      console.log('domain search');

      if (typeof dataLayer !== 'undefined') {
        dataLayer.push({
          'event': 'domainSearch',
          'eventType': 'domainSearch',
          'eventCategory': 'ecommerce',
          'eventLabel': $('#inputDomain').val()

        });
        dataLayer.push({
          'event': 'search',
          'search_term': $('#inputDomain').val()
        });
      }



      // this.submit();

    });

  });
</script>
{/literal}
