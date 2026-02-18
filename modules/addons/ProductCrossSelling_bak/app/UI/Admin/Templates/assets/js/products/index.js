mgEventHandler.on('ModalLoaded', 'imageButton', function (componentId, params) {
    jscolor.installByClassName("jscolor");

    var modal = $(params.modalInstance.$el);
    var formId = "#" + modal.find('form').attr('id');

    var image = $(formId).find('.title-icon');
    var color = $(formId).find('input[name="backgroundColor"]').val();
    image.css('background-color', "#" + color);
});

mgEventHandler.on('JsColorUpdate', 'backgroundColor', function (componentId, params) {

    var r = params.data.rgb[0];
    var g = params.data.rgb[1];
    var b = params.data.rgb[2];

    var image = $('#' + componentId).closest('form').find('.title-icon');
    image.css('background-color', 'rgb('+r+','+g+','+b+')');
});


function switchOff(data, id, params) {
    var switcher = $(params.target);
    switcher.prop( "checked", false );
}

