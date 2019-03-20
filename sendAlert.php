<?php
//taken from smsAPI docs 
function sms_send($params, $token, $backup = false)
{
    
    static $content;
    
    if ($backup == true) {
        $url = 'https://api2.smsapi.pl/sms.do';
    } else {
        $url = 'https://api.smsapi.pl/sms.do';
    }
    
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, $params);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $token"
    ));
    
    $content = curl_exec($c);
    $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
    
    if ($http_status != 200 && $backup == false) {
        $backup = true;
        sms_send($params, $token, $backup);
    }
    
    curl_close($c);
    return $content;
}


function sendAlert($id,$dbh,$alertContent,$location){
    $res = $dbh->query("SELECT groupID FROM AlertToGroup WHERE alertID=$id");
    $groups=$res->fetchAll();
    
    $alreadySent=array();
    
    foreach($groups as $g){

        $res2 = $dbh->query("SELECT userID FROM UserToGroup WHERE groupID=$g[0]");
        $users = $res2->fetchAll();

        foreach($users as $u){
            $q = $dbh->query("SELECT mail,phoneNumber FROM Users WHERE id=$u[0]");
            $res = $q->fetch();
            $time = date('d-m-Y H:i');
            $message = "'Nastapilo zdarzenie: $alertContent Lokalizacja: $location Data zgłoszenia: $time'";
            
            
            $command = escapeshellcmd("python3 /opt/lampp/htdocs/groupAlert/mail.py $message $res[0]");
            shell_exec($command);
            
          /*  $params = array(
                'to' => $res[1], //numery odbiorców rozdzielone przecinkami
                'from' => 'budvarAlerts', //pole nadawcy
                'message' => $message //treść wiadomości
            );*/
            $params = array(
                'to' => $res[1], //numery odbiorców rozdzielone przecinkami
                'from' => 'Info', //pole nadawcy
                'message' => $message //treść wiadomości
            );
            
            $token ="";
            
            
            
        }
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                




try{
    if(!isset($_GET['location'])) throw new Exception("noLocation");
    require "dblogin.php";
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $result = $dbh->query("SELECT id,alertContent FROM Alerts");
    $alerts=$result->fetchAll();
    $location = $_GET['location'];
    
    foreach($alerts as $a){
        $id = $a['id'];
        if(!empty($_GET["alert$id"])) sendAlert($id,$dbh,$a['alertContent'],$location);
    }
    
    
    
}catch(Exception $e){
    echo $e->getMessage();
}
require 'admin/alertsRedirect.php';



?>