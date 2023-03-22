import { useState } from "react";

function EditarSenha() {
  const [token, setToken] = useState("");
  const [senha, setSenha] = useState("");
  const [mensagem, setMensagem] = useState("");

  const handleSubmit = async (event) => {
    event.preventDefault();

    // Envia uma requisição POST para o endpoint REST PHP
    const response = await fetch(
      `https://example.com/endpoint.php?token=${token}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `senha=${senha}`,
      }
    );

    // Verifica o status da resposta
    if (response.ok) {
      setMensagem("Senha atualizada com sucesso.");
    } else {
      const data = await response.text();
      setMensagem(data);
    }
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <label>
          Token:
          <input
            type="text"
            value={token}
            onChange={(event) => setToken(event.target.value)}
          />
        </label>
        <br />
        <label>
          Nova senha:
          <input
            type="password"
            value={senha}
            onChange={(event) => setSenha(event.target.value)}
          />
        </label>
        <br />
        <button type="submit">Atualizar senha</button>
      </form>
      {mensagem && <p>{mensagem}</p>}
    </div>
  );
}

export default EditarSenha;
