var duree = 200;

$(window).load(function () {
	initialiser_hauteur();
});

$(document).ready(function () {
	$('#retour').bind('DOMNodeInserted DOMSubtreeModified DOMNodeRemoved', function (e) {
		console.log('Changed');
	});
});

//décaler verticalement la section principale pour qu'elle ne soit pas masquée par le header
function initialiser_hauteur() {
	var margin = $('#fixedHeader').height();
	var height = $(window).height() - margin;
	$('#panneaux_deroulants').css({
		'top': margin + 'px'
	});
	$('#mainWrapper').css({
		'margin-top': margin + 'px'
	});
	$('#mainWrapper').height(height);
	$('#retour').height(margin);
	$('#retour_ajax').height(margin);
}

function changer_hauteur_section(duree) {
	var margin = $('#fixedHeader').height() + $('#panneaux_deroulants').height();
	var height = $(window).height() - margin;
	$('#mainWrapper').animate({
		'margin-top': margin + 'px'
	}, duree);
	$('#mainWrapper').height(height);
}

$('body').on('click', '.ajouter', function (e) {
	var idArticle = e.target.id.substr(7);
	var selectArticle = document.getElementById('qte' + idArticle);
	var qteArticle = selectArticle.options[selectArticle.selectedIndex].value;
	var prixArticle = document.getElementById('prix' + idArticle).innerHTML;
	$('#retour_ajax').load('index.php', {action: 'ajout', article_id: idArticle, article_quantite: qteArticle, article_prix: prixArticle}, function () {
		updatePanier();
		$('#retour_ajax').animate(
				{
					width: 'show',
					paddingLeft: 'show',
					paddingRight: 'show'},
				{
					start: function () {
						$('#retour_ajax').css({'display': 'flex'});
					},
					complete: function () {
						setTimeout(function () {
							$('#retour_ajax').animate({
								width: 'hide',
								paddingLeft: 'hide',
								paddingRight: 'hide'});
						}, 2500);
					}
				});
	});
});

//gestion de l'affichage des div du header et des boutons correspondants
$('body').on('click', '.boutonHeader', function (e) {
	console.log(e.target.id.substr(16));
	var name = e.target.id.substr(16);
	var div = document.getElementById('div_' + name);
	var bouton = document.getElementById('bouton_afficher_' + name);

	if (getComputedStyle(div).display === 'none') {
		$('.deroulant').slideUp(duree);
		$('.boutonHeader').css({'background-color': '', 'color': ''});
		$(bouton).css({'background-color': '#3399ff', 'color': 'black'});
		if (name === 'panier') {
			$('#nombre_articles_panier').css({'background-color': 'black', 'color': '#3399ff'});
		} else {
			$('#nombre_articles_panier').css({'background-color': '', 'color': ''});
		}
		$(div).slideDown({duration: duree, start: function () {
				$(div).css({'display': 'flex'});
			}, complete: function () {
				changer_hauteur_section(duree);
			}});
	} else {
		$('#nombre_articles_panier').css({'background-color': '', 'color': ''});
		$(div).slideUp({duration: duree, complete: function () {
				changer_hauteur_section(duree);
			}});
		$(bouton).css({'background-color': '', 'color': ''});
	}
});

$('body').on('mouseenter', '.boutonHeader', function (e) {
	var name = e.target.id.substr(16);
	$('#menu_option_texte').html(name);
});

$('body').on('mouseenter', '.boutonHeaderNoDiv', function (e) {
	$('#menu_option_texte').html(e.target.id);
});

$('body').on('mouseleave', '.boutonHeader, .boutonHeaderNoDiv', function () {
	$('#menu_option_texte').html(' ');
});

$('body').on('click', '#bouton_afficher_panier', function () {
	$('#div_panier').load('index.php', {action: 'panier'}, function () {
		updatePanier();
	});
});

$('body').on('click', '#bouton_afficher_compte', function () {
	$('#div_commandes').load('index.php', {action: 'compte'});
});

$('body').on('click', '#administration', function () {
	window.location.href = 'index.php?page=admin';
});

$('body').on('click', '#stocks', function () {
	window.location.href = 'index.php?page=magasinier';
});

$('body').on('click', '#bouton_afficher_recherche', function () {
	var valeur_recherche = '';
	var valeur_type = '';

	$('#champ_recherche').on('input', function (e) {
		valeur_recherche = e.target.value;
		resultatRecherche(valeur_recherche, valeur_type);
	});

	$('.bouton_categorie').on('click', function (e) {
		$('.bouton_categorie').css({'color': '', 'font-weight': ''});
		console.log(e.target.id.substr(17));
		valeur_type = e.target.id.substr(17);
		e.target.style.color = '#3399ff';
		e.target.style.fontWeight = 'bold';
		resultatRecherche(valeur_recherche, valeur_type);
	});
});

$('body').on('click', '.ligne_commande', function (e) {
	id_commande = e.target.parentNode.id.substr(12);
	console.log(id_commande);
	$('#div_une_commande').load('index.php', {action: 'commande', commande: id_commande});
});

$('body').on('click', '#vider', function () {
	$('#nombre_articles_panier').load('index.php', {action: 'vider'}, function () {
		updatePanier();
	});
});

function resultatRecherche(recherche, type) {
	$('#section').load('index.php', {action: 'recherche', recherche: recherche, type: type});
}

function updatePanier() {
	$('#div_panier').load('index.php', {action: 'panier'}, function () {
		changer_hauteur_section(duree);
	});
	$('#nombre_articles_panier').load('index.php', {action: 'articles'});

}