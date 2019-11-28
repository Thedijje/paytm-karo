<?php 

$data   =   file_get_contents('php://input');

slack_notify(json_encode($data));

function slack_notify($msg){
    $data = array('text'=>$msg);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://hooks.slack.com/services/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",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"text\": \"$msg\"}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"),
        ));
        $response = @curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            log_message('error', "cURL Error #:" . $err);
        }
}