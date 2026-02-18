<div class="col-sm-12">
    <div class="alert alert-info">
      <h4>How Check Is Carried Out</h4>
      <div style="margin-bottom: 5px;">
      <p>Restrictions allow variety of options. At least one option must be true to mark the restriction as fulfilled. Empty restrictions are true by default. To display the pop-up, all restrictions must be true for a given customer. </p>
      <p><strong>Exemplary situation:</strong><br>
      Select 'English' and 'Spanish' under 'Languages' and 'resellers' under 'User Groups'. All remaining restriction options are left blank.</p></div>
      <code style="margin-bottom: 5px;">(Language==English OR Language==Spanish) AND User Groups=resellers</code>
      <div style="margin-top: 5px;"><p>As a result, the pop-up will be displayed only to the customers who belong to the 'resellers' group and who use either English or Spanish language. </p>
      <p>If you also mark 'Not Logged In Users' option, the pop-up will be displayed to all guests using English or Spanish language. The moment a guest logs in as a client who is not in 'resellers' group, the pop-up will be hidden.</p></div>
    </div>
</div>
