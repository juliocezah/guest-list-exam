<?php
class GuestService{
    
    //Method for Guest List (GET)
    public static function listGuest() {
        $db = ConnectionFactory::getDB();
        $guests = array();
        
        foreach($db->guests() as $guest) {
           $guests[] = array (
               'id' => $guest['id'],
               'name' => $guest['name'],
               'email' => $guest['email']
           ); 
        }
        return $guests;
    }
    
    //Method for add a new guest (POST)
    public static function add($newGuest) {
        $db = ConnectionFactory::getDB();
        $guest = $db->guest->insert($newGuest);
        return $guest;
    }
    
    //Method for delete a guest by id (DELETE)
    public static function delete($id) {
        $db = ConnectionFactory::getDB();
        $guest = $db->guests[$id];
        if($guest) {
            $guest->delete();
            return true;
        }
        return false;
    }
}


?>