<?php
session_start();

require_once('./../private/utils.php');

use Utils\Alerts;
use Utils\Auth;

$alerts = new Alerts();
$auth = new Auth;
$auth->checkUserNotLogged($_SESSION['userId']);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php');?>
    <div class="container col-xxl-8 px-4 py-5">
        <form action="./auth/register.php" method="POST" class="needs-validation row justify-content-center" novalidate>
            <div class="col-12 col-md-8 col-lg-6">
                <h3>Sign up</h3>

    <?php
    $alerts->retrieveAlert();

    ?>
                <label for="realName" class="col-sm-2 col-form-label">Name</label>
                <div class="input-group has-validation">
                    <input name="name" type="text" class="form-control" id="realName" required placeholder="John">
                    <div class="invalid-feedback">
                        Please introduce an email.
                    </div>
                </div>
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="input-group has-validation">
                    <input name="email" type="email" class="form-control" id="staticEmail" required placeholder="john@example.com">
                    <div class="invalid-feedback">
                        Please introduce an email.
                    </div>
                </div>
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="input-group has-validation">
                    <input name="password" type="password" class="form-control" id="inputPassword" required placeholder="*******">
                    <div class="invalid-feedback">
                        Please introduce a password.
                    </div>
                </div>
                <br>
                <button class="btn btn-light btn-outline-dark" type="submit">Register</button>
            </div>
        </form>
    </div>
    </div>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>