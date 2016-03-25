window.onload = initHeader(0);

//décaler verticalement le header pour qu'il ne cache pas la div du catalogue
function initHeader(duree) {
    var height = $('#fixedHeader').outerHeight();
    $('#mainWrapper').animate({
        'margin-top': height + 'px'
    }, duree);
}

$('body').on('click', '.ajouter', function (e) {
    var idArticle = e.target.id.substr(7);
    var selectArticle = document.getElementById('qte' + idArticle);
    var qteArticle = selectArticle.options[selectArticle.selectedIndex].value;
    var prixArticle = document.getElementById('prix' + idArticle).innerHTML;
    execute('retour', 'index.php', 'action=ajout&article_id=' + idArticle + '&article_quantite=' + qteArticle + '&article_prix=' + prixArticle, false, true);
});

//gestion de l'affichage des div du header et des boutons correspondants
$('body').on('click', '.boutonHeader', function (e) {
    console.log(e.target.id.substr(16));
    var name = e.target.id.substr(16);
    var div = document.getElementById('div_' + name);
    var bouton = document.getElementById('bouton_afficher_' + name);

    if (getComputedStyle(div).display === 'none') {
        $('.deroulant').slideUp(200);
        $('.boutonHeader').css({'background-color': '', 'color': ''});
        $(bouton).css({'background-color': '#3399ff', 'color': 'black'});
        if (name === 'panier') {
            $('#nombre_articles_panier').css({'background-color': 'black', 'color': '#3399ff'});
        } else {
            $('#nombre_articles_panier').css({'background-color': '', 'color': ''});
        }
        $(div).slideDown({duration: 200, start: function () {
                $(div).css({'display': 'flex'});
            }, complete: function () {
                initHeader(200);
            }});
    } else {
        $('#nombre_articles_panier').css({'background-color': '', 'color': ''});
        $(div).slideUp({duration: 200, complete: function () {
                initHeader(200);
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
    execute('div_panier', 'index.php', 'action=panier');
});

$('body').on('click', '#bouton_afficher_compte', function () {
    execute('div_commandes', 'index.php', 'action=compte');
});

$('body').on('click', '#bouton_deconnexion', function () {
    execute('body', 'index.php', 'action=deconnecter');
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
    execute('div_une_commande', 'index.php', 'action=commande&commande=' + id_commande);
});

//rend le panier fonctionnel
function initPanier() {
    $('#vider').on('click', function () {
        execute('nombre_articles_panier', 'index.php', 'action=vider', false, true);
    });

    if (document.getElementById('bouton_afficher_connexion') === null) {
        $('#finaliser').on('click', function () {
            execute('retour', 'index.php', 'action=finaliser&total=' + $('#total').html(), true, true);
        });
    } else {
        $('#finaliser').css({'background-color': 'red'});
        $('#finaliser').addClass('nothoverable');
        $('#finaliser').removeClass('hoverable');
        $('#finaliser').html('Connectez-vous<br/>pour commander');
    }
    initHeader(200);
}

function resultatRecherche(recherche, type) {
    execute('section', 'index.php', 'action=recherche&recherche=' + recherche + '&type=' + type);
}