<?php 

namespace Utils;

class Alerts {
    public function retrieveAlert(){
        if(isset($_GET['e'])){
            if(!is_numeric($_GET['e'])) {return;} // skip check if not numeric
            switch ($_GET['e']) {
                case 1:
                    $error = "User and password do not match";
                    break;

                default:
                    $error = "Something did not work as expected";
                    break;
                }
                $errorTemplate = "<div class='alert alert-danger d-flex align-items-center alert-dismissible fade show' role='alert'>
                <span class='material-symbols-outlined align-middle' style='margin-right:10px'>
                    warning
                </span>
                <span class='align-middle'>
                    " . $error . "
                </span>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='window.location.href = window.location.href.split('?')[0];'></button>
                </div>";
                echo $errorTemplate;
            
        } else if (isset($_GET['s'])){

        }
    }
}
