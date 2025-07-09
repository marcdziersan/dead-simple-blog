<?php
session_start();
include 'config.php';

$auth = $_SESSION['admin_logged_in'] ?? false;
$action = $_GET['action'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$auth) {
    if (hash('sha256', $_POST['password'] ?? '') === $admin_password_hash) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $message = "Wrong password.";
    }
}

if ($_GET['logout'] ?? false) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

function list_posts() {
    $output = "<h3>📝 Posts</h3><ul>";
    foreach (glob("content/*.txt") as $file) {
        $name = basename($file, '.txt');
        $title = fgets(fopen($file, 'r')) ?: 'Untitled';
        $output .= "<li><a href='?edit=$name'>$name - " . htmlspecialchars(trim($title, '# ')) . "</a> 
        [<a href='?delete=$name' onclick='return confirm(\"Delete $name?\")'>delete</a>]</li>";
    }
    $output .= "</ul><a href='?edit=new'>+ New Post</a>";
    return $output;
}

function list_comments() {
    $output = "<h3>💬 Comments</h3>";
    foreach (glob("comments/*.json") as $file) {
        $post_id = basename($file, '.json');
        $comments = json_decode(file_get_contents($file), true);
        $output .= "<details><summary>$post_id (" . count($comments) . ")</summary><ul>";
        foreach ($comments as $index => $c) {
            $text = htmlspecialchars($c['message']);
            $name = htmlspecialchars($c['name']);
            $output .= "<li><strong>$name:</strong> " . nl2br($text) . " 
            [<a href='?delcomment=$post_id&index=$index' onclick='return confirm(\"Delete comment?\")'>delete</a>]</li>";
        }
        $output .= "</ul></details>";
    }
    return $output;
}

if ($auth) {
    if (isset($_GET['delete'])) {
        $file = "content/" . basename($_GET['delete']) . ".txt";
        if (file_exists($file)) {
            unlink($file);
            $message = "Post deleted.";
        }
    }

    if (isset($_GET['delcomment']) && isset($_GET['index'])) {
        $file = "comments/" . basename($_GET['delcomment']) . ".json";
        $comments = json_decode(file_get_contents($file), true);
        array_splice($comments, (int)$_GET['index'], 1);
        file_put_contents($file, json_encode($comments, JSON_PRETTY_PRINT));
        $message = "Comment deleted.";
    }

    if (isset($_POST['savepost'])) {
        $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['slug']);
        $body = trim($_POST['body']);
        if ($slug && $body) {
            file_put_contents("content/$slug.txt", $body);
            $message = "Post saved.";
        } else {
            $message = "Missing slug or content.";
        }
    }

    // Bild-Upload
    $upload_dir = __DIR__ . '/media/';
    $upload_url = 'media/';
    $upload_feedback = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 2 * 1024 * 1024;

        if ($_FILES['image']['error'] === 0) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $file_type = mime_content_type($file_tmp);
            $file_size = $_FILES['image']['size'];

            if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
                $clean_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file_name);
                $target_path = $upload_dir . $clean_name;

                if (move_uploaded_file($file_tmp, $target_path)) {
                    $upload_feedback = "✅ Upload successful: <code>{$upload_url}{$clean_name}</code>";
                } else {
                    $upload_feedback = "❌ Failed to move uploaded file.";
                }
            } else {
                $upload_feedback = "❌ Invalid file type or file too large.";
            }
        } else {
            $upload_feedback = "❌ Upload error.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 2rem; max-width: 800px; margin: auto; }
        h1 { font-size: 1.8rem; }
        input, textarea { width: 100%; padding: 0.5rem; margin-top: 0.5rem; }
        textarea { height: 200px; }
        form { margin-bottom: 2rem; background: white; padding: 1rem; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        ul { padding-left: 1.2rem; }
        .message { background: #def; padding: 1rem; border-left: 4px solid #39f; margin-bottom: 1rem; }
        code { background: #eee; padding: 2px 4px; }
        img { max-width: 200px; height: auto; display: block; margin-top: 0.5rem; }
    </style>
</head>
<body>
<h1>🔐 Admin Panel</h1>
<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<?php if (!$auth): ?>
    <form method="post">
        <label>Password:<br><input type="password" name="password" required></label>
        <p><button type="submit">Login</button></p>
    </form>
<?php else: ?>
    <p><a href="?logout=1">Logout</a></p>

    <?php
    if (isset($_GET['edit'])):
        $edit = basename($_GET['edit']);
        $file = "content/$edit.txt";
        $body = file_exists($file) ? file_get_contents($file) : "# Title\n\nContent...";
    ?>
    <form method="post">
        <h3><?= $edit === 'new' ? '🆕 Create Post' : '✏️ Edit Post' ?></h3>
        <label>Slug (no spaces):<br><input name="slug" required value="<?= $edit === 'new' ? '' : $edit ?>"></label><br>
        <label>Markdown content:<br><textarea name="body"><?= htmlspecialchars($body) ?></textarea></label><br>
        <button type="submit" name="savepost">Save Post</button>
    </form>
    <p><a href="admin.php">← Back to dashboard</a></p>
    <?php else: ?>
        <?= list_posts(); ?>
        <hr>
        <?= list_comments(); ?>
        <hr>
        <h3>🖼️ Upload Image</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image" required>
            <button type="submit">Upload</button>
        </form>
        <?php if (!empty($upload_feedback)) echo "<div class='message'>$upload_feedback</div>"; ?>

        <h4>📂 Uploaded Images</h4>
        <?php
        foreach (glob("media/*.*") as $file) {
            $url = $upload_url . basename($file);
            $size_kb = round(filesize($file) / 1024, 1);
            $markdown = "![]($url)";
            $html = htmlspecialchars("<img src='$url' width='400'>");
            echo "<div style='margin-bottom:1rem; padding:0.5rem; background:#fff; border:1px solid #ccc;'>";
            echo "<strong>" . basename($file) . "</strong> ({$size_kb} KB)<br>";
            echo "🔗 URL: <code>$url</code><br>";
            echo "🧃 Markdown: <code>$markdown</code><br>";
            echo "📄 HTML: <code>$html</code><br>";
            echo "<img src='$url' alt=''>";
            echo "</div>";
        }
        ?>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
