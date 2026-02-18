{if $wsneedagreee}
    <form method="post" id="wsform" action="viewquote.php?id={$quoteid}&amp;action=acceptterms">
        <div class="modal fade" id="WSacceptQuoteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{$wslang.agreeterms}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{$wsquoteacceptagreetos|unescape}</p>
                        <p>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="wsagreeterms" name="wsagreetos" />
                                {$wslang.iagree}
                            </label>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{$LANG.cancel}</button>
                        <button type="submit" class="btn btn-primary">{$wslang.Iagree}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $(window).on('load', function () {
            $('#WSacceptQuoteModal').modal('show');
        });
        $("#wsform").submit(function (e) {
            if (!$("#wsagreeterms").is(':checked')) {
                alert("{$wslang.accepttermsconditions}");
                e.preventDefault();
            }
        });
        $('#acceptQuoteModal').on('show.bs.modal', function (e) {
            $('#WSacceptQuoteModal').modal('show');
            return e.preventDefault();
        });
    </script>
{/if}