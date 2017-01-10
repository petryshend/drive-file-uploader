<?php

/** @var Google_Service_Drive $service */
$service = require_once 'service.php';

define('PATH_TO_FILES', '/home/px/Documents/somefiles/');

$files = array_diff(scandir(PATH_TO_FILES), ['.', '..']);
foreach ($files as $fileName) {
    $fileMetadata = new Google_Service_Drive_DriveFile([
        'name' => $fileName,
    ]);
    $content = file_get_contents(PATH_TO_FILES . $fileName);
    $file = $service->files->create($fileMetadata, [
        'data' => $content,
        'mimeType' => 'image/jpeg',
        'uploadType' => 'multipart',
        'fields' => 'id'
    ]);
    printf("Uploaded file \"%s\" with Id %s\n", $fileName, $file->id);

    if ($file->id) {
        unlink(PATH_TO_FILES . $fileName);
    }
}

