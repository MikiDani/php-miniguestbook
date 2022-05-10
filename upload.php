<div class="upload p-3">
    <h3 class="text-center">Upload</h3>
    <form method="post" href="index.php" enctype="multipart/form-data">
        <h5>Only .txt and .csv formats can be uploaded.</h5>
        <input type="file" name="file">
        <div class="text-center">
            <h5 class="text-danger m-2">
                <?php if (isset($_SESSION["uploadmessage"])) { echo $_SESSION["uploadmessage"]; } ?>
            </h5>
        </div>
        <button type="submit" class="btn btn-primary" name="upload">Feltöltés</button>
    </form>
</div>