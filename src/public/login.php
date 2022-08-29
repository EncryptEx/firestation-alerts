<?php
session_start();

require_once('./../private/utils.php');

use Utils\Alerts;

$alerts = new Alerts();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php');?>
    <div class="container col-xxl-8 px-4 py-5">
        <form action="./auth/login.php" method="POST" class="needs-validation row justify-content-center" novalidate>
            <div class="col-12 col-md-8 col-lg-6">
                <h3>Login</h3>
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="input-group has-validation">
                    <input name="email" type="email" class="form-control" id="inputEmail" required placeholder="fireman@domain.com">
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
                <button class="btn btn-light btn-outline-dark" type="submit">Login</button>
            </div>
        </form>
    </div>

    <?php
    $alerts->retrieveAlert();

    ?>
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