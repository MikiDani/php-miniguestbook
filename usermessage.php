<div class="main p-3">
    <div id="message">
        <form action="index.php#message" method="POST">
            <label class="form-label">New message:</label>
            <textarea type="text" class="form-control mb-3" name="newmessage" rows="3"></textarea>
            <div><h5 class="text-danger"><?php if (isset($_SESSION["error_text"])) { echo $_SESSION["error_text"]; } ?></h5></div>
            <button type="submit" class="btn btn-primary mb-1 mt-2" name="submitinsert">Insert</button>
        </form>
    </div>
</div>