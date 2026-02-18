var systemURL = str_replace(["https://","http://"], ["//","//"], rootSystemURL);

var tinymceSettings = {
        selector: "textarea.ckeditor",
        height: 500,
        theme: "modern",
        entity_encoding: "raw",
        plugins: "autosave print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help",
        toolbar: [
            "formatselect,fontselect,fontsizeselect,|,bold,italic,strikethrough,underline,forecolor,backcolor,|,link,unlink,|,justifyleft,justifycenter,justifyright,justifyfull,|,search,replace,|,bullist,numlist,",
            "outdent,indent,blockquote,|,undo,redo,|,cut,copy,paste,pastetext,pasteword,|,table,|,hr,|,sub,sup,|,charmap,media,|,print,|,ltr,rtl,|,fullscreen,|,help,code,removeformat"
        ],
        image_advtab: true,
        content_css: [
            "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
            "//www.tinymce.com/css/codepen.min.css"
        ],
        browser_spellcheck: true,
        convert_urls : false,
        relative_urls : false,
        forced_root_block : "p",
        media_poster: false,
        mobile: {
            theme: "mobile",
            plugins: ["autosave", "lists", "autolink"],
            toolbar: ["undo", "bold", "italic", "styleselect"]
        },
        menu: {
            file: {title: "File", items: "preview | print"},
            edit: {title: "Edit", items: "undo redo | cut copy paste pastetext | selectall | searchreplace"},
            view: {title: "View", items: "visualaid visualchars visualblocks | preview fullscreen"},
            insert: {title: "Insert", items: "image link media codesample | charmap hr"},
            format: {title: "Format", items: "bold italic strikethrough underline superscript subscript codeformat | blockformats align | removeformat"},
            table: {title: "Table", items: "inserttable tableprops deletetable | cell row column"},
            help: {title: "Help", items: "help | code"}
        }
    };

$(document).ready(function() {
    tinymce.init(tinymceSettings).then(function(editors){
        editorLoaded = true;
    });
});

function str_replace(search, replace, subject, count) {
  var i = 0,
    j = 0,
    temp = '',
    repl = '',
    sl = 0,
    fl = 0,
    f = [].concat(search),
    r = [].concat(replace),
    s = subject,
    ra = Object.prototype.toString.call(r) === '[object Array]',
    sa = Object.prototype.toString.call(s) === '[object Array]';
  s = [].concat(s);
  if (count) {
    this.window[count] = 0;
  }

  for (i = 0, sl = s.length; i < sl; i++) {
    if (s[i] === '') {
      continue;
    }
    for (j = 0, fl = f.length; j < fl; j++) {
      temp = s[i] + '';
      repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
      s[i] = (temp)
        .split(f[j])
        .join(repl);
      if (count && s[i] !== temp) {
        this.window[count] += (temp.length - s[i].length) / f[j].length;
      }
    }
  }
  return sa ? s : s[0];
}