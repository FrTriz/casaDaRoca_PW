document.addEventListener('DOMContentLoaded', () => {

    // =========================================
    // Lógica para o Pop-up de Adicionar ao Carrinho
    // =========================================
    const botoesCarrinho = document.querySelectorAll('.adicionar-carrinho');
    const popupOverlay = document.getElementById('popup-confirmacao');

    if (popupOverlay && botoesCarrinho.length > 0) {
        const popupMessage = document.getElementById('popup-message');
        const popupClose = popupOverlay.querySelector('.popup-close');
        const popupVerCarrinho = popupOverlay.querySelector('.botao');
        
        botoesCarrinho.forEach(botao => {
            botao.addEventListener('click', function(event) {
                event.preventDefault(); 

                const nomeProduto = this.getAttribute('data-nome');
                const linkAcao = this.href; 

                fetch(linkAcao)
                    .then(response => response.json())
                    .then(data => {
                        if (data.sucesso) {
                            popupMessage.textContent = `"${nomeProduto}" foi adicionado com sucesso.`;
                            popupVerCarrinho.href = 'carrinho.php';
                            popupOverlay.style.display = 'flex';
                        } else {
                            alert(data.mensagem || 'Ocorreu um erro ao adicionar o produto.');
                        }
                    })
                    .catch(error => console.error('Erro na comunicação:', error));
            });
        });

        // Lógica para fechar o pop-up
        if (popupClose) {
            popupClose.addEventListener('click', () => {
                popupOverlay.style.display = 'none';
            });
        }
        window.addEventListener('click', (event) => {
            if (event.target === popupOverlay) {
                popupOverlay.style.display = 'none';
            }
        });
    }

    // =========================================
    // Lógica para o Modal de Login/Cadastro no Header
    // =========================================
    const userIcon = document.getElementById('user-icon');
    const userModal = document.getElementById('user-modal');

    if (userIcon && userModal) {
        userIcon.addEventListener('click', (event) => {
            event.preventDefault();
            userModal.classList.toggle('active');
        });

        // Fecha o modal se o utilizador clicar fora dele
        document.addEventListener('click', (event) => {
            if (!userIcon.contains(event.target) && !userModal.contains(event.target)) {
                userModal.classList.remove('active');
            }
        });
    }

    // =========================================
    // Lógica para Alternar Formulários de Login/Cadastro
    // =========================================
    window.toggleForm = (formId) => {
        const loginForm = document.getElementById('login-form');
        const cadastroForm = document.getElementById('cadastro-form');
        
        if (loginForm && cadastroForm) {
            if (formId === 'cadastro') {
                loginForm.classList.remove('active');
                cadastroForm.classList.add('active');
            } else {
                cadastroForm.classList.remove('active');
                loginForm.classList.add('active');
            }
        }
    };

    // =========================================
    // Lógica do Menu Hambúrguer (SOLUÇÃO!)
    // =========================================
    const menuToggle = document.getElementById('menuToggle');
    const menuNav = document.getElementById('menuNav');

    if (menuToggle && menuNav) {
        menuToggle.addEventListener('click', function() {
            // Alterna a classe 'active' no menu de navegação
            menuNav.classList.toggle('active');
            
            // Opcional: Adiciona/remove a classe para animação do X
            this.classList.toggle('is-open'); 
        });
    } else {
        // Para fins de depuração, caso o problema persista
        console.error("ERRO JS: Elemento 'menuToggle' ou 'menuNav' não encontrado.");
    }
// =========================================
// Lógica para Validação do Formulário de Cadastro 
// =========================================
const formCadastro = document.getElementById('form-cadastro');

if (formCadastro) {
    const nomeInput = document.getElementById('cadastro-nome');
    const emailInput = document.getElementById('cadastro-email');
    const senhaInput = document.getElementById('cadastro-senha');

    const errorNome = document.getElementById('error-nome');
    const errorEmail = document.getElementById('error-email');
    const errorSenha = document.getElementById('error-senha');

    // Função para validar o nome
    const validarNome = () => {
        if (nomeInput.value.trim().length < 3) {
            errorNome.textContent = 'O nome deve ter pelo menos 3 caracteres.';
            return false;
        }
        errorNome.textContent = '';
        return true;
    };

    // Função para validar o e-mail
    const validarEmail = () => {
        const email = emailInput.value.trim();
        if (!email.includes('@') || !email.includes('.')) {
            errorEmail.textContent = 'Por favor, insira um e-mail válido.';
            return false;
        }
        errorEmail.textContent = '';
        return true;
    };

    // Função para validar a senha
    const validarSenha = () => {
        if (senhaInput.value.length < 8) {
            errorSenha.textContent = 'A senha deve ter pelo menos 8 caracteres.';
            return false;
        }
        errorSenha.textContent = '';
        return true;
    };

    // Adiciona "ouvintes" que são acionados enquanto o utilizador digita
    nomeInput.addEventListener('input', validarNome);
    emailInput.addEventListener('input', validarEmail);
    senhaInput.addEventListener('input', validarSenha);

    // Validação final ao tentar submeter o formulário
    formCadastro.addEventListener('submit', function(event) {
        // Roda todas as validações uma última vez
        const nomeValido = validarNome();
        const emailValido = validarEmail();
        const senhaValida = validarSenha();

        // Se qualquer uma for inválida, impede o envio
        if (!nomeValido || !emailValido || !senhaValida) {
            event.preventDefault();
        }
    });
} 

// =========================================
// Lógica para Validação do Formulário de Checkout 
// =========================================
const formCheckout = document.getElementById('form-checkout');

if (formCheckout) {
    // Seleciona todos os campos e locais para mensagens de erro
    const nomeInput = document.getElementById('checkout-nome');
    const emailInput = document.getElementById('checkout-email');
    const telefoneInput = document.getElementById('checkout-telefone');
    const ruaInput = document.getElementById('rua_entrega');

    const errorNome = document.getElementById('error-checkout-nome');
    const errorEmail = document.getElementById('error-checkout-email');
    const errorTelefone = document.getElementById('error-checkout-telefone');
    const errorRua = document.getElementById('error-checkout-rua');

    // --- Funções de Validação Individuais ---
    const validarNome = () => {
        if (nomeInput.value.trim().length < 3) {
            errorNome.textContent = 'O nome completo é obrigatório.';
            return false;
        }
        errorNome.textContent = '';
        return true;
    };

    const validarEmail = () => {
        if (!emailInput.value.trim().includes('@')) {
            errorEmail.textContent = 'Por favor, insira um e-mail válido.';
            return false;
        }
        errorEmail.textContent = '';
        return true;
    };

    const validarTelefone = () => {
        if (telefoneInput.value.trim().length < 9) {
            errorTelefone.textContent = 'Por favor, insira um telefone válido.';
            return false;
        }
        errorTelefone.textContent = '';
        return true;
    };

    const validarRua = () => {
        if (ruaInput.value.trim() === '') {
            errorRua.textContent = 'O campo rua é obrigatório.';
            return false;
        }
        errorRua.textContent = '';
        return true;
    };

    // --- Adiciona os "ouvintes" para validar em tempo real ---
    nomeInput.addEventListener('input', validarNome);
    emailInput.addEventListener('input', validarEmail);
    telefoneInput.addEventListener('input', validarTelefone);
    ruaInput.addEventListener('input', validarRua);

    // --- Validação Final ao Submeter ---
    formCheckout.addEventListener('submit', function(event) {
        // Roda todas as validações uma última vez para garantir
        const formularioValido = validarNome() && validarEmail() && validarTelefone() && validarRua();

        if (!formularioValido) {
            event.preventDefault(); // Impede o envio se algo estiver inválido
        }
    });
}

// =========================================
// Lógica para Validação do Formulário de Contacto 
// =========================================
const formContato = document.getElementById('form-contato');

if (formContato) {
    // Seleciona os campos e os locais para as mensagens de erro
    const nomeInput = document.getElementById('contato-nome');
    const emailInput = document.getElementById('contato-email');
    const assuntoInput = document.getElementById('contato-assunto');
    const mensagemInput = document.getElementById('contato-mensagem');

    const errorNome = document.getElementById('error-contato-nome');
    const errorEmail = document.getElementById('error-contato-email');
    const errorAssunto = document.getElementById('error-contato-assunto');
    const errorMensagem = document.getElementById('error-contato-mensagem');

    // --- Funções de Validação Individuais ---
    const validarNome = () => {
        if (nomeInput.value.trim() === '') {
            errorNome.textContent = 'O campo nome é obrigatório.';
            return false;
        }
        errorNome.textContent = '';
        return true;
    };

    const validarEmail = () => {
        if (!emailInput.value.trim().includes('@')) {
            errorEmail.textContent = 'Por favor, insira um e-mail válido.';
            return false;
        }
        errorEmail.textContent = '';
        return true;
    };

    const validarAssunto = () => {
        if (assuntoInput.value.trim() === '') {
            errorAssunto.textContent = 'O campo assunto é obrigatório.';
            return false;
        }
        errorAssunto.textContent = '';
        return true;
    };

    // --- Adiciona os "ouvintes" para validar em tempo real ---
    nomeInput.addEventListener('input', validarNome);
    emailInput.addEventListener('input', validarEmail);
    assuntoInput.addEventListener('input', validarAssunto);
    mensagemInput.addEventListener('input', validarMensagem);

    // --- Validação Final ao Submeter ---
    formContato.addEventListener('submit', function(event) {
        // Roda todas as validações uma última vez para garantir
        const formularioValido = validarNome() && validarEmail() && validarAssunto() && validarMensagem();

        if (!formularioValido) {
            event.preventDefault(); // Impede o envio se algo estiver inválido
        }
    });
}
});