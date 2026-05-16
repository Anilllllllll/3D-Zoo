<?php

$publicSoundsDir = __DIR__ . '/public/sounds';
if (!is_dir($publicSoundsDir)) {
    mkdir($publicSoundsDir, 0777, true);
}

try {
    $mysql = new PDO('mysql:host=127.0.0.1;port=3306;dbname=zoosphere', 'root', '');
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $mysql->query('SELECT id, name FROM animals');
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    function fetch_url($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZooSphere/1.0 (test@example.com)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    $downloadCount = 0;
    $validAudioExts = ['ogg', 'oga', 'mp3', 'wav', 'flac'];

    foreach ($animals as $animal) {
        echo "Searching sound for: " . $animal['name'] . "... ";
        
        // Use a strict search for audio mime types in the File namespace (srnamespace=6)
        $query = urlencode($animal['name'] . " sound");
        $searchUrl = "https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch={$query}&srnamespace=6&utf8=&format=json";
        
        $searchResponse = fetch_url($searchUrl);
        $searchData = json_decode($searchResponse, true);
        
        $foundAudio = false;

        if ($searchData && isset($searchData['query']['search']) && count($searchData['query']['search']) > 0) {
            
            // Loop through top 3 results to find an actual audio file
            foreach ($searchData['query']['search'] as $result) {
                $title = $result['title'];
                
                $infoUrl = "https://commons.wikimedia.org/w/api.php?action=query&titles=" . urlencode($title) . "&prop=imageinfo&iiprop=url&format=json";
                $infoResponse = fetch_url($infoUrl);
                
                if ($infoResponse) {
                    $infoData = json_decode($infoResponse, true);
                    $pages = $infoData['query']['pages'] ?? [];
                    $page = reset($pages);
                    
                    if (isset($page['imageinfo'][0]['url'])) {
                        $audioUrl = $page['imageinfo'][0]['url'];
                        
                        $ext = strtolower(pathinfo(parse_url($audioUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
                        
                        if (in_array($ext, $validAudioExts)) {
                            // We found a REAL audio file!
                            $safeName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $animal['name']));
                            $filename = "{$safeName}.{$ext}";
                            $localPath = "{$publicSoundsDir}/{$filename}";
                            
                            $audioContent = fetch_url($audioUrl);
                            if ($audioContent) {
                                file_put_contents($localPath, $audioContent);
                                
                                $dbPath = "/sounds/{$filename}";
                                $update = $mysql->prepare('UPDATE animals SET sound = :sound WHERE id = :id');
                                $update->execute(['sound' => $dbPath, 'id' => $animal['id']]);
                                
                                echo "Downloaded actual audio (.{$ext})!\n";
                                $downloadCount++;
                                $foundAudio = true;
                                break; // Stop looping results for this animal
                            }
                        }
                    }
                }
            }
        }
        
        if (!$foundAudio) {
            echo "Skipped (No audio found).\n";
        }
        
        usleep(300000); // 0.3 seconds
    }

    echo "\nFinished! Successfully downloaded $downloadCount STRICT audio files.\n";
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}
