<?php
function protect($string) {
   $string = trim(strip_tags(addslashes($string)));
   return $string;
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);

        echo "<script>console.log('Message sent to console: ". $output . "');</script>";
    }
}
?>