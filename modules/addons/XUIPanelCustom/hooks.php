<?php

use WHMCS\Database\Capsule;

/**
 * WHMCS SDK Sample Addon Module Hooks File
 *
 * Hooks allow you to tie into events that occur within the WHMCS application.
 *
 * This allows you to execute your own code in addition to, or sometimes even
 * instead of that which WHMCS executes by default.
 *
 * @see https://developers.whmcs.com/hooks/
 *
 * @copyright Copyright (c) WHMCS Limited 2017 
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require any libraries needed for the module to function.
// require_once __DIR__ . '/path/to/library/loader.php';
//
// Also, perform any initialization required by the service's library.

/**
 * Register a hook with WHMCS.
 *
 * This sample demonstrates triggering a service call when a change is made to
 * a client profile within WHMCS.
 *
 * For more information, please refer to https://developers.whmcs.com/hooks/
 *
 * add_hook(string $hookPointName, int $priority, string|array|Closure $function)
 */
add_hook('ClientEdit', 1, function(array $params) {
    try {
        // Call the service's function, using the values provided by WHMCS in
        // `$params`.
    } catch (Exception $e) {
        // Consider logging or reporting the error.
    }
});

add_hook('ClientAreaPageViewInvoice', 1, function($vars) {

$invoiceId = $_GET['id'];

$productid = Capsule::table('tblinvoiceitems')
    ->join('tblhosting', 'tblinvoiceitems.relid', '=', 'tblhosting.id')
    ->where('tblinvoiceitems.invoiceid','=', $invoiceId)
    ->where('tblinvoiceitems.type', '=', 'Hosting')
    ->select('tblhosting.username')
    ->first();
    
$username = $productid->username;
$vars['username'] = $username;
 
return $vars;

});  


add_hook('ClientAreaHeadOutput', 1, function($vars) {
    $template = $vars['templatefile'];
    if($template == 'upgrade'){
    return <<<HTML
<script type="text/javascript">
$(document).ready(function () {
    $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'getproductgroup',
            },
            success: function(response) {
                if (response) {
                        var dataObject = JSON.parse(response);
                        
                        var idsToRemove = [7, 10, 11, 13, 14, 22];
                        
                        dataObject = dataObject.filter(function(item) {
                            return !idsToRemove.includes(item.id);
                        }); 
                        
                        dataObject.sort(function(a, b) {
                            var nameA = a.name.toUpperCase(); 
                            var nameB = b.name.toUpperCase(); 
                            if (nameA < nameB) {
                                return -1;
                            }
                            if (nameA > nameB) {
                                return 1;
                            }
                            return 0; 
                        });
                        
                        var selectElement = document.getElementById("choose_package");
                        
                        if (selectElement) {
                            selectElement.innerHTML = "";
                            
                            
                            var defaultOption = document.createElement("option");
                            defaultOption.value = "";
                            defaultOption.textContent = "Choose Package"; 
                            defaultOption.selected = true; 
                            defaultOption.disabled = true; 
                            selectElement.appendChild(defaultOption);
                            
                            dataObject.forEach(function(item) {
                                var option = document.createElement("option");
                                option.value = item.slug; 
                                option.textContent = item.name;
                                selectElement.appendChild(option);
                            });
                        }
                    }
            
            }
        });
});
</script>
HTML;
}
});

add_hook('ClientAreaFooterOutput', 1, function ($vars) {
    $template = $vars['templatefile'];
   if($template == 'supportticketsubmit-steptwo'){
       return <<<HTML
    <script type="text/javascript">
    $(document).ready(function () {
    
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Is this related to live TV?'){
            var relatedtv = labels[i].getAttribute('for');
            break;
        }
    }
    
    
    
    var selectBox = document.getElementById(relatedtv);
    selectBox.selectedIndex = 0;
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select channel category'){
            var cate = labels[i].getAttribute('for');
            break;
        }
    }
    
    var cates = document.getElementById(cate);
    cates.style.display = 'none';
    
    $('label[for=' + cate + ']').hide();
    
    
    
    var selectBox = document.getElementById(cate);
    for (var i = selectBox.options.length - 1; i > 0; i--) {
        selectBox.remove(i);
    }
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Channel list'){
            var listed = labels[i].getAttribute('for');
            break;
        }
    }
    
    
    var catelist = document.getElementById(listed);
    catelist.style.display = 'none';
    
    $('label[for=' + listed + ']').hide();
    
    
    
    var selectBox2 = document.getElementById(listed);
    for (var i = selectBox2.options.length - 1; i > 0; i--) {
        selectBox2.remove(i);
    }
    
    //For Usernames
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select Username'){
            var selectnames = labels[i].getAttribute('for');
            break;
        }
    }
    
    if(selectnames){
            document.getElementById(selectnames).addEventListener('change', function() {
            var selectedText = this.options[this.selectedIndex].text;
            
            console.log(selectedText);
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'selectoption',
                        selectedText: selectedText,
                    },
                    success: function(response) {
                        
                    }
                });
            });
    }
    
    
    //For Channel Cat
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select channel category'){
            var channelcat = labels[i].getAttribute('for');
            break;
        }
    }
    if(channelcat){
    document.getElementById(channelcat).addEventListener('change', function() {
    var selectedText = this.options[this.selectedIndex].text;
    
     var encodedValue = encodeURIComponent(selectedText);
     
        $.ajax({
            url: 'submitticket.php?step=2&deptid=1',
            type: 'POST',
            data: {
                action: 'selectchanneloption',
                encodedValue: encodedValue,
            },
            success: function(response) {
                
            }
        });
    });
    }
    
   
    //For Channel list
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Channel list'){
            var channellist = labels[i].getAttribute('for');
            break;
        }
    }
    if(channellist){
    document.getElementById(channellist).addEventListener('change', function() {
    var selectedText = this.options[this.selectedIndex].text;
    
     var encodedValue = encodeURIComponent(selectedText);
     console.log(encodedValue);
        $.ajax({
            url: 'submitticket.php?step=2&deptid=1',
            type: 'POST',
            data: {
                action: 'selectchannellist',
                encodedValue: encodedValue,
            },
            success: function(response) {
                
            }
        });
    });
    }
    

     $.ajax({
        url: 'submitticket.php?step=2&deptid=1',
        type: 'POST',
        data: {
            action: 'getusernamesss',
        },
        success: function(response) { 
        
        try{
            var dataObject = JSON.parse(response);

            if (dataObject.redirect) {
                window.location.href = dataObject.redirect;
                return;
            }
        
            var dataArray = Object.entries(dataObject);
        
            var nonEmptyValues = dataArray.filter(function(item) {
                return item[0].trim() !== ''; 
            });
        
            var select = $('#'+ selectnames);
            select.empty();
            
            if (dataArray.length === 0) {
                selectElement.append('<option value="">None</option>');
            }else{
                select.append('<option value="">Select username</option>');
        
                nonEmptyValues.forEach(function(item) {
                    var username = item[0]; 
                    var userId = item[1]; 
                    select.append('<option value="' + username + '">' + username + '</option>');
                });
            }
        }catch (error) {
            console.error('Error parsing JSON001:', error);
        }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }

    });
   
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select Username'){
            var uname = labels[i].getAttribute('for');
            break;
        }
    }
    

    
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select TV series Categories') {
            var moviescatgoryIds = labels[i].getAttribute('for');
            break;
        }
    }
    
    
    const getseriescat = document.getElementById(moviescatgoryIds);
    
    if (getseriescat) {
        getseriescat.addEventListener('change', function() {
            const selectValue = getseriescat.value;
            if (selectValue !== '') {
                getseriescate(selectValue);
            }
        });
    }
    
    
    function getseriescate(selectedValue) { 
    
    var encodedValue = encodeURIComponent(selectedValue);
    
    $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'getseriescateee',
            category: encodedValue
        },
        beforeSend: function () {
            $('#loader').show(); 
        },
        success: function (response) {
                    try {
                    var responseData = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    var labels = document.getElementsByTagName('label');
                    var seriesid;
            
                    for (var i = 0; i < labels.length; i++) {
                        if (labels[i].textContent.trim() === 'TV series list') {
                            seriesid = labels[i].getAttribute('for');
                            break;
                        }
                    }
            
                    var select1 = $('#' + seriesid);
                    select1.empty();
                    select1.append('<option value="none">Select tv Series list</option>');
            
                    if (Array.isArray(responseData)) {
                         for (let i = 0; i <= responseData.length-1; i++){
                           const option = document.createElement('option');
                                option.value = responseData[i]; 
                            option.text = responseData[i]; 
                            const selectElement = document.getElementById(seriesid);
                            selectElement.appendChild(option);
                        }
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                } finally {
                    $('#loader').hide();
                } 
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', error);
            }
        });
    }
    
    
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select Movie Categories') {
            var moviescatgoryIds = labels[i].getAttribute('for');
            break;
        }
    }
    const moviecatgory = document.getElementById(moviescatgoryIds);
    
    if(moviecatgory){
        moviecatgory.addEventListener('change', function() {
        const selectValue = moviecatgory.value;
        if (moviecatgory.value !== '') {
            moviecat(selectValue);
        }
    });
    }
    
    
    function moviecat(selectedValue) {
    
    var encodedValue = encodeURIComponent(selectedValue);
    
    $.ajax({
        url: '', 
        type: 'POST',
        data: {
            action: 'moviescategory',
            category: encodedValue
        },
        beforeSend: function () {
            $('#loader').show(); 
        },
        success: function (response) {
            try {
            var responseData = typeof response === 'string' ? JSON.parse(response) : response;
            
            var labels = document.getElementsByTagName('label');
            var moviesid;
    
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Movies list') {
                    moviesid = labels[i].getAttribute('for');
                    break;
                }
            }
    
            var select1 = $('#' + moviesid);
            select1.empty();
            select1.append('<option value="none">Select Movies list</option>');
    
            if (Array.isArray(responseData)) {
                const uniqueValues = new Set();
            
                for (let i = 0; i < responseData.length; i++) {
                    // Check if the value is not already added to the set
                    if (!uniqueValues.has(responseData[i])) {
                        const option = document.createElement('option');
                        option.value = responseData[i];
                        option.text = responseData[i];
            
                        const selectElement = document.getElementById(moviesid);
                        selectElement.appendChild(option);
            
                        // Add the value to the set to track uniqueness
                        uniqueValues.add(responseData[i]);
                    }
                }
            }

        } catch (error) {
            console.error('Error parsing response:', error);
        } finally {
            $('#loader').hide();
        }
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed:', error);
    }
    });
    }
    
    
     
    
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].textContent.trim() === 'Select channel category') {
            var selectcatgoryIds = labels[i].getAttribute('for');
            break;
        }
    }
    
    const selectcatgory = document.getElementById(selectcatgoryIds);
    
    if(selectcatgory){
        selectcatgory.addEventListener('change', function() {
        
        
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Channel list') {
                var selectlist = labels[i].getAttribute('for');
                break;
            }
        }
        
        
        var catesf = document.getElementById(selectlist);
        catesf.style.display = 'block';
        
        $('label[for=' + catesf.id + ']').show();
    
        var selectedOption = selectcatgory.options[selectcatgory.selectedIndex];
        
        var selectedId = selectedOption.id;
    
        const selectedValue = selectedId;
        
        if (selectcatgory.value !== '') {
            selectcatgoryId(selectedValue);
        }
    });
    }
    
    function selectcatgoryId(selectedValue) {
    
        $.ajax({
            url: 'submitticket.php?step=2&deptid=1', 
            type: 'POST',
            data: {
                action: 'channelcategory',
                category: selectedValue
            },
            beforeSend: function () {
                $('#loader').show(); 
            },
            success: function (response) { 
                    try {
                            var responseData = typeof response === 'string' ? JSON.parse(response) : response;
                            
                            var labels = document.getElementsByTagName('label');
                            var channelid;
                    
                            for (var i = 0; i < labels.length; i++) {
                                if (labels[i].textContent.trim() === 'Channel list') {
                                    channelid = labels[i].getAttribute('for');
                                    break;
                                }
                            }
                    
                            var select1 = $('#'+ channelid);
                            select1.empty();
                            select1.append('<option value="none">Select Channel list</option>');
                    
                            if (Array.isArray(responseData)) {
                                 for (let i = 0; i <= responseData.length-1; i++){
                                   const option = document.createElement('option');
                                        option.value = responseData[i]; 
                                    option.text = responseData[i]; 
                                    const selectElement = document.getElementById(channelid);
                                    selectElement.appendChild(option);
                                }
                            }
                        } catch (error) {
                            console.error('Error parsing response:', error);
                        } finally {
                            $('#loader').hide();
                        }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX request failed:', error);
                        }
        });

    }
   
 
        var labels = document.getElementsByTagName('label');
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].textContent.trim() === 'Is this related to live TV?'){
                var livetvid = labels[i].getAttribute('for');
                break;
            }
        }
            var selectedValue = ''; 
            var clickCount = 0;
            
           $('#' + livetvid).on('change', function() {
            clickCount++;
            var selectedValue = $(this).val();
            
            
            if (selectedValue === "No") {
                
            var labels = document.getElementsByTagName('label');
            var nextchannelid;
            var channelsecid;
            
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select channel category') {
                    nextchannelid = labels[i].getAttribute('for');
                } else if (labels[i].textContent.trim() === 'Channel list') {
                    channelsecid = labels[i].getAttribute('for');
                }
            }
            
            
            var cates = document.getElementById(nextchannelid);
            cates.style.display = 'none';
            
            $('label[for=' + nextchannelid + ']').hide(); 
            
            
            var catesf = document.getElementById(channelsecid);
            catesf.style.display = 'none';
            
            $('label[for=' + channelsecid + ']').hide(); 
            
            
            
            }
            if (selectedValue === "Yes") {
                
            var labels = document.getElementsByTagName('label');
            var nextchannelid;
            var channelsecid;
            
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select channel category') {
                    nextchannelid = labels[i].getAttribute('for');
                } else if (labels[i].textContent.trim() === 'Channel list') {
                    channelsecid = labels[i].getAttribute('for');
                }
            }
            
            
            var cates = document.getElementById(nextchannelid);
            cates.style.display = 'block';
            
            $('label[for=' + nextchannelid + ']').show(); 
            
            var selectNext = document.getElementById(nextchannelid);
            var selectChannel = document.getElementById(channelsecid);
        
            
            if (selectedValue === 'No') {
            
                selectNext.innerHTML = '';
                selectChannel.innerHTML = '';
            
                var noneOptionNext = document.createElement('option');
                noneOptionNext.value = 'none';
                noneOptionNext.text = 'None';
                selectNext.appendChild(noneOptionNext);
            
                var noneOptionChannel = document.createElement('option');
                noneOptionChannel.value = 'none';
                noneOptionChannel.text = 'None';
                selectChannel.appendChild(noneOptionChannel);
                
            }

    
            if (selectedValue === "Yes") {
            
                $.ajax({
                    url: 'submitticket.php?step=2&deptid=1',
                    type: 'POST',
                    data: {
                        action: 'get_streams'
                    },
                    beforeSend: function () {
                        $('#loader').show(); 
                    },
                    success: function (response) {
                            try {
                            var responseData = typeof response === 'string' ? JSON.parse(response) : response;
                    
                            var labels = document.getElementsByTagName('label');
                            var channelid;
                    
                            for (var i = 0; i < labels.length; i++) {
                                if (labels[i].textContent.trim() === 'Select channel category') {
                                    channelid = labels[i].getAttribute('for');
                                    break;
                                }
                            }
                    
                            var select1 = $('#' + channelid);
                            select1.empty();
                            select1.append('<option value="none">Select channel category</option>');
                    
                            if (Array.isArray(responseData.data)) {
                            responseData.data.forEach(function (category) {
                                var option = $('<option></option>').attr({
                                    'value': category.category_name,
                                    'id': category.id
                                }).text(category.category_name);
                                select1.append(option);
                            });
                        }

                        } catch (error) {
                            console.error('Error parsing response:', error);
                        } finally {
                            $('#loader').hide();
                        }
                       
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX request failed: ' + error);
                        $('#loader').hide();
                    }
                });
            }
                
            }

            });
            
           
            
            var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Is this related to Movies?'){
                    var relatedmovies = labels[i].getAttribute('for');
                    break;
                }
            }
            $('#'+ relatedmovies).on('change', function() {
            var selectedValue = $(this).val();
            
            
            
            var labels = document.getElementsByTagName('label');
            var nextchannelid;
            var channelsecid;
            
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select Movie Categories') {
                    nextchannelid = labels[i].getAttribute('for');
                } else if (labels[i].textContent.trim() === 'Movies list') {
                    channelsecid = labels[i].getAttribute('for');
                }
            }
            
            var selectNext = document.getElementById(nextchannelid);
            var selectChannel = document.getElementById(channelsecid);
        
            
            if (selectedValue === 'No') {
            
                selectNext.innerHTML = '';
                selectChannel.innerHTML = '';
            
                var noneOptionNext = document.createElement('option');
                noneOptionNext.value = 'none';
                noneOptionNext.text = 'None';
                selectNext.appendChild(noneOptionNext);
            
                var noneOptionChannel = document.createElement('option');
                noneOptionChannel.value = 'none';
                noneOptionChannel.text = 'None';
                selectChannel.appendChild(noneOptionChannel);
                
            }
        
            
            if (selectedValue === "Yes") {
                $.ajax({
                    url: '', 
                    type: 'POST',
                    data: {
                        action: 'get_movies'
                    },
                    beforeSend: function () {
                        $('#loader').show(); 
                    },
                    success: function (response) {
                    try {
                    
                    var responseData = typeof response === 'string' ? JSON.parse(response) : response;
    
                    var labels = document.getElementsByTagName('label');
                    var moviescatelabel;
                    
                    for (var i = 0; i < labels.length; i++) {
                        if (labels[i].textContent.trim() === 'Select Movie Categories'){
                            var moviescatelabel = labels[i].getAttribute('for');
                            break;
                        }
                    }
                    
                    var select1 = $('#' + moviescatelabel);
                    select1.empty();
                    select1.append('<option value="none">Select movies category</option>');
                    
                    if (Array.isArray(responseData.data)) {
                        responseData.data.forEach(function (category) {
                            var option = $('<option></option>').attr('value', category.id).text(category.category_name);
                            select1.append(option);
                        });
                    }
                    
                    
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                    }finally { 
                        $('#loader').hide();
                    }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX request failed: ' + error);
                    }
                });
            }
            });
            
            var labels = document.getElementsByTagName('label');
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Is this related tv series?'){
                    var relatedtvseries = labels[i].getAttribute('for');
                    break;
                }
            }
            $('#'+ relatedtvseries).on('change', function() {
            var selectedValue = $(this).val(); 
            
            
            var labels = document.getElementsByTagName('label');
            var nextchannelid;
            var channelsecid;
            
            for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent.trim() === 'Select TV series Categories') {
                    nextchannelid = labels[i].getAttribute('for');
                } else if (labels[i].textContent.trim() === 'TV series list') {
                    channelsecid = labels[i].getAttribute('for');
                }
            }
            
            var selectNext = document.getElementById(nextchannelid);
            var selectChannel = document.getElementById(channelsecid);
        
            if (selectedValue === 'No') {
                
                selectNext.innerHTML = '';
                selectChannel.innerHTML = '';
            
                var noneOptionNext = document.createElement('option');
                noneOptionNext.value = 'none';
                noneOptionNext.text = 'None';
                selectNext.appendChild(noneOptionNext);
            
                var noneOptionChannel = document.createElement('option');
                noneOptionChannel.value = 'none';
                noneOptionChannel.text = 'None';
                selectChannel.appendChild(noneOptionChannel);
            }

            
            if (selectedValue === "Yes") {
                $.ajax({
                    url: '', 
                    type: 'POST',
                    data: {
                        action: 'get_series'
                    },
                    beforeSend: function () {
                        $('#loader').show(); 
                    },
                    success: function (response) {

                            
                        try {
                        
                        var responseData = typeof response === 'string' ? JSON.parse(response) : response;
                    
                        var labels = document.getElementsByTagName('label');
                        var moviescatelabel;
                        
                        for (var i = 0; i < labels.length; i++) {
                            if (labels[i].textContent.trim() === 'Select TV series Categories'){
                                var moviescatelabel = labels[i].getAttribute('for');
                                break;
                            }
                        }
                        
                        var select1 = $('#' + moviescatelabel);
                        select1.empty();
                        select1.append('<option value="none">Select TV series </option>');
                        
                        if (Array.isArray(responseData.data)) {
                            responseData.data.forEach(function (category) {
                                var option = $('<option></option>').attr('value', category.id).text(category.category_name);
                                select1.append(option);
                            });
                        }
                        
                        
                        } catch (error) {
                            console.error('Error parsing JSON response:', error);
                        }finally { 
                            $('#loader').hide();
                        }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX request failed: ' + error);
                        }
                });
            }
            });
        });
    </script>
HTML;
   }
});



add_hook('ClientAreaPage', 0, function($vars) {
    
    if (isset($_POST['action']) && $_POST['action'] === 'channelcategory') {
        
        $category = $_POST['category'];
        
        $api_url = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=streams&category_id=' . $category;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        $jsonData = json_decode($result, true);
        
        if ($jsonData['status'] === 'STATUS_SUCCESS') {
            $totalPages = $jsonData['totalPage'];
            
            $streamNames = [];
            $api_urls = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=streams&category_id=' . $category . '&page=1';

            
            for ($page = 0; $page <= $totalPages; $page++) {
                curl_setopt($ch, CURLOPT_URL,'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=streams&category_id=' . $category . '&page='.$page);
                
                $result = curl_exec($ch);
                $jsonData = json_decode($result, true);
                
                foreach ($jsonData['data'] as $stream) {      
                if (isset($stream['name'])) {
                        $streamNames[] = $stream['name'];
                    }
                }
            }
            
        echo json_encode($streamNames);
        exit();
        } else {
            echo 'Error: Failed to fetch data.';
        }
        curl_close($ch);
        
    };
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'getseriescateee') {
    
        $category = $_POST['category'];
        $api_url = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=series&category_id=' . $category;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        $jsonData = json_decode($result, true);
        
        if ($jsonData['status'] === 'STATUS_SUCCESS') {
            $totalPages = $jsonData['totalPage'];
            
            $streamNames = [];
            
            $api_urls = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=series&category_id=' . $category . '&page=1';

            
            for ($page = 0; $page <= $totalPages; $page++) {
                curl_setopt($ch, CURLOPT_URL,'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=series&category_id=' . $category . '&page='.$page);
                
                $result = curl_exec($ch);
                $jsonData = json_decode($result, true);
                
                foreach ($jsonData['data'] as $stream) {      
                if (isset($stream['name'])) {
                        $streamNames[] = $stream['name'];
                    }
                }
            }
            
        echo json_encode($streamNames);
        exit();
        } else {
            echo 'Error: Failed to fetch data.';
        }
        curl_close($ch);

    };
     
    if (isset($_POST['action']) && $_POST['action'] === 'moviescategory') {
    
        
        $category = $_POST['category'];
        
        $api_url = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=movies&category_id=' . $category;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        $jsonData = json_decode($result, true);
        
        if ($jsonData['status'] === 'STATUS_SUCCESS') {
            $totalPages = $jsonData['totalPage'];
            
            $streamNames = [];
            
            $api_urls = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=movies&category_id=' . $category . '&page=1';

            for ($page = 0; $page <= $totalPages; $page++) {
                curl_setopt($ch, CURLOPT_URL,'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=movies&category_id=' . $category . '&page='.$page);
                
                $result = curl_exec($ch);
                $jsonData = json_decode($result, true);
                
                foreach ($jsonData['data'] as $stream) {      
                if (isset($stream['name'])) {
                        $streamNames[] = $stream['name'];
                    }
                }
            }
            
        echo json_encode($streamNames);
        exit();
        } else {
            echo 'Error: Failed to fetch data.';
        }
        curl_close($ch);
        
    };

    //Get Channel Streams Category

    if (isset($_POST['action']) && $_POST['action'] === 'get_streams') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_category&type=streams');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        
        $jsonData = json_decode($result, true);
        echo json_encode($jsonData);
        exit();
        
    };


    //Get Movies Category
    
    if (isset($_POST['action']) && $_POST['action'] === 'get_movies') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_category&type=movies');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $jsonData = json_decode($result, true);
        echo json_encode($jsonData);
        exit();
        
    };
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'get_series') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_category&type=series');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        $jsonData = json_decode($result, true);
   
        echo json_encode($jsonData);
        exit();
        
        
        
    };
    
        if (isset($_POST['action']) && $_POST['action'] === 'getusernamesss') {
            
        $command = 'GetClientsProducts';
        $postData = array(
            'clientid' => $_SESSION['uid'],
        );
        $adminUsername = '';

        if (empty($postData['clientid'])) {
             
            $response = array(
                'status' => 'error',
                'message' => 'Client ID is empty',
            );
            
        } 
        $results = localAPI($command, $postData, $adminUsername);
        $usernames = array(); 
        foreach ($results['products']['product'] as $product) {
            $username = $product['username'];
            $userId = $product['id'];
            $usernamesWithIds[$username] = $userId;

        }
        echo json_encode($usernamesWithIds);
        die();
    };
    
    
    
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'selectoption') {
        
        $fieldToUpdate = 'Select Username'; 
        $newFieldOptions = $_POST['selectedText'];
    
        $existingField = Capsule::table('tblcustomfields')
            ->where('fieldname', $fieldToUpdate)
            ->first();
            
        if ($existingField) {
            $existingOptions = $existingField->fieldoptions;
    
            if ($existingField) {
                
                $existingFields = Capsule::table('tblcustomfields')
                    ->where('fieldname', $fieldToUpdate)
                    ->update(['fieldoptions' => $newFieldOptions]);
                    
                print_r($existingFields); die;
            }
        }
    }
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'selectchanneloption') {
        
        $fieldToUpdate = 'Select channel category'; 

        $newFieldOptions = urldecode($_POST['encodedValue']); 
    
        $existingField = Capsule::table('tblcustomfields')
            ->where('fieldname', $fieldToUpdate)
            ->first();
            
        if ($existingField) {
            $existingOptions = $existingField->fieldoptions;
    
            if ($existingField) {
                
                $existingFields = Capsule::table('tblcustomfields')
                    ->where('fieldname', $fieldToUpdate)
                    ->update(['fieldoptions' => $newFieldOptions]);
                    
                print_r($existingFields); die;
            }
        }
    }
    
    
    if (isset($_POST['action']) && $_POST['action'] === 'selectchannellist') {
        
        $fieldToUpdate = 'Channel list'; 

        $newFieldOptions = urldecode($_POST['encodedValue']); 
    
        $existingField = Capsule::table('tblcustomfields')
            ->where('fieldname', $fieldToUpdate)
            ->first();
            
        if ($existingField) {
            $existingOptions = $existingField->fieldoptions;
    
            if ($existingField) {
                
                $existingFields = Capsule::table('tblcustomfields')
                    ->where('fieldname', $fieldToUpdate)
                    ->update(['fieldoptions' => $newFieldOptions]);
                    
                print_r($existingFields); die;
            }
        }
    }
    

    
    if (isset($_POST['action']) && $_POST['action'] === 'getproductgroup') {
        $hidden = 0; 
        $existingField = Capsule::table('tblproductgroups')
            ->where('hidden', $hidden)
            ->get();
        echo json_encode($existingField); die;
    }

   
});
