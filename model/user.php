<?php
/**
 * User Model
 */
require "Model.php";
class User extends Model {

    protected static $tableName = 'User';
    protected static $primaryKey = 'id';

    function setId($value){
        $this->setColumnValue('id', $value);
    }
    function getId(){
        return $this->getColumnValue('id');
    }

    function setVorname($value){
        $this->setColumnValue('vorname', $value);
    }
    function getVorname(){
        return $this->getColumnValue('vorname');
    }

    function setPassword($value){
        $this->setColumnValue('password', $value);
    }
    function getPassword(){
        return $this->getColumnValue('password');
    }

    function setEmail($value){
        $this->setColumnValue('email', $value);
    }
    function getEmail(){
        return $this->getColumnValue('email');
    }

    function setFullname($value){
        $this->setColumnValue('fullname', $value);
    }
    function getFullname(){
        return $this->getColumnValue('fullname');
    }

    function setPrivilege($value){
        $this->setColumnValue('privilege', $value);
    }
    function getPrivilege(){
        return $this->getColumnValue('privilege');
    }
}