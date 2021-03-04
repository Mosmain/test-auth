<?php
function typeFile ($a) {
    // $file_types = array('png', 'jpg', 'jpeg');
    // $pathinfo = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
    if ($a > 5) {
        return 'a > 5';
    } else {
        return 'a < 5';
    }

}