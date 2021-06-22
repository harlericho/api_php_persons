<?php
require_once "settings.php";
class Persons extends Settings
{
    public static function __listData()
    {
        try {
            $sql = "SELECT * FROM persons";
            $query = Settings::__db()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (\Throwable $th) {
            die("Failed query: " . $th->getMessage());
        }
    }

    public static function __saveData($data)
    {
        try {
            $sql = "INSERT INTO persons(dni,names,email,photo) VALUES(:dni,:names,:email,:photo)";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':dni', $data['dni'], PDO::PARAM_STR);
            $query->bindParam(':names', $data['names'], PDO::PARAM_STR);
            $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $query->bindParam(':photo', $data['photo'], PDO::PARAM_STR);
            return $query->execute();
        } catch (\Throwable $th) {
            return $th->getMessage();
            //die("Failed query: " . $th->getMessage());
        }
    }

    public static function __updateData($data)
    {
        try {
            $sql = "UPDATE persons SET dni=:dni,names=:names,email=:email,photo=:photo,date_u=:date_u WHERE id=:id";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':dni', $data['dni'], PDO::PARAM_STR);
            $query->bindParam(':names', $data['names'], PDO::PARAM_STR);
            $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $query->bindParam(':photo', $data['photo'], PDO::PARAM_STR);
            $query->bindParam(':date_u', $data['date_u'], PDO::PARAM_STMT);
            $query->bindParam(':id', $data['id'], PDO::PARAM_INT);
            return $query->execute();
        } catch (\Throwable $th) {
            //die("Failed query: " . $th->getMessage());
            return $th->getMessage();
        }
    }
    public static function __deleteData($id)
    {
        try {
            $sql = "UPDATE persons SET status='I' WHERE id=:id";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            return $query->execute();
        } catch (\Throwable $th) {
            //die("Failed query: " . $th->getMessage());
            return $th->getMessage();
        }
    }

    public static function __validationsDni($dni)
    {
        try {
            $sql = "SELECT * FROM persons WHERE dni=:dni";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':dni', $dni, PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll();
        } catch (\Throwable $th) {
            //die("Failed query: " . $th->getMessage());
            return $th->getMessage();
        }
    }
    public static function __validationsEmail($email)
    {
        try {
            $sql = "SELECT * FROM persons WHERE email=:email";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll();
        } catch (\Throwable $th) {
            //die("Failed query: " . $th->getMessage());
            return $th->getMessage();
        }
    }
    public static function __foundImage($id)
    {
        try {
            $sql = "SELECT photo FROM persons WHERE id=:id";
            $query = Settings::__db()->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (\Throwable $th) {
            //die("Failed query: " . $th->getMessage());
            return $th->getMessage();
        }
    }
}
