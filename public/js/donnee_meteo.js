function getXMLHttpRequest() { /* Instance XMLHTttpRequest */
    var xmlhttp = null;
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch(e) {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        else {
            xmlhttp = new XMLHttpRequest();
        }
    }
    else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest.");
        return null;
    }
    return xmlhttp;
}

//Affichage decompte pour raffraichissement
var compteurElt = document.getElementById("compteur");
function compteur()
    {
        // Conversion en nombre du texte du compteur
        var compteur = Number(compteurElt.textContent);
        if (compteur > 1) {
            compteurElt.textContent = compteur - 1;
        } else {
            // Annule l'exécution répétée
            //clearInterval(intervalId);
            document.getElementById("compteur").innerHTML = 30;

        }
    }
// Appelle la fonction diminuerCompteur toutes les secondes (1000 millisecondes)
setInterval(compteur, 1000);

//Gestion des donnée venu de la station
//Chargement des donnée au chargement de la page
getDonnee();
//Function qui perment d'extraire les données du fichier texte
function getDonnee()
    { /* Recupère liens dans fichier .txt*/

        var url = 'http://meteospit.fr/station_direct.txt';
        var donnee = getXMLHttpRequest(); /* Instance XMLHttpRequest*/
        donnee.open("GET", "station_direct.txt", false);
        //donnee.overrideMimeType('text/xml');

        donnee.send(null);
        var ligne = donnee.responseText.split(/\n/g); /* Stock tout le fichier dans la variable (tableau)*/

        //appel des function pour generation de l'affichage
        getAffichage(ligne);
        diffTime(ligne[1]);
    }

function getAffichage(ligne)
    {
        // Modification du contenu HTML de la liste : pour affichage des données météo
        document.getElementById("temp_dht11").innerHTML = ligne[2];
        document.getElementById("temp_bmp180").innerHTML = ligne[4];
        document.getElementById("capt_lumi").innerHTML = ligne[6];
        document.getElementById("anemo").innerHTML = ligne[8];
        document.getElementById("tens_capt").innerHTML = ligne[10];
        document.getElementById("humiditer").innerHTML = ligne[3];
        document.getElementById("pression").innerHTML = ligne[5];
        document.getElementById("pluvio").innerHTML = ligne[7];
        document.getElementById("girou").innerHTML = ligne[9];
        document.getElementById("heure_releve").innerHTML = ligne[1];
        document.getElementById("date_releve").innerHTML = ligne[0];
        var a = ligne[10] * 100;
        var b = a / 5 ;
        document.getElementById("taux_soleil").innerHTML = b;
        document.getElementById("taux").innerHTML = '<div class="progress-bar bg-info" role="progressbar" style="width: ' + b + '%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">' + b + '%</div>';

    }

//Function pour controler si la station et en ligne
function diffTime(ligne)
    {
        var time = ligne.split(':');
        var d = new Date();
        var h = d.getHours();
        var m = d.getUTCMinutes();
        var t1 = h*60 + m;
        var t2 = time[0];
        var t3 = time[1];
        var t4 = t2*60;
        var t5 =  parseInt(t4) + parseInt(t3);
        var dif = t1 - t5;
        if(dif <= 5)
            {
                document.getElementById("online").innerHTML = '<div class="alert alert-success" role="alert">La station météo et En ligne</div>'
            }
            else
            {
                document.getElementById("online").innerHTML = '<div class="alert alert-danger" role="alert">La station météo et Hors ligne</div>'
            }


    }
    //Mise a jours des données toute les 30 secondes
    setInterval(getDonnee, 30000);
