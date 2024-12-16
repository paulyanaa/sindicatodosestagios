<?php
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Filiado - Cadastro</title>
</head>
<body>
<main>
    <h1>Cadastro de Filiado</h1>

    <section class="container-form">
        <form action="<?php echo AmbienteConfig::getUrl('filiado/cadastrarFiliado')?>" method="post" enctype="multipart/form-data">


            <label for="nome">Nome</label>
            <input type="text" id="nome" name="flo_nome" placeholder="Digite o nome"
                   required minlength="3" maxlength="100"
                   pattern="[a-zA-Zà-úÀ-Ú\s]+"
                   title="O nome deve conter apenas letras e espaços."/><br>


            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="flo_cpf" placeholder="000.000.000-00"
                   required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                   title="O CPF deve estar no formato 000.000.000-00."/><br>


            <label for="rg">RG</label>
            <input type="text" id="rg" name="flo_rg" placeholder="Digite o RG"

                   title="O RG deve conter apenas números."/><br>


            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" id="data_nascimento" name="flo_data_nascimento"
                   required max="2006-12-31"
                   title="O filiado deve ter pelo menos 18 anos."/><br>

            <label for="idade">Idade</label>
            <input type="text" id="idade" name="flo_idade" placeholder="" readonly/><br>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="flo_empresa" placeholder="Digite o nome da empresa"
                   maxlength="100"

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="flo_cargo" placeholder="Digite o cargo"
                   maxlength="50"


            <div>
                <label>Situacao</label>
                <select name="flo_situacao" required>
                    <option value="">Selecione</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                    <option value="Aposentado">Aposentado</option>
                    <option value="Licenciado">Licenciado</option>
                </select>
            </div><br>


            <label for="tel_residencial">Telefone Residencial</label>
            <input type="tel" id="tel_residencial" name="flo_tel_residencial" placeholder="(00)0000-0000"
                   required pattern="\(\d{2}\)\d{4}-\d{4}"
                   title="O telefone deve estar no formato (00)0000-0000."/><br>


            <label for="tel_celular">Telefone Celular</label>
            <input type="tel" id="tel_celular" name="flo_tel_celular" placeholder="(00)00000-0000"
                   required pattern="\(\d{2}\)\d{5}-\d{4}"
                   title="O telefone deve estar no formato (00)00000-0000."/><br>


            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar filiado"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('filiado/listar')?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>
    </section>
</main>

<script>
    // Obtém os elementos do DOM
    const dataNascimentoInput = document.getElementById('data_nascimento');
    const idadeInput = document.getElementById('idade');

    // Função para calcular a idade com base na data de nascimento
    function calcularIdade() {
        // Se o campo de data de nascimento estiver vazio, sai da função
        if (!dataNascimentoInput.value) return;

        // Cria objetos Date para a data atual e a data de nascimento
        const hoje = new Date();
        const nascimento = new Date(dataNascimentoInput.value);

        // Calcula a idade
        let idade = hoje.getFullYear() - nascimento.getFullYear();
        const mes = hoje.getMonth();
        const dia = hoje.getDate();

        // Verifica se já passou o aniversário este ano
        if (mes < nascimento.getMonth() || (mes === nascimento.getMonth() && dia < nascimento.getDate())) {
            idade--; // Subtrai 1 ano se ainda não fez aniversário este ano
        }

        // Exibe a idade no campo "idade"
        idadeInput.value = idade;
    }

    // Adiciona um evento para quando a data de nascimento for alterada
    dataNascimentoInput.addEventListener('change', calcularIdade);
</script>
</body>
</html>
