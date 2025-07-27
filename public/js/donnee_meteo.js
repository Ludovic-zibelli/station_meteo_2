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
{
    var donnee = getXMLHttpRequest();
    donnee.open("GET", "station_direct.json", false);
    donnee.send(null);

    if (donnee.status === 200) {
        var data = JSON.parse(donnee.responseText);

        // Appel de la fonction d'affichage avec l'objet data
        getAffichage(data);
        diffTime(data.heure);
    }
}

function getAffichage(data)
{
    // Gestion de la date et de l'heure selon le format reçu
    let date = data.date;
    let heure = data.heure;

    // Si le backend fournit encore un objet dateheure
    if (!date && data.dateheure && data.dateheure.date) {
        // Exemple : "2025-06-01 15:33:33.264000"
        let dateTimeStr = data.dateheure.date.split('.')[0]; // retire les microsecondes
        let parts = dateTimeStr.split(' ');
        date = parts[0];
        heure = parts[1];
    }
    console.log("Date : " + date);
    console.log("Heure : " + heure);
    console.log("Données : ", data);
    // Modification du contenu HTML de la liste : pour affichage des données météo
    document.getElementById("temp_dht11").innerHTML = data.temp2;
    document.getElementById("temp_bmp180").innerHTML = data.temp1;
    document.getElementById("capt_lumi").innerHTML = data.lumiere;
    document.getElementById("anemo").innerHTML = data.anemo;
    document.getElementById("tens_capt").innerHTML = data.tension;
    document.getElementById("humiditer").innerHTML = data.lumiere;
    document.getElementById("pression").innerHTML = data.pression_ajt;
    document.getElementById("pluvio").innerHTML = data.pluvio;
    document.getElementById("girou").innerHTML = data.girou;
    document.getElementById("heure_releve").innerHTML = heure;
    document.getElementById("date_releve").innerHTML = date;
    var a = data.lumiere * 100;
    var b = a / 5;
    document.getElementById("taux_soleil").innerHTML = b;
    document.getElementById("taux").innerHTML = '<div class="progress-bar bg-info" role="progressbar" style="width: ' + b + '%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">' + b + '%</div>';
    document.getElementById("bit_vie").innerHTML = data.bitvie;
}

// Fonction pour contrôler si la station est en ligne (heure au format "HH:MM:SS")
function diffTime(heure)
{
    var time = heure.split(':');
    var d = new Date();
    var h = d.getHours();
    var m = d.getMinutes();
    var t1 = h * 60 + m;
    var t2 = time[0];
    var t3 = time[1];
    var t4 = t2 * 60;
    var t5 = parseInt(t4) + parseInt(t3);
    var dif = t1 - t5;
    if (dif <= 5) {
        document.getElementById("online").innerHTML = '<div class="alert alert-success" role="alert">La station météo est En ligne</div>';
    } else {
        document.getElementById("online").innerHTML = '<div class="alert alert-danger" role="alert">La station météo est Hors ligne</div>';
    }
}
    //Mise a jours des données toute les 30 secondes
    setInterval(getDonnee, 30000);
