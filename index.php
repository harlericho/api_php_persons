<?php
require_once "./app/cors.php";
require_once "./app/persons.php";
if ($_GET) {
    $data = "";
    $photo = "sin-photo.png";
    $option = $_GET['option'];
    switch ($option) {
        case 'GET':
            $data = Persons::__listData();
            break;
        case 'POST':
            if (Persons::__validationsDni($_POST['dni'])) {
                $data = "DNI is already taken";
            } else if (Persons::__validationsEmail($_POST['email'])) {
                $data = "EMAIL is already taken";
            } else {
                if (isset($_FILES['file'])) {
                    $photo = $_FILES['file']['name'];
                    $urlImages = "./public/uploads/";
                    $target = $urlImages . basename($photo);
                    copy($_FILES['file']['tmp_name'], $target);
                }
                $arrayName = array(
                    'dni' => $_POST['dni'],
                    'names' => $_POST['names'],
                    'email' => $_POST['email'],
                    'photo' => $photo,
                );
                $data = Persons::__saveData($arrayName);
            }

            break;
        case 'PUT':
            if (Persons::__validationsDniUpdate($_POST['dni'], $_POST['id']) >= 2) {
                $data = "DNI is already taken";
            } else if (Persons::__validationsEmailUpdate($_POST['email'], $_POST['id']) >= 2) {
                $data = "EMAIL is already taken";
            } else {
                $id = $_POST['id'];
                $image = Persons::__foundImage($id);
                if (isset($_FILES['file'])) {
                    if ($photo != $image['photo']) {
                        if (file_exists("./public/uploads/" . $image['photo'])) {
                            unlink("./public/uploads/" . $image['photo']);
                        }
                    }
                    $photo = $_FILES['file']['name'];
                    $urlImages = "./public/uploads/";
                    $target = $urlImages . basename($photo);
                    copy($_FILES['file']['tmp_name'], $target);
                } else {
                    $photo = $image['photo'];
                }
                $arrayName = array(
                    'dni' => $_POST['dni'],
                    'names' => $_POST['names'],
                    'email' => $_POST['email'],
                    'photo' => $photo,
                    'date_u' => date('Y-m-d H:i:s'),
                    'id' => $_POST['id'],
                );
                $data = Persons::__updateData($arrayName);
            }
            break;
        case 'DELETE':
            $data = Persons::__deleteData($_POST['id']);
            break;
        default:
            # code...
            break;
    }
    print_r(json_encode($data));
}
