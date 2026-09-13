

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


/* Carrinho */

function exibirCarrinho(desconto = 0) {

    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    let carrinhodiv = document.getElementById('produtoscarrinho');
    carrinhodiv.innerHTML = `<h2 id="titulocarrinho">Seu carrinho</h2>
    <input type="submit" value="Limpar" onclick="limparCarrinho()" class='botao'>`;
    carrinho.forEach(item => {
        carrinhodiv.innerHTML += `
            <fieldset class="itemcarrinho">
                <div class="textoproduto">
                    <input type="number" id="quantidade" value="${item.quantidade}" min="1" onchange="atualizarQuantidade('${item.nome}', this.value)">
                    <h2>${item.quantidade}x ${item.nome}</h2> 
                    <p>Hambúrguer de carne</p>
                    <p><strong>${(item.preco * item.quantidade).toFixed(2).replace('.', ',')}</strong></p>
                </div>
                <img src="imagens/xis.jpeg" alt="Imagem do Hambúrguer" class="imagemcarrinho">
            </fieldset>
        `;
    });

    let teladiv = document.getElementById('precocarrinho');
    let subtotal = carrinho.reduce((total, item) => total + (item.preco * item.quantidade), 0);
    if (desconto === "20%off") {
        subtotal *= 0.8;
    }
    if (localStorage.getItem('cep')) {
        var cep = parseInt(localStorage.getItem('cep'));
    } else {
        localStorage.setItem('cep', 88495000);
        var cep = 88495000;
    }
    let frete = calcularFrete(cep);
    if (desconto === "fretegratis") {
        frete = 0;
    };
    teladiv.innerHTML = `
        <br><p class="textocarrinho">Subtotal:</p>
        <p class="precocarrinho">R$${subtotal.toFixed(2).replace('.', ',')}</p> <br> <br>
        <p class="textocarrinho">Entrega:</p>
        <p class="precocarrinho">R$${frete.toFixed(2).replace('.', ',')}</p> <br> <br>
        <p class="textocarrinho">Total:</p>
        <p class="precocarrinho">R$${(subtotal + frete).toFixed(2).replace('.', ',')}</p> <br> <br>
    `;

    let cepDiv = document.getElementById('cep');
    cepDiv.innerHTML = `
        <p>Cep atual: ${cep}</p>
        <input type="submit" value="Mudar Cep" onclick="mudarCep()">
    `;

    let cuponsDiv = document.getElementById('cupons');
    let valorDesconto = 0;
    if (desconto === "20%off") {
        valorDesconto += carrinho.reduce((total, item) => total + (item.preco * item.quantidade), 0) - subtotal;
    } else if (desconto === "fretegratis") {
        valorDesconto += calcularFrete(cep);
    }
    cuponsDiv.innerHTML = `
        <legend class="legenda">Aplicar cupom</legend>
        <p>Desconto: R$${valorDesconto.toFixed(2).replace('.', ',')}</p>
        <input type="submit" value="Adicionar cupom" onclick="aplicarCupom()">
    `;
}

function adicionarCarrinho(nome, preco, quantidade) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    if (carrinho.some(item => item.nome === nome)) {
        alert('Produto já está no carrinho!');
        return;
    }
    carrinho.push({ nome, preco, quantidade });
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    alert('Produto adicionado ao carrinho!');
}

function atualizarQuantidade(nome, novaQuantidade) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    let item = carrinho.find(item => item.nome === nome);
    if (item) {
        item.quantidade = parseInt(novaQuantidade);
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        exibirCarrinho();
    }
};

function mudarCep() {
    let novoCep = prompt("Digite o novo CEP (somente números):");
    cep = parseInt(novoCep);
    if (calcularFrete(cep) === 0) {
        alert("CEP fora da área de entrega.");
        return;
    }
    localStorage.setItem('cep', cep);
    exibirCarrinho();
};

function calcularFrete(cep) {
    let frete = 0;

    if (cep >= 88780000 && cep <= 88789999) { // Imbituba
        frete = 20; 
    } else if (cep >= 88495000 && cep <= 88499999) { // Garopaba
        frete = 15; 
    } else if (cep >= 88490000 && cep <= 88494999) { // Paulo Lopes
        frete = 25; 
    } 
    return frete;
}

function limparCarrinho() {
    localStorage.removeItem('carrinho');
    exibirCarrinho();
};

function aplicarCupom() {
    let cupom = prompt("Digite o código do cupom:");
    if (cupom === "fretegratis" || cupom === "20%off") {
        exibirCarrinho(cupom);
    } else {
        alert("Cupom inválido.");
        return;
    };
};

/* Avaliação */

if (document.getElementById("estrelas")) {

    const estrelas = document.querySelectorAll(".estrela");
    const textoNota = document.getElementById("nota");

    let notaSelecionada = 0;

    estrelas.forEach((estrela) => {
        estrela.addEventListener("click", () => {
            notaSelecionada = Number(estrela.dataset.nota);

            estrelas.forEach((item) => {
                const valor = Number(item.dataset.nota);

                if (valor <= notaSelecionada) {
                    item.textContent = "★";
                    item.classList.add("selecionada");
                } else {
                    item.textContent = "☆";
                    item.classList.remove("selecionada");
                }
            });

            textoNota.textContent = `Nota: ${notaSelecionada} / 5`;
        });
    });
}
