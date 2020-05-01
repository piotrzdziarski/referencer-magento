<?php
file_put_contents('postback-data.txt', json_encode($_POST));

// postback uses curl return transfer so we need to return something
echo json_encode([
    'status' => 'successful'
]);
