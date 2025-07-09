<?php
include 'config.php';

$post_title = 'Datenschutzerklärung';
$content = <<<HTML
<h2>Datenschutzerklärung</h2>

<p>Diese Website erhebt und speichert keine personenbezogenen Daten, es sei denn, du nutzt das Kommentarformular.</p>

<h3>Kommentare</h3>
<p>Wenn du einen Kommentar schreibst, speichern wir deinen Namen, den Kommentartext und den Zeitpunkt des Kommentars.</p>

<h3>Server-Logs</h3>
<p>Der Serveranbieter kann automatisch Daten wie IP-Adresse, Browsertyp, Uhrzeit usw. in Logdateien speichern. Diese Daten werden nicht ausgewertet oder weitergegeben.</p>

<h3>Cookies</h3>
<p>Diese Seite verwendet keine Cookies.</p>

<h3>Kontakt</h3>
<p>Bei Fragen zum Datenschutz: <a href="mailto:{$contact_email}">{$contact_email}</a></p>
HTML;

$comment = ''; // Keine Kommentare hier

$theme_path = __DIR__ . '/themes/' . $blog_theme . '/theme.php';
if (file_exists($theme_path)) {
    require_once $theme_path;
} else {
    require_once __DIR__ . '/themes/default/theme.php';
}
?>
