<?php
require_once 'verificaLogin.php';

if (!checkAuth()) {
    exit;
}

header('Content-Type: application/json');

movieDB();

function movieDB() {
$curl = curl_init();
$qTitle= urldecode($_GET["q"]);
$title = urlencode($qTitle);

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.themoviedb.org/3/search/multi?query=".($title)."&include_adult=false&language=it-IT&page=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3NzMxNGQ4NmFhMWQyNzJhNDBlZDEyYWI5OTU0MjkxNSIsInN1YiI6IjY0NjIyMzE5NmUwZDcyMDE1YzBmODgxNSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-GDQzsUcHjYZVfu6Sgumw_63epFVy65p7tVfe2byKkM",
        "accept: application/json"
    ],
]);
    
$response = curl_exec($curl);
$err = curl_error($curl);
    
curl_close($curl);
    
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
}
?>