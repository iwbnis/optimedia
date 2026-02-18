{**********************************************************************
* PopupModule product developed. (2015-11-16)
* *
*
*  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
*  CONTACT                        ->       contact@modulesgarden.com
*
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice.  This software  or any other
* copies thereof may not be provided or otherwise made available to any
* other person.  No title to and  ownership of the  software is  hereby
* transferred.
*
*
**********************************************************************}

{**
* @author Mateusz Tomaszewski <mateusz.to@modulesgarden.com>
*}
<div class="row">
    <div class="col-lg-12" id="mg-home-content" >
        <form action="{$mainURL}" method="post">
            <input type="hidden" name="action" value="save"/>
            {$form}

            <div class="well" >
                <a class="btn btn-info btn-inverse" href="{$mainURL}">               
                    {$MGLANG->T('Back to List')}
                </a>
                <button class="btn btn-success btn-inverse" id="saveStyle" type="submit">               
                    {$MGLANG->T('Save')}
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js" type="text/javascript" charset="utf-8"></script>
{literal}
    <script type="text/javascript">
        // Hook up ACE editor to all textareas with data-editor attribute
        $(function () {
            var resizeElement = null;
            $('textarea.ace-editor').each(function () {
                var textarea = $(this);
                var mode = textarea.data('editor');
                var editDiv = $('<div>', {
                    position: 'absolute',
                    width: textarea.width(),
                    height: textarea.height(),
                    class: textarea.attr('class'),
                    id: textarea.attr('id') + "_ace-editor"
                }).insertBefore(textarea);
                var resize = $('<div>', {
                    position: 'absolute',
                    class: 'ace-resize'
                });
                editDiv.after(resize);
                
                textarea.css('visibility', 'hidden');
                textarea.css('height', 0);
                var editor = ace.edit(editDiv[0]);
                editor.container.style.fontFamily = "monospace";
                editor.renderer.setShowGutter(false);
                editor.getSession().setUseWorker(false);
                editor.getSession().setValue(textarea.val());
                editor.getSession().setMode("ace/mode/" + mode);
                editor.setShowPrintMargin(false);
                // copy back to textarea on form submit...
                textarea.closest('form').submit(function () {
                    if (editor.getSession().getValue() === '') {
                        var message = '{/literal}{$MGLANG->T('Please fill %s field.')}{literal}';
                        jQuery('#MGAlerts').alerts('error', message.replace('%s',mode.toUpperCase()));
                        return false;
                    }
                    textarea.val(editor.getSession().getValue());
                })
            });

            $('input[name="style[title]"]').closest('form').submit(function () {
                if ($('input[name="style[title]"]').val() === '' || $.trim($('input[name="style[title]"]').val()) === '') {
                    var message = '{/literal}{$MGLANG->T('Please fill %s field.')}{literal}';
                    jQuery('#MGAlerts').alerts('error', message.replace('%s','TITLE'));
                    return false;
                }
            });
            
            $('.ace-resize').mousedown(function (e) {
                var $this = $(this);
                e.preventDefault();
                window.dragging = true;
                var framewor_small_editor = $(this).parent();
                var smyles_editor = $(framewor_small_editor.children().first().get(0));
                resizeElement = smyles_editor;

                var top_offset = smyles_editor.offset().top - 0;

                // Set editor opacity to 0 to make transparent so our wrapper div shows
                smyles_editor.css('opacity', 0);

                // handle mouse movement
                $(document).mousemove(function (e) {

                    var actualY = e.pageY - 0;
                    // editor height
                    var eheight = actualY - top_offset;

                    // Set wrapper height
                    framewor_small_editor.css('height', eheight);
                    smyles_editor.css('height', eheight);

                    // Set dragbar opacity while dragging (set to 0 to not show)
                    smyles_editor.css('opacity', 0.5);

                });

            });

            $(document).mouseup(function (e) {

                if (window.dragging && resizeElement != null)
                {
                    var smyles_editor = resizeElement;

                    var actualY = e.pageY - 0;
                    var top_offset = smyles_editor.offset().top - 0;
                    var eheight = actualY - top_offset;

                    $(document).unbind('mousemove');

                    $('.ace-resize').css('opacity', 1);

                    smyles_editor.css('height', eheight).css('opacity', 1);

                    var editor = ace.edit(smyles_editor.attr('id'));
                    editor.resize();
                    window.dragging = false;
                    resizeElement = null
                }

            });
        });
    </script>
{/literal}
