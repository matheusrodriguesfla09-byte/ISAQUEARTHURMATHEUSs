<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require_once'conexão.php'>
    $mensagem='';
    $tipoMensagem='';
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $nome=trim($_POST['nome']??'');
         $email = filter_input( INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
   $senha = $_POST['senha'] ?? '';
    }
    if (empty($nome) || !$email || empty($senha)) {
    $mensagem = 'Por favor, preencha todos os campos corretamente.';
    $tipoMensagem = 'erro';
} else {
    try {
        $stmtCheck = $pdo->prepare( "SELECT id FROM usuario WHERE email = :email");

        $stmtCheck->execute([':email' => $email]);

        if ($stmtCheck->rowCount() > 0) {
            $mensagem = 'Este email já está cadastrado.';
            $tipoMensagem = 'erro';
        } else {
            $senhaHash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO Usuarios (nome, email, senha)
                    VALUES (:nome, :email, :senha)";

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);

            $mensagem = 'Usuário cadastrado com sucesso!';
            $tipoMensagem = 'Sucesso';

} catch (PDOException $e) {
    $mensagem = 'Erro ao Cadastrar: ' . $e->getMessage();
    $tipoMensagem = 'erro';
                }
            }
        }
        </php>
        <div class="container">
        <h2>Cadastro de Usuário</h2>

        ?php if (!empty($mensagem)): ?>
            <div class="mensagem <?= htmlspecialchars($tipoMensagem) ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        ?php endif; ?>

        <form action="index.php" method="POST">

            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    required
                    placeholder="Digite seu nome"
                >
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="Digite o seu email"
                >
            </div>
        </form>
</body>
</html>