$(document).ready(function() {
	$("#deconnexion").click(function(){
		if (!confirm('Voulez-vous vraiment vous déconnecter ?'))
			return false;
	});

	$("li.nav a").mouseover(function() {
		$(this).css("color", "#ffffff");
		$(this).parent().css("background-color", "#2bcebb");
	});

	$("li.nav a").mouseleave(function() {
		$(this).css("color", "#2bcebb");
		$(this).parent().css("background-color", "#ffffff");
	});

	$("table tr.basique").click(function() {
		if (confirm("Voulez-vous vraiment vous inscrire à la formation : " + $(this).attr("title") + " ?"))
			document.forms["formation" + $(this).attr("id")].submit();
	});

	$("table tr.demandee, table tr.acceptee").click(function() {
		if (confirm("Voulez-vous vraiment vous désinscrire de la formation : " + $(this).attr("title") + " ?"))
			document.forms["formation" + $(this).attr("id")].submit();
	});

	$("table td.accepter").click(function() {
		if (confirm("Voulez-vous vraiment accepter " + $(this).attr("login") + " à la formation : " + $(this).attr("formation") + " ?"))
			document.forms["accepter_" + $(this).attr("userId") + "_" + $(this).attr("formId")].submit();
	});

	$("table td.refuser").click(function() {
		if (confirm("Voulez-vous vraiment refuser " + $(this).attr("login") + " à la formation : " + $(this).attr("formation") + " ?"))
			document.forms["refuser_" + $(this).attr("userId") + "_" + $(this).attr("formId")].submit();
	});

});