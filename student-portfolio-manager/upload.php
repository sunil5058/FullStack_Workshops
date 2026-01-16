<?php
require 'header.php';
require 'functions.php';

$msg = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        uploadPortfolioFile($_FILES['portfolio']);
        $msg = "File uploaded successfully";
        $class = "success";
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $class = "error";
    }
}
?>

<h2>Upload Portfolio</h2>
<p class="message <?= $class ?>"><?= $msg ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio">
    <button>Upload</button>
</form>

<?php require 'footer.php'; ?>
