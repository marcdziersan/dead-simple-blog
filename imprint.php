<?php
include 'config.php';

$post_title = 'Impressum';
$content = <<<HTML
<h2>Impressum</h2>
<p>Angaben gemäß § 5 TMG:</p>
<p><strong>{$contact_name}</strong><br>
{$contact_street}<br>
{$contact_city}<br>
{$contact_country}</p>

<p><strong>Kontakt:</strong><br>
Telefon: {$contact_number}<br>
E-Mail: <a href="mailto:{$contact_email}">{$contact_email}</a></p>

<p><strong>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:</strong><br>
{$contact_name}, Anschrift wie oben</p>

<p>Haftung für Inhalte: Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links.</p>
HTML;

$comment = ''; // Keine Kommentare hier

$theme_path = __DIR__ . '/themes/' . $blog_theme . '/theme.php';
if (file_exists($theme_path)) {
    require_once $theme_path;
} else {
    require_once __DIR__ . '/themes/default/theme.php';
}
?>
