//var quantites = document.querySelectorAll(".quantite");
var displayCart = document.getElementById('dispCart');
var dispConnect = document.getElementById('dispConnect');
var dispRegister = document.getElementById('dispRegister');
var dispSearch = document.getElementById('bouton_recherche');
//var connecter = document.getElementById('seConnecter');
var deconnecter = document.getElementById('deconnect');
//var inscrire = document.getElementById('sInscrire');


//décaler verticalement le header pour qu'il ne cache pas la div du catalogue
var height = document.getElementById("fixedHeader").offsetHeight;
document.getElementById("mainWrapper").style.marginTop = height + 'px';

window.onload = init;

//donne aux boutons "ajouter" la fonction d'ajouter des produits au panier via AJAX
function initBoutonsAcheter() {
    var boutons = document.querySelectorAll('.ajouter');
    for (var i = 0, max = boutons.length; i < max; i++) {
        boutons[i].addEventListener('click', function (e) {
            var idArticle = e.target.id.substr(7);
            var selectArticle = document.getElementById('qte' + idArticle);
            var qteArticle = selectArticle.options[selectArticle.selectedIndex].value;
            var prixArticle = document.getElementById('prix' + idArticle).innerHTML;

            execute('test', 'index.php', "action=ajout&article_id=" + idArticle + "&article_quantite=" + qteArticle + "&article_prix=" + prixArticle, false, true);
        }, false);
    }
}

//permet d'afficher le panier et de cacher les autres panneaux
displayCart.addEventListener('click', function () {
    var connexion = document.getElementById('divConnexion');
    var panier = document.getElementById('panier');
    var inscription = document.getElementById('divInscription');
    var recherche = document.getElementById('div_recherche');

    if (getComputedStyle(panier).display === "none") {
        execute('panier', 'index.php', 'action=panier');
        montrerElement(panier, displayCart);
        cacherElement(connexion, dispConnect);
        cacherElement(inscription, dispRegister);
        cacherElement(recherche, dispSearch);
    } else {
        cacherElement(panier, displayCart);
    }
}, false);

//permet d'afficher le panneau de recherche et de cacher les autres panneaux
dispSearch.addEventListener('click', function () {
    var connexion = document.getElementById('divConnexion');
    var panier = document.getElementById('panier');
    var inscription = document.getElementById('divInscription');
    var recherche = document.getElementById('div_recherche');

    if (getComputedStyle(recherche).display === "none") {
        cacherElement(panier, displayCart);
        cacherElement(connexion, dispConnect);
        cacherElement(inscription, dispRegister);
        montrerElement(recherche, dispSearch);

        var valeur_recherche = "";
        var valeur_type = "ArmeArmureAccessoiresConsommables";

        document.getElementById('champ_recherche').addEventListener('input', function (e) {
            valeur_recherche = e.target.value;
            resultatRecherche(valeur_recherche, valeur_type);
        }, false);

        radio_categories = document.querySelectorAll('.radio_categorie');
        for (var i = 0, max = radio_categories.length; i < max; i++) {
            radio_categories[i].addEventListener('click', function (e) {
                console.log(e.target.value);
                valeur_type = e.target.value;
                resultatRecherche(valeur_recherche, valeur_type);
            }, false);
        }

    } else {
        cacherElement(recherche, dispSearch);
    }
}, false);


$('h1').on('click', '#dispConnect', function () {
    var connexion = document.getElementById('divConnexion');
    var panier = document.getElementById('panier');
    var inscription = document.getElementById('divInscription');
    var recherche = document.getElementById('div_recherche');

    if (getComputedStyle(connexion).display === "none") {
        montrerElement(connexion, dispConnect);
        cacherElement(panier, displayCart);
        cacherElement(inscription, dispRegister);
        cacherElement(recherche, dispSearch);
    } else {
        cacherElement(connexion, dispConnect);
    }
});

//permet d'afficher le panneau de connexion et de cacher les autres panneaux
/*if (dispConnect !== null) {
    dispConnect.addEventListener('click', function () {
        var connexion = document.getElementById('divConnexion');
        var panier = document.getElementById('panier');
        var inscription = document.getElementById('divInscription');
        var recherche = document.getElementById('div_recherche');

        if (getComputedStyle(connexion).display === "none") {
            montrerElement(connexion, dispConnect);
            cacherElement(panier, displayCart);
            cacherElement(inscription, dispRegister);
            cacherElement(recherche, dispSearch);
        } else {
            cacherElement(connexion, dispConnect);
        }
    }, false);
}*/

//permet d'afficher le panneau d'inscription et de cacher les autres panneaux
if (dispRegister !== null) {
    dispRegister.addEventListener('click', function () {
        var connexion = document.getElementById('divConnexion');
        var panier = document.getElementById('panier');
        var inscription = document.getElementById('divInscription');
        var recherche = document.getElementById('div_recherche');

        if (getComputedStyle(inscription).display === "none") {
            montrerElement(inscription, dispRegister);
            cacherElement(panier, displayCart);
            cacherElement(connexion, dispConnect);
            cacherElement(recherche, dispSearch);
        } else {
            cacherElement(inscription, dispRegister);
        }
    }, false);
}

//rend le panier fonctionnel
function initPanier() {
    var vider = document.getElementById('vider');
    var finaliser = document.getElementById('finaliser');
    var total = document.getElementById('total');

    if (vider !== null) {
        vider.addEventListener('click', function () {
            execute('test', 'index.php', 'action=vider', false, true);
        }, false);
    }

    if (document.getElementById('dispConnect') === null) {
        if (finaliser !== null) {
            finaliser.addEventListener('click', function () {
                execute('test', 'index.php', 'action=finaliser&total=' + total.innerHTML, false, true);
            }, false);
        }
    } else {
        if (finaliser !== null) {
            finaliser.style.backgroundColor = "red";
            finaliser.classList.remove('hoverable');
            finaliser.classList.add('nothoverable');
            finaliser.innerHTML = "Connectez-vous<br/>pour commander";
        }
    }
}

function resultatRecherche(recherche, type) {
    execute('section', 'index.php', 'action=recherche&recherche=' + recherche + '&type=' + type, false, false, true);
}


//déconnexion
/*if (deconnecter !== null) {
 deconnecter.addEventListener('click', function () {
 execute('body', 'index.php', 'action=deconnecter');
 }, false);
 }*/

$('h1').on('click', '#deconnect', function () {
    execute('body', 'index.php', 'action=deconnecter');
});

/*
 //connexion
 if (connecter !== null) {
 connecter.addEventListener('click', function () {
 var login = document.getElementById('login_log');
 var pass = document.getElementById('pass_log');
 execute('retour', 'index.php', 'action=connecter&login=' + login.value + '&pass=' + pass.value, true);
 }, false);
 }
 
 //inscription
 if (inscrire !== null) {
 inscrire.addEventListener('click', function () {
 var login = document.getElementById('login_reg');
 var pass = document.getElementById('pass_reg');
 execute('retour', 'index.php', 'action=inscrire&login=' + login.value + '&pass=' + pass.value, true);
 }, false);
 }
 */

//désactiver les produits en rupture de stock
function initRupture() {
    var articles = document.querySelectorAll(".article");
    for (var i = 0, max = articles.length; i < max; i++) {
        var idArticle = articles[i].id.substr(7);
        if (document.querySelector('#stock' + idArticle).innerHTML === '0') {
            articles[i].style.backgroundColor = "lightgrey";
            articles[i].querySelector('.ajouter').disabled = "true";
            articles[i].querySelector('.ajouter').value = "Rupture de stock";
            articles[i].querySelector('.ajouter').classList.add('rupture');
            articles[i].querySelector('.ajouter').classList.remove('ajouter');
            articles[i].querySelector('.quantite').style.display = "none";
        }
    }
}



function montrerElement(div, bouton) {
    div.style.display = "flex";
    bouton.style.backgroundColor = "darkorange";
    bouton.style.color = "black";
}

function cacherElement(div, bouton) {
    if (div !== null) {
        div.style.display = "none";
    }
    if (bouton !== null) {
        bouton.style.backgroundColor = "";
        bouton.style.color = "";
    }
}

function init() {
    initBoutonsAcheter();
    initRupture();
}