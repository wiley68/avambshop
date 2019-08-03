$("#firm_info").hide();

$('#isfirma').change(function() {
	if ($( this ).prop("checked")){
		$("#firm_info").show();
		$("#eik").val($("#eik_if").val());
		$("#firmname").val($("#firmname_if").val());
		$("#dds_nomer").val($("#dds_nomer_if").val());
		$("#firmcity").val($("#firmcity_if").val());
		$("#firmaddress").val($("#firmaddress_if").val());
		$("#mol").val($("#mol_if").val());
	}else{
		$("#firm_info").hide();
		$("#eik").val("");
		$("#firmname").val("");
		$("#dds_nomer").val("");
		$("#firmcity").val("");
		$("#firmaddress").val("");
		$("#mol").val("");
	}
});

$('#submit_btn').click(function(event) {
	if ($('#isok').val() == "No") {
		alert("За някой от поръчаните стоки липсва Доставчик или Платежен метод. Не можете да поръчата стоката!");
		event.preventDefault();
		return;
	}
});
