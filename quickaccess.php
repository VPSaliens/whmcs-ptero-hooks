<?php
add_hook('AdminClientServicesTabFields', 1, function($vars) {
    //EDIT THESE VALUES
    //API Key only requires the "Servers" Read permission
    //Include http(s):// in your panel URL with no / at the end.
    //Eg. "https://panel.yoursite.com"
    $apiKey = 'XXXXXXXXXXXXXXXXXXXXXXX';
    $panelUrl = 'https://PANEL.YOURSITE.COM';
    
    
    
    //DO NOT TOUCH
    $productId = $vars['id'];
    $url = $panelUrl . '/api/application/servers/external/' . $productId;
    $method = 'GET';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($curl, CURLOPT_USERAGENT, "Pterodactyl-WHMCS");
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_POSTREDIR, CURL_REDIR_POST_301);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    $headers = [
    "Authorization: Bearer " . $apiKey,
    "Accept: Application/vnd.pterodactyl.v1+json",
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    $responseData = json_decode($response, true);
    $uuid = $responseData['attributes']['identifier'];
    $internalId = $responseData['attributes']['id'];
    return [
        'Quick Server Access' => '<a href="' . $panelUrl . '/server/' . $uuid . '" target="_blank" class="btn btn-default">View as Client</a> <a href="' . $panelUrl . '/admin/servers/view/' . $internalId . '" target="_blank" class="btn btn-default">View as Admin</a>',
    ];
});
