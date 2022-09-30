<?php
session_start();
include("./database.php");

if (isset($_POST["eMail"]) && isset($_POST["passwordd"])) {
    if (!isset($_POST["eMail"]) || trim($_POST["eMail"]) == "" || !isset($_POST["passwordd"]) || trim($_POST["passwordd"]) == "") {
        $message = "All areas must be filled!";
        echo "<script type='text/javascript'>
                alert('$message');
            </script>";
    }
    $q = $db->prepare("SELECT * FROM users WHERE email = '" . $_POST["eMail"] . "'");
    $q = $db->prepare("SELECT * FROM users WHERE password = '" . $_POST["passwordd"] . "'");
    $q->execute(array());
    $results = $q->fetchAll();

    foreach ($results as $result) {
        if (isset($result[3]) && isset($result[4])) {
            $_SESSION["username"] = $_POST["eMail"];
            $_SESSION["logged"] = TRUE;
            header("Location: ./admin.php");
            exit();
        }
    }
    if (!isset($result[3]) && !isset($result[4])) {
        echo '<script>
                alert("Email or password is not correct!");
                window.location.href="./login.php";
            </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form action="#" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="eMail" autocomplete="off" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="passwordd" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-grid">
                                            <input type="submit" name="login" value="Login" style="padding: 0.4rem">
                                            <!-- <a class="btn btn-primary" type="submit">Login</a> -->
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="./register.php" style="text-decoration: none; color: #0D6EFD;">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>