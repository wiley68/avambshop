function HideShowFirm(){
	if ($("#isfirma").is(':checked')){
		$("#isfirm_group").show();
	}else {
		$("#isfirm_group").hide();
	}
}

HideShowFirm();

$("#isfirma").change(function(){
	HideShowFirm();
});
