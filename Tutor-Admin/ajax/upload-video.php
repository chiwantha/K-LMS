<?php
$apiKey = "1b7adcca-4a34-4fbc-a49e1019ccbf-ef2a-4895"; // Your actual API key
$libraryId = "265576"; // Your actual library ID

// Function to create a video and get the GUID
function createVideo($apiKey, $libraryId, $videoName) {
    $base_url = "https://video.bunnycdn.com/library/";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base_url . $libraryId . "/videos");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("title" => $videoName)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "AccessKey: " . $apiKey,
        "Content-Type: application/json"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 400) {
        return null;
    }

    return json_decode($response, true)['guid'];
}

// Function to generate the presigned signature
function generatePresignedSignature($libraryId, $apiKey, $expirationTime, $videoGuid) {
    $dataToSign = $libraryId . $apiKey . $expirationTime . $videoGuid;
    return hash('sha256', $dataToSign);
}

$expirationTime = time() + 3600; // Signature valid for 1 hour

// Ensure the POST request contains a filename
if (isset($_POST['filename'])) {
    $videoName = $_POST['filename'];
    $videoGuid = createVideo($apiKey, $libraryId, $videoName);

    if ($videoGuid) {
        $presignedSignature = generatePresignedSignature($libraryId, $apiKey, $expirationTime, $videoGuid);

        header('Content-Type: application/json');
        echo json_encode([
            'presignedSignature' => $presignedSignature,
            'expirationTime' => $expirationTime,
            'videoGuid' => $videoGuid,
            'libraryId' => $libraryId
        ]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Failed to create video']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Filename not provided']);
}
?>
