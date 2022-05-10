<div class="row d-flex justify-content-center">
    <div class="col-md-6 bg-secondary p-3 bg-success">
        <h3 class="text-center">Registration</h3>
        <form method="post" href="index.php">
            <div class="mb-3">
                <label class="form-label">New Username:</label>
                <input type="text" class="form-control" name="newusername" id="newusername" value="<?php if (isset($_SESSION["newusername"])) { echo $_SESSION["newusername"]; } ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" class="form-control" name="regpasswordin" id="regpasswordin" value="<?php if (isset($_SESSION["regpasswordin"])) { echo $_SESSION["regpasswordin"]; } ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Repeat Password:</label>
                <input type="password" class="form-control" name="repeatregpasswordin" id="repeatregpasswordin">
            </div>
            <div class="text-center">
                <h5 class="text-danger"><?php if (isset($_SESSION["registrationmessage"])) { echo $_SESSION["registrationmessage"]; } ?></h5>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="registrationsubmit" id="registrationsubmit">Add User</button>
            </div>
        </form>
    </div>
</div>