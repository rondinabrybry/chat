<?php
include 'dbh.class.php';

class Handler extends Dbh{

    public function queryEmail($sql, $params) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }

    public function executeReg($sql, $params) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
    
        if (!$success) {
            return false;
        }
    
        return $conn->lastInsertId();
    }
    
    public function executeNick($sql, $params) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
    
        if (!$success) {
            return false;
        }
    
        return $conn->lastInsertId();
    }
    
    function query($sql){
        $conn = $this->connect();
        $stmt = $conn->query($sql); // kasagaran mn diba diri kay $conn->query("SELECT * FROM chats WHERE isActive = 1);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // nya diri tong pag fetch assoc sa tanan result adto nga query

        $conn = null;
        return $result; // nya diri gi return ra ang result, kini palang nga query 3 na ka lines nya mag balik2 ni kapila
    }


    function queryOne($sql){
        $conn = $this->connect();
        $stmt = $conn->query($sql);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conn = null;
        return $result[0];
    }


    function exec($sql){
        $conn = $this->connect();
        $stmt = $conn->prepare($sql[0]);

        if(count($sql) > 1){
            $stmt-> execute($sql[1]);
        }else{
            $stmt-> execute();
        }
        $id = $conn->lastInsertId();

        $conn = null;
        return $id;
    }

}
