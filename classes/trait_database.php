<?php
trait trait_database{
  function getConn(){
      //koneksi ke db
      $intance_conn = database::getInstance();
      $DB_conn = $intance_conn->getConn();
      return $DB_conn;
  }
}