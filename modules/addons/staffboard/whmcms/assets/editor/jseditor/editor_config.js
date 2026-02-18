/* Define HTML Editor */
// Cache container
var $htmlEditor = $('#html_editor');
if ($htmlEditor.length){
    var html_editor = ace.edit("html_editor");
        html_editor.setTheme("ace/theme/xcode");
        html_editor.getSession().setMode("ace/mode/html");
        var html_textarea = $('#html_editortext');
        html_textarea.hide();
        html_editor.getSession().on("change", function () {
            html_textarea.val(html_editor.getSession().getValue());
        });
}
/* Define CSS Editor */
var $cssEditor = $('#css_editor');
if ($cssEditor.length){
    var css_editor = ace.edit("css_editor");
        css_editor.setTheme("ace/theme/kr");
        css_editor.getSession().setMode("ace/mode/css");
        var css_textarea = $('#css_editortext');
        css_textarea.hide();
        css_editor.getSession().on("change", function () {
            css_textarea.val(css_editor.getSession().getValue());
        });
}
/* Define Javascript Editor */
var $jsEditor = $('#js_editor');
if ($jsEditor.length){
    var js_editor = ace.edit("js_editor");
        js_editor.setTheme("ace/theme/xcode");
        js_editor.getSession().setMode("ace/mode/javascript");
        var js_textarea = $('#js_editortext');
        js_textarea.hide();
        js_editor.getSession().on("change", function () {
            js_textarea.val(js_editor.getSession().getValue());
        });
}