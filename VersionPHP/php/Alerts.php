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
?>