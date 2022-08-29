<?php

namespace Utils;

class Alerts
{
    public function retrieveAlert()
    {
        if (isset($_GET['e']) || isset($_GET['s'])) {
            if (isset($_GET['e'])) {
                if (!is_numeric($_GET['e'])) {
                    return;
                } // skip check if not numeric
                switch ($_GET['e']) {
                    case 1:
                        $alertMsg = "User and password do not match";
                        break;

                    default:
                        $alertMsg = "Something did not work as expected";
                        break;
                }
                
                $className = "danger"; // bs5 red alert
                $icon = "warning"; // bs5 icon alert
                
            } else if (isset($_GET['s'])) {
                if (!is_numeric($_GET['s'])) {
                    return;
                } // skip check if not numeric
                switch ($_GET['s']) {
                    case 1:
                        $alertMsg = "";
                        break;

                    default:
                        $alertMsg = "Something did not work as expected";
                        break;
                }

                $className = "success"; // bs5 green alert
                $icon = "check_circle"; // bs5 icon alert
            }
            
            // common action in both cases
            $alertTemplate = "<div class='alert alert-" . $className . " d-flex align-items-center alert-dismissible fade show' role='alert'>
            <span class='material-symbols-outlined align-middle' style='margin-right:10px'>
                " . $icon . "
            </span>
            <span class='align-middle'>
                " . $alertMsg . "
            </span>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick=\"window.location.href = window.location.href.split('?')[0];\"></button>
            </div>";
            echo $alertTemplate;
        }
    }
}
