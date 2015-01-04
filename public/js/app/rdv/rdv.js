$(function() {    
    $("[data-toggle=popover]").popover();
    $('[data-toggle=tooltip]').tooltip();
    $('#rdv-date ').datepicker({
    	language: "fr",
    	startDate: "+2d",
    	autoclose: true,
    	todayHighlight: false,
    	clearBtn : true
    	/* todayBtn: "linked"*/
    });
    
    /*
    $( "#rdv-date" ).change(function() {
    	console.log($("#rdv-date").datepicker('getDate').toString());
    });
    */
    
    
    
    
});

