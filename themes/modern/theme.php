<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?= isset($post_title) && $post_title !== '' ? htmlspecialchars($post_title) . ' - ' : ''; ?>
        <?= htmlspecialchars($blog_title); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base_url; ?>themes/<?= $blog_theme; ?>/css/style.css">
</head>
<body>
    <header>
        <h1 class="blog-title">
            <a href="<?= $base_url; ?>"><?= htmlspecialchars($blog_title); ?></a>
        </h1>
        <hr />
    </header>

    <main>
        <?= $content; ?>
    </main>

    <footer>
        <hr />
        <?= $comment; ?>
		    <p>
        <a href="<?= $base_url ?>imprint.php">Imprint</a> | 
        <a href="<?= $base_url ?>privacy.php">Privacy</a>
    </p>
    </footer>
    <script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.toggle-reply').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = btn.getAttribute('data-target');
      const form = document.getElementById(targetId);
      if (form.style.display === 'none') {
        form.style.display = 'block';
      } else {
        form.style.display = 'none';
      }
    });
  });
});
</script>

</body>
</html>
