<?php
include 'config.php';
include 'Parsedown.php';

$content = '';
$parsedown = new Parsedown();

if (!empty($_GET['post'])) {
    $post_param = $_GET['post'];
    $post_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $post_param);
    $file_path = __DIR__ . '/content/' . $post_id . '.txt';

    if (file_exists($file_path)) {
        $file = fopen($file_path, 'r');
        $post_title = trim(fgets($file), '#');
        fclose($file);

        // Back-Button hinzufügen
        $content = '<p><a href="' . $base_url . '" class="back-button">&larr; Back to overview</a></p>';
        $content .= $parsedown->text(file_get_contents($file_path));
    } else {
        $post_title = 'Not Found';
        $content = '<h2>Not Found</h2><p><a href="' . $base_url . '">Back to home</a></p>';
    }

    // Kommentare laden
    $comments_file = __DIR__ . '/comments/' . $post_id . '.json';
    $comments = file_exists($comments_file) ? json_decode(file_get_contents($comments_file), true) : [];

    // Kommentare in Parent/Child aufteilen
    $main_comments = [];
    $replies = [];

    foreach ($comments as $comment) {
        if (empty($comment['parent'])) {
            $main_comments[] = $comment;
        } else {
            $replies[$comment['parent']][] = $comment;
        }
    }

    function render_comment($comment, $replies) {
        $html = '<div class="comment">';
        $html .= '<strong>' . htmlspecialchars($comment['name']) . ':</strong><br>';
        $html .= '<p>' . nl2br(htmlspecialchars($comment['message'])) . '</p>';

        // Antwortformular
        $html .= <<<HTML
<p><a href="#" class="toggle-reply" data-target="reply-form-{$comment['id']}">Reply</a></p>
<div class="reply-form-container" id="reply-form-{$comment['id']}" style="display:none;">
<form method="post" action="save_comment.php" class="reply-form">
    <input type="hidden" name="post_id" value="{$GLOBALS['post_id']}" />
    <input type="hidden" name="parent" value="{$comment['id']}" />
    <p><input type="text" name="name" placeholder="Your name" required></p>
    <p><textarea name="message" placeholder="Reply to this comment" required></textarea></p>
    <p><button type="submit">Reply</button></p>
</form>
</div>
HTML;

        // Antworten rendern
        if (!empty($replies[$comment['id']])) {
            foreach ($replies[$comment['id']] as $reply) {
                $html .= '<div class="reply">' . render_comment($reply, $replies) . '</div>';
            }
        }

        $html .= '</div>';
        return $html;
    }

    $comment_html = '<section class="comments"><h3>Comments</h3>';
    foreach ($main_comments as $c) {
        $comment_html .= render_comment($c, $replies);
    }

    // Haupt-Kommentarformular
    $comment_html .= <<<HTML
<h4>Leave a comment</h4>
<form method="post" action="save_comment.php">
    <input type="hidden" name="post_id" value="{$post_id}" />
    <input type="hidden" name="parent" value="" />
    <p><input type="text" name="name" placeholder="Your name" required></p>
    <p><textarea name="message" placeholder="Your comment" required></textarea></p>
    <p><button type="submit">Send</button></p>
</form>
</section>
HTML;

    $comment = $blog_comment
    ? $comment_html
    : '<p class="no-comments">Commenting is currently disabled.</p>';

} else {
    $post_title = 'All Posts';
    $comment = '';
    $directory = new DirectoryIterator(__DIR__ . '/content/');
    foreach ($directory as $file) {
        if ($file->isFile() && $file->getExtension() === 'txt') {
            $filename_no_ext = $file->getBasename('.txt');
            $file_path = $file->getPathname();
            $handle = fopen($file_path, 'r');
            $title = trim(fgets($handle), '#');
            fclose($handle);

            $content .= '<h2 class="title"><a href="' . $base_url . '?post=' . $filename_no_ext . '">' . $filename_no_ext . ' - ' . htmlspecialchars($title) . '</a></h2>';
        }
    }
}

// Theme laden
$theme = __DIR__ . '/themes/' . $blog_theme . '/theme.php';
if (file_exists($theme)) {
    require_once $theme;
} else {
    require __DIR__ . '/themes/default/theme.php';
}
?>
