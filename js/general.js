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
			window.location.href = "?action=inscription&formation=" + $(this).attr("id");
	});

	$("table tr.demandee, table tr.acceptee").click(function() {
		if (confirm("Voulez-vous vraiment vous désinscrire de la formation : " + $(this).attr("title") + " ?"))
			window.location.href = "?action=desinscription&formation=" + $(this).attr("id");
	});

});