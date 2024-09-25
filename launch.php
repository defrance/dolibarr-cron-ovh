<?php

// URL de la page à récupérer avec comme paramètre :
// URL_DOLIBARR : URL de votre Dolibarr
// SECURITY_KEY : Clé de sécurité généré dans le paramétragbe de l'application de cron
// USERLOGIN : Login dolibarr (pas celui d'ovh) de l'utilisateur qui va lancer le cron
// ID_PLANNED : ID de la tache planifié à lancer (si non renseigné on lance toute les taches actives)
$url = "https://URL_DOLIBARR/htdocs/public/cron/cron_run_jobs_by_url.php?securitykey=SECURITY_KEY&userlogin=USERLOGIN&id=ID_PLANNED";

// Récupérer le contenu de la page
$content = curl_get_contents($url);

// Vérifier si le contenu a été récupéré avec succès
if ($content !== false) {
    // Stockeage du résultat du traitement dans un fichier de log
	// penser à créer le dossier logcron dans le dossier ecm (activer le module GED)
	// on récupère la date du jour pour l'ajouter au nom du fichier
	$date = date('Y-m-d');
    $file = '/home/patasmon/qualif/documents/ecm/logcron/cron_run_jobs.'.$date.'.log';
	// on cumule les logs (append) dans le fichier de log
    file_put_contents($file, $content, FILE_APPEND);
    echo "Page enregistre dans le fichier $file";
} else {
    echo "Impossible de recuperer le contenu de la page.";
}

// Fonction pour récupérer le contenu d'une page qui est appélé par curl
function curl_get_contents($url)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERAGENT,  'Mozilla/5.0 (Windows; U; Windows NT 6.1; fr; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
  
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
