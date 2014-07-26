<?php

/**
 * Cred: @link http://beagile.biz/merge-2-php-code-sniffer-clover-xml-reports/}
 */

$lobjArgs = $_SERVER['argv'];

$lobjFiles = preg_grep("/^((?!.*(merge-clover\.php)).*)/", $lobjArgs);
$lobjFiles = preg_grep('/^((?!(--output)).*)/', $lobjFiles);
$lobjFiles = array_values($lobjFiles);

$lobjOptions = getopt('', array('output:'));

if (count($lobjFiles) >= 2) {
    $lobjXmlAggregate = simplexml_load_file($lobjFiles[0]);

    $i = 1;

    while ($i < count($lobjFiles)) {
        $lobjXmlNext = simplexml_load_file($lobjFiles[$i]);
        foreach ($lobjXmlNext->file as $file) {
            $lobjAddChild = $lobjXmlAggregate->addChild('file', $file);
            foreach ($file->attributes() as $key => $value) {
                $lobjAddChild->addAttribute($key, $value);
            }

            foreach ($file->error as $error) {
                $lobjAddError = $lobjAddChild->addChild('error', $error);

                foreach ($error->attributes() as $key => $value) {
                    $lobjAddError->addAttribute($key, $value);
                }
            }
        }
        $i++;
    }

    $lobjFileHandle = fopen($lobjOptions['output'], 'w') or die("can't open file phpcs-merged.xml");
    fwrite($lobjFileHandle, $lobjXmlAggregate->asXML());
    fclose($lobjFileHandle);
}

echo "Merge complete\n";