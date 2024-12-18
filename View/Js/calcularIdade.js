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