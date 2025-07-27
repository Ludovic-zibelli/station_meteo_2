<?php
// Durée de cache (secondes)
$ttl = 86400; // 1 jour

// Récupération des coordonnées de la tuile
$x = intval($_GET['x'] ?? 0);
$y = intval($_GET['y'] ?? 0);
$z = intval($_GET['z'] ?? 0);
$r = strip_tags($_GET['r'] ?? 'osma');

// Sélection du type de rendu
switch ($r) {
    case 'mapnik':
        $r = 'mapnik';
        break;
    case 'osma':
    default:
        $r = 'osma';
        break;
}

// Construction du chemin absolu vers la tuile
$publicPath = realpath(__DIR__ . '/../public');
$tilesDir = "$publicPath/tiles/$r";
$file = "$tilesDir/{$z}_{$x}_{$y}.png";

// Création du dossier si nécessaire
if (!is_dir($tilesDir)) {
    mkdir($tilesDir, 0777, true);
}

// Si le fichier n’existe pas ou est trop vieux
if (!is_file($file) || filemtime($file) < time() - (86400 * 30)) {
    // Choix du serveur selon le rendu
    switch ($r) {
        case 'mapnik':
            $servers = ['a.tile.openstreetmap.org', 'b.tile.openstreetmap.org', 'c.tile.openstreetmap.org'];
            $url = 'http://' . $servers[array_rand($servers)] . "/$z/$x/$y.png";
            break;

        case 'osma':
        default:
            $servers = ['a.tah.openstreetmap.org', 'b.tah.openstreetmap.org', 'c.tah.openstreetmap.org'];
            $url = 'http://' . $servers[array_rand($servers)] . "/Tiles/tile.php/$z/$x/$y.png";
            break;
    }

    // Téléchargement de la tuile
    $ch = curl_init($url);
    $fp = fopen($file, "w");

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    // Si erreur lors du téléchargement ou fichier vide => image de secours
    if ($httpCode !== 200 || filesize($file) === 0) {
        $fallback = "$publicPath/images/tuile_vide.png";
        if (is_file($fallback)) {
            copy($fallback, $file);
        }
    }
}

// En-têtes HTTP pour le cache
$exp_gmt = gmdate("D, d M Y H:i:s", time() + $ttl) . " GMT";
$mod_gmt = gmdate("D, d M Y H:i:s", filemtime($file)) . " GMT";

header("Expires: $exp_gmt");
header("Last-Modified: $mod_gmt");
header("Cache-Control: public, max-age=$ttl");
header("Content-Type: image/png");

// Affichage de la tuile
readfile($file);
exit;
