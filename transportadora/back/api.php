<?php
header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

require "config.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];

function teste(){
    echo json_encode(["mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}

function createCliente($con, $dados){
    $stmt = $con->prepare("INSERT INTO CLIENTE (NOME, ENDERECO, TELEFONE, EMAIL) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Cliente criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readCliente($con){
    $stmt = $con->query("SELECT * FROM Cliente");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateCliente($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Cliente SET nome = ?, endereco = ?, telefone = ?, email = ? WHERE idCliente = ?");
    $stmt->execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"], $id]);
    echo json_encode(["mensagem" => "Cliente alterado com sucesso"]);
}

function deleteCliente($con, $id){
    $stmt = $con->prepare("DELETE FROM Cliente WHERE idCliente = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Cliente removido com sucesso!"]);
}

function createFuncionario($con, $dados){
    $stmt = $con->prepare("INSERT INTO Funcionario (nome, endereco, telefone, email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Funcionario criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readFuncionario($con){
    $stmt = $con->query("SELECT * FROM Funcionario");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateFuncionario($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Funcionario SET nome = ?, endereco = ?, telefone = ?, email = ? WHERE idFuncionario = ?");
    $stmt->execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"], $id]);
    echo json_encode(["mensagem" => "Funcionario alterado com sucesso!"]);
}

function deleteFuncionario($con, $id){
    $stmt = $con->prepare("DELETE FROM Funcionario WHERE idFuncionario = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Funcionario removido com sucesso!"]);
}

function createVeiculo($con, $dados){
    $stmt = $con->prepare("INSERT INTO Veiculo (marca, modelo, ano, placa) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dados["marca"], $dados["modelo"], $dados["ano"], $dados["placa"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Veiculo criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readVeiculo($con){
    $stmt = $con->query("SELECT * FROM Veiculo");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateVeiculo($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Veiculo SET marca = ?, modelo = ?, ano = ?, placa = ? WHERE idVeiculo = ?");
    $stmt->execute([$dados["marca"], $dados["modelo"], $dados["ano"], $dados["placa"], $id]);
    echo json_encode(["mensagem" => "Veiculo alterado com sucesso!"]);
}

function deleteVeiculo($con, $id){
    $stmt = $con->prepare("DELETE FROM Veiculo WHERE idVeiculo = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Veiculo removido com sucesso!"]);
}

if ($rota === "cliente") {
    switch($metodo){
        case "POST":
            createCliente($con, $corpo);
            break;
        case "GET":
            readCliente($con);
            break;
        case "PUT":
            updateCliente($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteCliente($con, $_GET["id"]);
            break;
        default:
            teste();
    }
} else if ($rota === "funcionario"){
    switch($metodo){
        case "POST":
            createFuncionario($con, $corpo);
            break;
        case "GET":
            readFuncionario($con);
            break;
        case "PUT":
            updateFuncionario($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteFuncionario($con, $_GET["id"]);
            break;
        default:
            teste();
    }
} else if ($rota === "veiculo"){
    switch($metodo){
        case "POST":
            createVeiculo($con, $corpo);
            break;
        case "GET":
            readVeiculo($con);
            break;
        case "PUT":
            updateVeiculo($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteVeiculo($con, $_GET["id"]);
            break;
        default:
            teste();
    }
} else {
    teste();
}