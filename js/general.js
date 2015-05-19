$(document).ready(function() {
	$("#deconnexion").click(function(){
		if (confirm('Voulez-vous vraiment vous déconnecter ?'))
			document.location.href = window.location.href + '?deconnexion';
	});
});