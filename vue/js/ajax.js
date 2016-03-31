var requeteAjax = null;
/*-----------création d’un objet HttpRequest----------*/
function getXMLHttpRequest() {
	var xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject('Msxml2.XMLHTTP');
			} catch (e) {
				xhr = new ActiveXObject('Microsoft.XMLHTTP');
			}
		} else {
			xhr = new XMLHttpRequest();
		}
	} else {
		alert('Votre navigateur ne supporte pas l\'objet XMLHTTPRequest...');
		return null;
	}

	return xhr;
}

function execute(cible, url, data, reload, panier) {
	requeteAjax = getXMLHttpRequest();
	// -------exécution de la requête en mode asynchrone-------------
	requeteAjax.open('POST', url, true);
	requeteAjax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	requeteAjax.setRequestHeader('If-Modified-Since', 'Sat, 1 Jan 2000 00:00:00 GMT');
	requeteAjax.onreadystatechange = function () {
		if (requeteAjax.readyState === 4) {
			var cc = document.getElementById(cible);
			var dd = requeteAjax.responseText;
			document.getElementById(cible).innerHTML = requeteAjax.responseText;
			if (reload) {
				location.reload();
			}
			if (data === 'action=panier') {
				initPanier();
				execute('nombre_articles_panier', 'index.php', 'action=articles');
			}
			if (panier) {
				execute('div_panier', 'index.php', 'action=panier');
			}
			if (data === 'action=deconnecter') {
				initialiser_hauteur();
				changer_hauteur_section(0);
			}
		}
	};
	requeteAjax.send(data);
}