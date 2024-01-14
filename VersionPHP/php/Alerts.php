<?php
function Javascript_alert($message)
{
    echo "<script>alert('$message');</script>";
}

function Bootstrap_alert($state,$strong, $message)
{
    echo ' <div
                class="alert alert-'.$state.'"
                role="alert"
            >
                <strong>' . $strong . '</strong> ' . $message . '
            </div>
            ';
}
function Bs_dismissable_alert($state, $strong, $message){
   echo '<div class="alert alert-'.$state.' alert-dismissible fade show" role="alert">
        <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>'.$strong.'</strong> '.$message.'
        </div>';
}
?>