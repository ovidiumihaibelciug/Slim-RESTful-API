<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET MULTIPLE CUSTOMERS
$app->get('/api/customers', function(Request $request, Response $response) {
    $sql = "SELECT * FROM `customers`";
    try {
        $db = new Db;

        $db = $db->connect();

        $stmt = $db->query($sql);

        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($customers);

    } catch (PDOException $e) {
        echo '{error: { "text": ' . $e->getMessage() . '}';
    }
});

//GET SINGLE CUSTOMER
$app->get('/api/customer/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM `customers` WHERE `id` = $id";
    try {
        $db = new Db;

        $db = $db->connect();

        $stmt = $db->query($sql);

        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($customer);

    } catch (PDOException $e) {
        echo '{error: { "text": ' . $e->getMessage() . '}';
    }
});

//ADD CUSTOMER
$app->post('/api/customer/add', function(Request $request, Response $response) {
    $firstname = $request->getParam('firstname');
    $lastname  = $request->getParam('lastname');
    $phone     = $request->getParam('phone');
    $email     = $request->getParam('email');
    $adress    = $request->getParam('adress');
    $city      = $request->getParam('city');
    $state     = $request->getParam('state');

    $sql = "INSERT INTO `customers` (firstname, lastname, phone, email, adress, city, state) VALUES(:firstname, :lastname, :phone, :email, :adress, :city, :state)";
    try {
        $db = new Db;

        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';
    } catch (PDOException $e) {
        echo '{error: { "text": ' . $e->getMessage() . '}';
    }
});

//EDIT CUSTOMER
$app->put('/api/customer/update/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $firstname = $request->getParam('firstname');
    $lastname  = $request->getParam('lastname');
    $phone     = $request->getParam('phone');
    $email     = $request->getParam('email');
    $adress    = $request->getParam('adress');
    $city      = $request->getParam('city');
    $state     = $request->getParam('state');

   $sql = "UPDATE `customers` SET firstname = :firstname, lastname = :lastname, phone = :phone, email = :email, adress = :adress, city = :city, state = :state WHERE `id` = $id";
    try {
        $db = new Db;

        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Updated"}';
    } catch (PDOException $e) {
        echo '{error: { "text": ' . $e->getMessage() . '}';
    }
});

//DELETE CUSTOMER
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM `customers` WHERE `id` = $id";
    try {
        $db = new Db;

        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $db = null;

        echo '{"notice": {"text": "Customer Deleted"}';

    } catch (PDOException $e) {
        echo '{error: { "text": ' . $e->getMessage() . '}';
    }
});
