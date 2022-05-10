<div class="row d-flex justify-content-center">
    <div class="col-md-6 bg-secondary p-3">
        <h3 class="text-center">Login</h3>
        <form action="index.php?inc=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php if (isset($_SESSION["username"])) { echo $_SESSION["username"]; } ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" class="form-control" name="passwordin" id="passwordin" value="<?php if (isset($_SESSION["passwordin"])) { echo $_SESSION["passwordin"]; } ?>">
            </div>
            <div class="text-center">
            <h5 class="text-danger"><?php if (isset($_SESSION["error_text"])) { echo $_SESSION["error_text"]; } ?></h5>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="submitlogin">Submit</button>
            </div>
        </form>
    </div>
</div>