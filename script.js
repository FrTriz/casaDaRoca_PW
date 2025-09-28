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
});