<?php
// Recupera o token da URL
$token = isset($_GET['token']) ? $_GET['token'] : null;

if (!$token) {
  // Trata a ausência do token na URL
  http_response_code(400);
  echo json_encode(["error" => "Token não encontrado na URL."]);
  exit();
}

// Conecta ao banco de dados usando PDO
$dsn = "mysql:host=localhost;dbname=nome_do_banco_de_dados";
$username = "usuario_do_banco";
$password = "senha_do_banco";
$pdo = new PDO($dsn, $username, $password);

// Insere o token na tabela login
$stmt = $pdo->prepare("UPDATE login SET token = ? WHERE token IS NULL");
$stmt->execute([$token]);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Recupera a nova senha
  $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

  if (!$senha) {
    // Trata a ausência da nova senha
    http_response_code(400);
    echo json_encode(["error" => "Informe uma senha válida."]);
    exit();
  } else {
    // Atualiza a senha do usuário na tabela login
    $stmt = $pdo->prepare("UPDATE login SET senha = ? WHERE token = ?");
    $stmt->execute([password_hash($senha, PASSWORD_DEFAULT), $token]);
    echo json_encode(["message" => "Senha atualizada com sucesso!"]);
    exit();
  }
}
?>
