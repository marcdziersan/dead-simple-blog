<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>
        <?= isset($post_title) && $post_title !== '' ? htmlspecialchars($post_title) . ' - ' : ''; ?>
        <?= htmlspecialchars($blog_title); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url; ?>themes/<?= $blog_theme; ?>/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= $base_url; ?>"><?= htmlspecialchars($blog_title); ?></a>
  </div>
</nav>

<div class="container mt-4">
    <?= $content; ?>
</div>

<div class="container mt-5 mb-4">
    <?= $comment; ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-2">
        <a href="<?= $base_url ?>imprint.php" class="text-warning text-decoration-none me-3">Imprint</a>
        <a href="<?= $base_url ?>privacy.php" class="text-warning text-decoration-none">Privacy</a>
    </p>
    <small>&copy; <?= date('Y'); ?> <?= htmlspecialchars($blog_title); ?></small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
