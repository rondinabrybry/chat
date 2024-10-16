<?php

class Dbh {

    protected function connect(){
        try{
            $user = "u132092183_aoc";
            $pass = "AllianceOfCoders2024";
            $dbh = new PDO("mysql:host=localhost;dbname=u132092183_aoc", $user, $pass);
            return $dbh;
        }catch(PDOException $e){
            print "Error!". $e->getMessage(). "<br/>";
            die();
        }
    }
}