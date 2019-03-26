function clearDateRange()
{
    $(".input-daterange-datepicker").val("");
}

$(document).ready(function() {
    "use strict";
    
    /* Select2 Init*/
    $(".select2").select2();

    /* Daterange picker Init*/
	$('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-info',
            cancelClass: 'btn-default'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default',
        dateLimit: {
            days: 6
        }
    });

    clearDateRange();
    
});

/*
    Fade out alerts
*/
$(".alert").fadeTo(5000, 1000).slideUp(1000, function(){
    $(".alert").slideUp(1000);
});

/*
    Select child sections
*/
$(document).on("change",".parent_sections select",function()
{
    var section_parent = $(this).val();
    var base_url = $("#base_url").val();
    
    $.ajax({
        type:'POST',
        url: base_url+'hr/personnel/get_section_children/'+section_parent,
        cache:false,
        contentType: false,
        processData: false,
        dataType: 'text',
        success:function(data)
        {	
            $(".child_sections select").html(data);
        },
        error: function(xhr, status, error) 
        {
            alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
        }
    });
    
    return false;
});

/*
    Check all checkboxes
*/
$("#allcheckbox").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});