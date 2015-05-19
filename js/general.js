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
});