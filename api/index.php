<?php

require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'tasks/GuestService.php';


$app = new \Slim\Slim();

$app->get('/', function() use ( $app ) {
    echo "Welcome to Guest REST API Exam";
});

/*
HTTP GET /api/guests
RESPONSE 200 OK 
[
  {
    "id": "1",
    "name": "Lidy Segura",
    "email": "lidyber@gmail.com"
  },
  {
    "id": "2",
    "name": "Edy Segura",
    "email": "edysegura@gmail.com"
  }
]
*/
$app->get('/guests/', function() use ( $app ) {
    $guests = GuestService::listGuest();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});

/*
HTTP POST /api/guests
REQUEST Body 
{
	"name": "Lidy Segura",
	"email": "lidyber@gmail.com"
}

RESPONSE 200 OK 
{
  "name": "This is a test",
  "email": "test@gmail.com",
  "id": "1"
}
*/
$app->post('/guests/', function() use ( $app ) {
    $taskJson = $app->request()->getBody();
    $newGuest = json_decode($taskJson, true);
    
    if($newGuest) {
        $guest = GuestService::add($newGuest);
        
        //RESPONSE 200 OK
        $guestResult = array('name'=>'this a teste','email'=>'tset@gmail.com','id'=>'1');
        echo json_encode($guestResult);
    }
    else {
        $app->response->setStatus(400);
        echo "Malformat JSON";
    }
});

/*
HTTP DELETE /api/guests/:id
RESPONSE 200 OK 
{
  "status": "true",
  "message": "Guest deleted!"
}

HTTP DELETE /api/guests/x
RESPONSE 404 NOT FOUND 
{
  "status": "false",
  "message": "Guest with x does not exit"
}
*/
$app->delete('/guests/:id', function($id) use ( $app ) {
    
    //RESPONSE 200 OK:
    if(GuestService::delete($id)) {
      $guestResult = array('Status'=>'true','messagem'=>'Guest deleted');    
      echo json_encode($guestResult);
    }
    
    //RESPONSE 404 NOT FOUND:
    else {
      $app->response->setStatus('404');
      
      $guestResult = array('Status'=>'false','messagem'=>'Guest with ' . $id . 'does not exit');   
      echo json_encode($guestResult);
    }
});


$app->run();
?>