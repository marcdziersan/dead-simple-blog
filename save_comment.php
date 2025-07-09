<?php
$comments_dir = __DIR__ . '/comments/';
if (!is_dir($comments_dir)) {
    mkdir($comments_dir, 0755, true);
}

$post_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['post_id'] ?? '');
$name = trim($_POST['name'] ?? '');
$message = trim($_POST['message'] ?? '');
$parent = isset($_POST['parent']) && $_POST['parent'] !== '' ? (int)$_POST['parent'] : null;

if ($post_id && $name && $message) {
    $file = $comments_dir . $post_id . '.json';
    $comments = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    $new_id = count($comments) > 0 ? max(array_column($comments, 'id')) + 1 : 1;

    $comment = [
        'id' => $new_id,
        'name' => htmlspecialchars($name, ENT_QUOTES),
        'message' => htmlspecialchars($message, ENT_QUOTES),
        'time' => time(),
        'parent' => $parent
    ];

    $comments[] = $comment;
    file_put_contents($file, json_encode($comments, JSON_PRETTY_PRINT));

    header("Location: index.php?post=" . urlencode($post_id));
    exit;
}

echo "Invalid input.";
