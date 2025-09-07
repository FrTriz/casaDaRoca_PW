document.addEventListener('DOMContentLoaded', () => {

    // =========================================
    // Lógica para o Pop-up de Adicionar ao Carrinho
    // =========================================
    const botoesCarrinho = document.querySelectorAll('.botao-adicionar-carrinho');
    const popupOverlay = document.getElementById('popup-confirmacao');
    const popupClose = document.querySelector('.popup-close');
    const popupMessage = document.getElementById('popup-message');

    // Adiciona um "ouvinte" de evento de clique a cada botão
    if (botoesCarrinho.length > 0) {
        botoesCarrinho.forEach(botao => {
            botao.addEventListener('click', function(event) {
                event.preventDefault(); // Impede o link de navegar
                
                // Pega o nome do produto do atributo 'data-produto'
                const nomeProduto = this.getAttribute('data-produto');
                
                // Atualiza a mensagem do pop-up
                if (popupMessage) {
                    popupMessage.textContent = `"${nomeProduto}" foi adicionado com sucesso ao seu carrinho.`;
                }
                
                // Torna o pop-up visível
                if (popupOverlay) {
                    popupOverlay.style.display = 'flex';
                }
            });
        });
    }

    // Adiciona um ouvinte para fechar o pop-up ao clicar no 'X'
    if (popupClose) {
        popupClose.addEventListener('click', () => {
            if (popupOverlay) {
                popupOverlay.style.display = 'none';
            }
        });
    }

    // Adiciona um ouvinte para fechar o pop-up ao clicar fora dele
    if (popupOverlay) {
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

        // Fecha o modal se o usuário clicar fora dele
        document.addEventListener('click', (event) => {
            if (!userIcon.contains(event.target) && !userModal.contains(event.target)) {
                userModal.classList.remove('active');
            }
        });
    }

    // =========================================
    // Lógica para Alternar Formulários de Login/Cadastro (na página de login)
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
});