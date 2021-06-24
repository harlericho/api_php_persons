<?php
class Settings 
{
    public static function __db()
    {
        try {
            $con = new PDO("mysql:host=localhost;dbname=db_api_persons", "charlie", "charlie");
            //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $con;
        } catch (\Throwable $th) {
            die("Failed connection: " . $th->getMessage());
        }
    }
}
