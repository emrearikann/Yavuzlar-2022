<?php
try {
    session_start();
    include("./database.php");
    $control = isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["eMail"]) && isset($_POST["password"]) && isset($_POST["passwordAgain"]);
    $empty = !isset($_POST["firstName"]) || trim($_POST["firstName"]) == "" || !isset($_POST["lastName"]) || trim($_POST["lastName"]) == "" || !isset($_POST["eMail"]) || trim($_POST["eMail"]) == "" || !isset($_POST["password"]) || trim($_POST["password"]) == "";

    if ($control) {

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["eMail"];
        $password = $_POST["password"];
        $passwordAgain = $_POST["passwordAgain"];

        if (trim($firstName == "" || $lastName == "" || $email == "" || $password == "" || $passwordAgain == "")) {
            $message = "All areas must be filled!";
            echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href='./register.php';
                </script>";
        } else {
            if ($password == $passwordAgain) {
                $email = $_POST["eMail"];

                $m = $db->prepare("SELECT * FROM users WHERE email=?");
                $m->execute([$email]);
                $mail = $m->fetch();

                if ($mail) {
                    $message = "Mail adress is already taken!";
                    echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.href='./register.php';
                        </script>";
                } else {
                    $q = $db->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES ('$firstName', '$lastName', '$email', '$password');");
                    $q->execute(array());
                    $q->fetchAll();
                }
            } else {
                $message = "Passwords must be same!";
                echo "<script type='text/javascript'>
                        alert('$message');
                        window.location.href='./register.php';
                    </script>";
            }
            $message = "Your account has been created";
            echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href='./login.php';
                </script>";
        }
    }
} catch (PDOException $e) {
    echo "Exception: " . $e;
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
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="#" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="firstName" class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" require />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="lastName" class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" require />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input name="eMail" class="form-control" id="inputEmail" type="email" placeholder="name@example.com" require />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="password" class="form-control" id="inputPassword" type="password" placeholder="Create a password" require />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="passwordAgain" class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" require />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" name="createAccount" value="Create Account" style="padding: 0.4rem">
                                                <!-- <a class="btn btn-primary btn-block" href="#">Create Account</a> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="./login.php" style="text-decoration: none; color: #0D6EFD;">Have an account? Go to login</a></div>
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