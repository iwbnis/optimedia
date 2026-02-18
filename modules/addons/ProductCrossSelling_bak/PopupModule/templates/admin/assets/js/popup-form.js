jQuery(document).ready(function () {

    initializeFormsEvents();

    $('#mg-modal-add-new').on('show.bs.modal', function (e) {
        initializeForm();
        var thisModal = $(this);
        JSONParser.request('getEditForm', {id: null, create:true}, function (json) {
            updateModal(thisModal, json);
        });
    });
    $('#mg-modal-edit-entity').on('show.bs.modal', function (e) {
        var thisModal = $(this);
        var id = $(this).find('[name="id"]').val();
        JSONParser.request('getEditForm', {id: id}, function (json) {
            updateEditModal(thisModal, json);
        });
    });
});

//$(document).on("click", ".mg-modal-preview", function(event){
//        
//   var id = $(event.target).data('modalTarget');
//   location
// 
//});

var performStartImmediateChange = function () {
    var parent = $('.mg-popup-start');
    toggleElement($(this).prop('checked'), parent);
    setActualStatus('', $(this).prop('checked'), null);
};
var performNeverEndChange = function () {
    var parent = $('.mg-popup-end');
    toggleElement($(this).prop('checked'), parent);
    setActualStatus('', null, $(this).prop('checked'));
};
var performSizeChange = function () {
    var parent = $('.mg-popup-height');
    toggleElement($(this).val() === 'auto', parent);
};
var performMessageTypeChange = function () {
    $('.mg-popup-textmessage').hide();
    $('.mg-popup-htmlmessage').hide();
    $('.mg-popup-imagemessage').hide();

    var choosen = '.mg-popup-' + $(this).val() + 'message';
    $(choosen).fadeIn(150);
};
var performEndHourChange = function () {
    var parent = $('.mg-popup-endHour');
    toggleElement($(this).prop('checked') === false, parent);
};
var performStartHourChange = function () {
    var parent = $('.mg-popup-startHour');
    toggleElement($(this).prop('checked') === false, parent);
};

var performDueDateType = function(){
    var parent = $('.mg-popup-dueDateType');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDueDateCondition = function() {
    var parent = $('.mg-popup-dueDateCondition');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDueDateDays = function (){
    var parent = $('.mg-popup-dueDateDays');
    toggleElement($(this).prop('checked') === false, parent);
}

var performWithProduct = function() {
    var parent = $('.mg-popup-withProductsCheckbox');
    var child1 = $('#mg-popup-withProductsCheckbox input[type="checkbox"]');
    var child2 = $('#mg-popup-activeStatusSelect input[type="checkbox"]');
    uncheckChild(child1);
    uncheckChild(child2);
    toggleElement($(this).prop('checked') === false, parent);
}

var performActiveStatus = function (){
    var parent = $('.mg-popup-activeStatusSelect');
    toggleElement($(this).prop('checked') === false, parent);
}

var performProducts = function (){
    var parent = $('.mg-popup-dueDateProduct');
    toggleElement($(this).prop('checked') === false, parent);
}
var performAddons = function (){
    var parent = $('.mg-popup-dueDateAddon');
    toggleElement($(this).prop('checked') === false, parent);
}
var performDomains = function (){
    var parent = $('.mg-popup-dueDateDomain');
    toggleElement($(this).prop('checked') === false, parent);
}

var performProductStatus = function (){
    var parent = $('.mg-popup-dueDateStatus');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDueDateConditionEdit = function() {
    var parent = $('.mg-popup-dueDateCondition-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDueDateDaysEdit = function (){
    var parent = $('.mg-popup-dueDateDays-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performWithProductEdit = function() {
    var parent = $('.mg-popup-withProductsCheckbox-edit');
    var child1 = $('#mg-popup-withProductsCheckbox-edit input[type="checkbox"]');
    var child2 = $('#mg-popup-activeStatusSelect-edit input[type="checkbox"]');
    uncheckChild(child1);
    uncheckChild(child2);
    toggleElement($(this).prop('checked') === false, parent);
}

var performActiveStatusEdit = function (){
    var parent = $('.mg-popup-activeStatusSelect-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performProductsEdit = function (){
    var parent = $('.mg-popup-dueDateProduct-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performProductStatusEdit = function (){
    var parent = $('.mg-popup-dueDateStatus-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDueDateTypeEdit = function(){
    var parent = $('.mg-popup-dueDateType-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performAddonsEdit = function (){
    var parent = $('.mg-popup-dueDateAddon-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var performDomainsEdit = function (){
    var parent = $('.mg-popup-dueDateDomain-edit');
    toggleElement($(this).prop('checked') === false, parent);
}

var showHideAtStart = function (startImmediate, neverEnd, sizeRadios, typeRadios, runHours, activeDueDate,activeProduct,activeProductStatus, animate, suffix) {

    var parent = $('.mg-popup-start' + suffix);
    toggleElement(startImmediate.prop('checked'), parent);

    var parent1 = $('.mg-popup-end' + suffix);
    toggleElement(neverEnd.prop('checked'), parent1);

    var parent2 = $('.mg-popup-height' + suffix);
    toggleElement(sizeRadios.val() === 'auto', parent2);
    
    var parent3 = $('.mg-popup-startHour' + suffix);
    var parent4 = $('.mg-popup-endHour' + suffix);
    
    toggleElement(runHours.prop('checked') === false, parent3);
    toggleElement(runHours.prop('checked') === false, parent4);
    
    var parent5 = $('.mg-popup-dueDateType' + suffix);
    var parent6 = $('.mg-popup-dueDateCondition' + suffix);
    var parent7 = $('.mg-popup-dueDateDays' + suffix);
    var parent8 = $('.mg-popup-withProductsCheckbox' + suffix);
    var parent9 = $('.mg-popup-activeStatusSelect' + suffix);
    
    toggleElement(activeDueDate.prop('checked') === false, parent5);
    toggleElement(activeDueDate.prop('checked') === false, parent6);
    toggleElement(activeDueDate.prop('checked') === false, parent7);
    toggleElement(activeDueDate.prop('checked') === false, parent8);
    toggleElement(activeDueDate.prop('checked') === false, parent9);

    var parent10 = $('.mg-popup-dueDateProduct' + suffix);
    var parent11 = $('.mg-popup-dueDateAddon' + suffix);
    var parent12 = $('.mg-popup-dueDateDomain' + suffix);
    
    toggleElement(activeProduct.prop('checked') === false, parent10);
    toggleElement(activeProduct.prop('checked') === false, parent11);
    toggleElement(activeProduct.prop('checked') === false, parent12);
    
    var parent13 = $('.mg-popup-dueDateStatus' + suffix);
    toggleElement(activeProductStatus.prop('checked') === false, parent13);
    
    $('.mg-popup-textmessage' + suffix).fadeOut(150);
    $('.mg-popup-htmlmessage' + suffix).fadeOut(150);
    $('.mg-popup-imagemessage' + suffix).fadeOut(150);

    var choosen = '.mg-popup-' + typeRadios.val() + 'message' + suffix;
    $(choosen).fadeIn(150);

    var parent14 = $('.mg-popup-animationTime' + suffix);
    toggleElement(animate.val() === 'none', parent14);
};

var performStartHourChangeEdit = function () {
    var parent = $('.mg-popup-startHour-edit');
    toggleElement($(this).prop('checked') === false, parent);
};

var performEndHourChangeEdit = function () {
    var parent = $('.mg-popup-endHour-edit');
    toggleElement($(this).prop('checked') === false, parent);
};

var performStartImmediateChangeEdit = function () {
    var parent = $('.mg-popup-start-edit');
    toggleElement($(this).prop('checked'), parent);
    setActualStatus('-edit');
};

var performAnimationTimeEdit = function () {
    var parent = $('.mg-popup-animationTime-edit');
    toggleElement($(this).val() === 'none', parent);
};

var performAnimationTime = function () {
    var parent = $('.mg-popup-animationTime');
    toggleElement($(this).val() === 'none', parent);
};

var performNeverEndChangeEdit = function () {
    var parent = $('.mg-popup-end-edit');
    toggleElement($(this).prop('checked'), parent);
    setActualStatus('-edit');
};
var performSizeChangeEdit = function () {
    var parent = $('.mg-popup-height-edit');
    toggleElement($(this).val() === 'auto', parent);
};

var performActualPopupStatusEdit = function () {
    setActualStatus('-edit');
};

var performActualPopupStatus = function () {

    setActualStatus('');
};

var setActualStatus = (suffix, immediateStart, neverEnd) => {
    var startValue = $('.mg-popup-start' + suffix).find('input').val();
    var startDate = typeof startValue !== 'undefined' ? new Date(startValue) : null;

    var endValue = $('.mg-popup-end' + suffix).find('input').val();
    var endDate = typeof endValue !== 'undefined' ? new Date(endValue) : null;
    var statusField = $('.mg-popup-status' + suffix).find('input');

    var actualDate = new Date();

    if (startDate !== null && !immediateStart && startDate > actualDate) {
        statusField.val('Inactive');
    }
    else if(endDate && !neverEnd && endDate < actualDate){
        statusField.val('Archive');
    }
    else {
        statusField.val('Active')
    }
};

var performMessageTypeChangeEdit = function () {
    $('.mg-popup-textmessage-edit').hide();
    $('.mg-popup-htmlmessage-edit').hide();
    $('.mg-popup-imagemessage-edit').hide();

    var choosen = '.mg-popup-' + $(this).val() + 'message-edit';
    $(choosen).fadeIn(150);
};

var toggleElement = function (boolean, parent) {
    var input = parent.find('input');
    if (boolean) {
        parent.fadeOut(100);
    } else {
        if(parent.selector.indexOf('.mg-popup-start') > -1
                && input.data("DateTimePicker") !== undefined) {
            input.data("DateTimePicker").clear();
        }
        if(parent.selector.indexOf('.mg-popup-end') > -1
                && input.data("DateTimePicker") !== undefined) {
            input.data("DateTimePicker").clear();
        }
        parent.fadeIn(100);
    }
};

var uncheckChild = function(child){
    if(child.prop('checked') === true)
    {
        child.prop('checked', false);
        child.trigger( "change" );
    }
};

var uploadFile = function (e) {
    e.preventDefault();
    var button = $(this);
    var file_data = button.parent().find('input[type="file"]').prop("files")[0];
    if (typeof file_data !== "undefined") {
        var form_data = new FormData();
        var parent = $(this).parent();
        form_data.append('file', file_data);
        $.ajax({
            url: "addonmodules.php?module=PopupModule&ajaxUpload=1",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function (xhr) {
                showMessage('info', 'File is processing...', parent);
                $(this).find('.fa-spin').removeClass('hide');
            },
            success: function (json) {
                var response = $.parseJSON(json);
                showMessage(response.status, response.message, parent);
                if (response.status === 'success') {
                    $(this).find('.fa-spin').addClass('hide');
                    $('input[name="popup[image_name]"]').val(response.newName);
                    var form = button.parents('form');
                    var idInput = form.find('input[name="id"]');
                    if(idInput.val() > 0) {
                        var suffix = '-edit';
                    } else {
                        var suffix = '';
                    }
                    pasteImage(form, suffix);
                }
            }
        });
    }
};

var showMessage = function (status, message, parent) {
    $.each($('p.file-upload-alert'), function () {
        $(this).remove();
    });
    if (status === 'success') {
        var className = 'bg-success';
        var ico = 'glyphicon-ok-sign';
    } else if (status === 'info') {
        var className = 'bg-info';
        var ico = 'glyphicon glyphicon-info-sign';
    } else {
        var className = 'bg-danger';
        var ico = 'glyphicon-exclamation-sign';
    }

    var alert = '<p class="' + className + ' mg-upload-info file-upload-alert"><i class="glyphicon '+ico+'"></i> ' + message + '</p>';
    parent.append(alert);
};

var loadSettingsFrom = function () {
    var thisModal = $(this).parents('.modal');
    var id = $(this).val();
    var editID = thisModal.find('input[name="id"]').val();
    if(id == 0 || id == editID) { return false;}
    JSONParser.request('getEditForm', {id: id, copy: 1}, function (json) {
        updateEditModal(thisModal, json);
        thisModal.find('#mg-popup-name').focus();
        thisModal.find('#mg-popup-name').blur();
    });
};

var loadSettingsFromCreate = function () {
    var thisModal = $(this).parents('.modal');
    var id = $(this).val();
    if(id == 0) { return false;}
    JSONParser.request('getEditForm', {id: id, copy: 1, create:1}, function (json) {
        updateModal(thisModal, json);
        thisModal.find('#mg-popup-name').focus();
        thisModal.find('#mg-popup-name').blur();
    });
};

var updateEditModal = function (thisModal, json) {
    var parent = thisModal.find('.form-horizontal').parent();
    thisModal.find('.form-horizontal').remove();
    parent.append(json.form);
    initializeEditForm();
};

var updateModal = function (thisModal, json) {
    var parent = thisModal.find('.form-horizontal').parent();
    thisModal.find('.form-horizontal').remove();
    parent.append(json.form);
    initializeForm();
};

var initializeEditForm = function () {
    var animate = $('.mg-popup-animation-edit select');
    var startImmediateEdit = $('#mg-popup-startImmidiate-edit').find('input[type="checkbox"]');
    var neverEndEdit = $('#mg-popup-neverEnd-edit').find('input[type="checkbox"]');
    var sizeRadiosEdit = $('.mg-popup-size-edit input:checked');
    var typeRadiosEdit = $('.mg-popup-type-edit select');
    var runHours = $('#mg-popup-runHours-edit').find('input[type="checkbox"]');
    
    var activeDueDate = $('#mg-popup-activeDueDate-edit').find('input[type="checkbox"]');
    var activeProduct = $('#mg-popup-withProductsCheckbox-edit').find('input[type="checkbox"]');
    var activeProductStatus = $('#mg-popup-activeStatusSelect-edit').find('input[type="checkbox"]');

    showHideAtStart(startImmediateEdit, neverEndEdit, sizeRadiosEdit, typeRadiosEdit, runHours, activeDueDate,activeProduct,activeProductStatus, animate, '-edit');
    
    addImage(typeRadiosEdit, '-edit');
    
    fireLibraries('#mg-modal-edit-entity');
};

var initializeForm = function () {
    var animate = $('.mg-popup-animation select');
    var startImmediate = $('#mg-popup-startImmidiate').find('input[type="checkbox"]');
    var neverEnd = $('#mg-popup-neverEnd').find('input[type="checkbox"]');
    var sizeRadios = $('.mg-popup-size input:checked');
    var typeRadios = $('.mg-popup-type select');
    var runHours = $('#mg-popup-runHours').find('input[type="checkbox"]');
    
    var activeDueDate = $('#mg-popup-activeDueDate').find('input[type="checkbox"]');
    var activeProduct = $('#mg-popup-withProductsCheckbox').find('input[type="checkbox"]');
    var activeProductStatus = $('#mg-popup-activeStatusSelect').find('input[type="checkbox"]');
    showHideAtStart(startImmediate, neverEnd, sizeRadios, typeRadios, runHours, activeDueDate,activeProduct,activeProductStatus, animate, '');

    addImage(typeRadios, '');

    fireLibraries('#mg-modal-add-new');
};

var initializeFormsEvents = function () {

    $('body').on('change', '#mg-popup-startImmidiate input[type="checkbox"]', performStartImmediateChange);
    $('body').on('dp.change', '.mg-popup-start input[id="popup_modal_popup[start]"]', performActualPopupStatus);
    $('body').on('dp.change', '.mg-popup-end input[id="popup_modal_popup[end]"]', performActualPopupStatus);
    $('body').on('change', '#mg-popup-neverEnd input[type="checkbox"]', performNeverEndChange);
    $('body').on('change', '.mg-popup-size input', performSizeChange);
    $('body').on('change', '.mg-popup-animation select', performAnimationTime);
    $('body').on('change', '.mg-popup-type select', performMessageTypeChange);
    $('body').on('click', '.mg-popup-imagemessage .uploadAjaxFile', uploadFile);
    $('body').on('change', '.mg-popup-copy select', loadSettingsFromCreate);
    $('body').on('change', '#mg-popup-runHours input[type="checkbox"]', performStartHourChange);
    $('body').on('change', '#mg-popup-runHours input[type="checkbox"]', performEndHourChange);
    $('body').on('change', '#mg-popup-activeDueDate input[type="checkbox"]', performDueDateType);
    $('body').on('change', '#mg-popup-activeDueDate input[type="checkbox"]', performDueDateCondition);
    $('body').on('change', '#mg-popup-activeDueDate input[type="checkbox"]', performDueDateDays);
    $('body').on('change', '#mg-popup-activeDueDate input[type="checkbox"]', performWithProduct);
    $('body').on('change', '#mg-popup-activeDueDate input[type="checkbox"]', performActiveStatus);
    $('body').on('change', '#mg-popup-withProductsCheckbox input[type="checkbox"]', performProducts);
    $('body').on('change', '#mg-popup-activeStatusSelect input[type="checkbox"]', performProductStatus);
    $('body').on('change', '#mg-popup-withProductsCheckbox input[type="checkbox"]', performAddons);
    $('body').on('change', '#mg-popup-withProductsCheckbox input[type="checkbox"]', performDomains);

    $('body').on('change', '#mg-popup-startImmidiate-edit input[type="checkbox"]', performStartImmediateChangeEdit);
    $('body').on('dp.change', '.mg-popup-start-edit input[id="popup_modal_popup[start]"]', performActualPopupStatusEdit);
    $('body').on('dp.change', '.mg-popup-end-edit input[id="popup_modal_popup[end]"]', performActualPopupStatusEdit);
    $('body').on('change', '#mg-popup-neverEnd-edit input[type="checkbox"]', performNeverEndChangeEdit);
    $('body').on('change', '.mg-popup-size-edit input', performSizeChangeEdit);
    $('body').on('change', '.mg-popup-animation-edit select', performAnimationTimeEdit);
    $('body').on('change', '.mg-popup-type-edit select', performMessageTypeChangeEdit);
    $('body').on('click', '.mg-popup-imagemessage-edit .uploadAjaxFile', uploadFile);
    $('body').on('change', '.mg-popup-copy-edit select', loadSettingsFrom);
    $('body').on('change', '#mg-popup-runHours-edit input[type="checkbox"]', performStartHourChangeEdit);
    $('body').on('change', '#mg-popup-runHours-edit input[type="checkbox"]', performEndHourChangeEdit);
    $('body').on('change', '#mg-popup-activeDueDate-edit input[type="checkbox"]', performDueDateTypeEdit);
    $('body').on('change', '#mg-popup-activeDueDate-edit input[type="checkbox"]', performDueDateConditionEdit);
    $('body').on('change', '#mg-popup-activeDueDate-edit input[type="checkbox"]', performDueDateDaysEdit);
    $('body').on('change', '#mg-popup-activeDueDate-edit input[type="checkbox"]', performWithProductEdit);
    $('body').on('change', '#mg-popup-activeDueDate-edit input[type="checkbox"]', performActiveStatusEdit);
    $('body').on('change', '#mg-popup-withProductsCheckbox-edit input[type="checkbox"]', performProductsEdit);
    $('body').on('change', '#mg-popup-activeStatusSelect-edit input[type="checkbox"]', performProductStatusEdit);
    $('body').on('change', '#mg-popup-withProductsCheckbox-edit input[type="checkbox"]', performAddonsEdit);
    $('body').on('change', '#mg-popup-withProductsCheckbox-edit input[type="checkbox"]', performDomainsEdit);
};

var addImage = function (radio, suffix) {
    var form = radio.parents('form');
    if (radio.val() === 'image') {
        pasteImage(form, suffix);
    }
};

var pasteImage = function(form, suffix) {    
    var filename = form.find('input[name="popup[image_name]"]').val();
    if (filename.length > 0) {
        $('.mg-uploaded-image').remove();
        var fullUrl = document.location.href;
        var urlArray = fullUrl.split('admin');
        fileUrl = urlArray[0] + 'modules/addons/PopupModule/templates/clientarea/assets/popup/' + filename;
        var img = '<div class="mg-uploaded-image"><label class="col-sm-3 control-label">Image</label><div class="col-sm-8"><img style="width: 100%;" src="' + fileUrl + '" /></div></div>';
        form.find('.mg-popup-imagemessage' + suffix).append(img);
    }
}

var fireLibraries = function (form) {

    $(form + ' [data-datetimepicker]').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    
     $(form + ' [data-timepicker]').datetimepicker({
        format: 'HH:mm:ss'//LT 
    });

    $(form + " textarea.tinymce").tinymce({
        // Location of TinyMCE script
        script_url: "../assets/js/tiny_mce/tiny_mce.js",
        // General options
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,advlist",
        entity_encoding: "raw",
        // Theme options
        theme_advanced_buttons1: "cut,copy,paste,pastetext,pasteword,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons2: "fontselect,fontsizeselect,forecolor,backcolor,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,",
        theme_advanced_buttons3: "undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        convert_urls: false,
        relative_urls: false,
        forced_root_block: false,
        width: '100%',
        height: '500px'
    });
};
