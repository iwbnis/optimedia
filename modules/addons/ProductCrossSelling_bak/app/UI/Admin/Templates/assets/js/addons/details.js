mgEventHandler.on('ModalLoaded', null, function (componentId, params) {

    if(['addProductButton', 'editProductButton'].indexOf(componentId) === false)
    {
        return;
    }
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



function toggleFormSectionCustom(vueControler, params, event)
{
    var section = $("#"+params.section);
    if(section.hasClass("hidden"))
    {
        section.css("display", "none");
        section.removeClass("hidden");
    }

    section.slideToggle();
}

function priorityChange(self, data, event, namespace, index) {

    self.showSpinner(event);
    self.appActionBlockingState = true;
    var actionElementId = $(event.target).closest('tr').attr('actionid');
    var loadData = {
        loadData: data.id,
        namespace: namespace,
        index: index,
        actionElementId: actionElementId
    };
    var response = mgPageControler.vueLoader.vloadData(loadData);

    response.done(function (res) {

        if(res.data.status === 'error')
        {
            self.hideSpinner(event);
            self.appActionBlockingState = false;
            mgPageControler.vueLoader.handleErrorMessage(res.data);
            return;
        }

        $.each(mgPageControler.vueLoader.$children, function (index, value) {
            if(value.component_id === data.id)
            {
                value.updateProjects();
            }
        });
        self.hideSpinner(event);
        self.appActionBlockingState = false;
    }).fail(function(jqXHR, textStatus, errorThrown) {
        mgPageControler.vueLoader.handleServerError(jqXHR, textStatus, errorThrown);
        self.hideSpinner(event);
        self.appActionBlockingState = false;
    });



}