
/* Cadastro e login */

function verificarDados(pagina) {

    const modal = document.getElementById('modal');
    const fechar = document.getElementById('fechar');
    let login = document.getElementById("login").value;
    let senha = document.getElementById("senha").value;
    
    let campos = [{valor: login, nomeExibicao: "Login" }, {valor: senha, nomeExibicao: "Senha" }];

    if (pagina === 'cadastro') {
        let nome = document.getElementById("name").value;
        let cpf = document.getElementById("cpf").value;
        let data = document.getElementById("data").value;
    
        for (let i of [{valor: nome, nomeExibicao: "Nome" }, {valor: cpf, nomeExibicao: "CPF" }, {valor: data, nomeExibicao: "Data de Nascimento" }]) {
            campos.push(i)
        }
    }

    let naoPreenchidos = ''

    for (let item of campos) {
        if (item.valor === "" || item.valor === 0) {
            if (naoPreenchidos !== '') {
                naoPreenchidos += ", "
            }
            naoPreenchidos += item.nomeExibicao;
        }
        document.getElementById("avisoDados").textContent = `É necessário preencher os campos: ${naoPreenchidos} para prosseguir.`
        modal.style.display = 'flex';
    }

    fechar.addEventListener('click', () => {
        modal.style.display = 'none';
    });
};

/* Produto */

function verificarTotal() {

    const inputQuantidade =  document.getElementById('quantidade');
    let quantidade = parseInt(inputQuantidade.value);
    let preco = document.getElementById('descricao-produto').dataset.preco;
    let precoTotal = quantidade * parseFloat(preco);

    let precoAVista = document.getElementById('preco-a-vista');
    let precoParcelado = document.getElementById('precoParcelado');
    precoAVista.textContent = `R$ ${precoTotal.toFixed(2).replace('.', ',')}`;
    precoParcelado.textContent = ` 2x R$ ${(precoTotal/2).toFixed(2).replace('.', ',')}`;
}   

