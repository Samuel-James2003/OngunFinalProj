<?php
function extractDataFromFile($filename) {
    // Check if the file exists
    if (!file_exists($filename)) {
        return false;
    }
    
    // Read the file into a string
    $fileContent = file_get_contents($filename);
    
  // Define an associative array to store extracted data
    $data = array(
        'dateofbirth' => '',
        'name' => '',
        'firstname' => '',
        'middlenames' => '',
        'nationality' => '',
        'streetandnumber' => '',
        'zip' => '',
        'municipality' => ''
    );

    // Use regular expressions to extract data between the tags and attributes
    preg_match('/dateofbirth="(.*?)"/', $fileContent, $dateofbirthMatch);
    preg_match('/<name>(.*?)<\/name>/s', $fileContent, $nameMatch);
    preg_match('/<firstname>(.*?)<\/firstname>/s', $fileContent, $firstnameMatch);
    preg_match('/<middlenames>(.*?)<\/middlenames>/s', $fileContent, $middlenamesMatch);
    preg_match('/<nationality>(.*?)<\/nationality>/s', $fileContent, $nationalityMatch);
    preg_match('/<streetandnumber>(.*?)<\/streetandnumber>/s', $fileContent, $streetandnumberMatch);
    preg_match('/<zip>(.*?)<\/zip>/s', $fileContent, $zipMatch);
    preg_match('/<municipality>(.*?)<\/municipality>/s', $fileContent, $municipalityMatch);
 
    // Store the extracted data in the array
    if (isset($nameMatch[1])) {
        $data['name'] = $nameMatch[1];
    }
    if (isset($firstnameMatch[1])) {
        $data['firstname'] = $firstnameMatch[1];
    }
    if (isset($middlenamesMatch[1])) {
        $data['middlenames'] = $middlenamesMatch[1];
    }
    if (isset($nationalityMatch[1])) {
        $data['nationality'] = $nationalityMatch[1];
    }
    if (isset($dateofbirthMatch[1])) {
        $data['dateofbirth'] = $dateofbirthMatch[1];
    }
    if (isset($streetandnumberMatch[1])) {
        $data['streetandnumber'] = $streetandnumberMatch[1];
    }
    if (isset($zipMatch[1])) {
        $data['zip'] = $zipMatch[1];
    }
    if (isset($municipalityMatch[1])) {
        $data['municipality'] = $municipalityMatch[1];
    }
    
    return $data;
}
?>