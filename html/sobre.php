<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa da Roça - Produtos Naturais</title>
    <link rel="stylesheet" href="/css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
        include 'cliente-header.php';
    ?>

    <main>
        <section class="slideshow-secao">
            <div class="slideshow-container">
                <div class="mySlides fade">
                    <img src="/img/produtos.jpg" style="width:100%" alt="Produtos frescos e orgânicos">
                    <div class="slideshow-caption">Qualidade e procedência dos produtos</div>
                </div>

                <div class="mySlides fade">
                    <img src="/img/alimentos-organicos.jpg" style="width:100%" alt="Visão da fazenda e produtores locais">
                    <div class="slideshow-caption">Valorização de produtores locais</div>
                </div>

                <div class="mySlides fade">
                    <img src="/img/geleias-e-compotas-1.jpg" style="width:100%" alt="Geleias e compotas artesanais">
                    <div class="slideshow-caption">Geleias e compotas artesanais</div>
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span> 
                <span class="dot" onclick="currentSlide(2)"></span> 
                <span class="dot" onclick="currentSlide(3)"></span> 
            </div>
        </section>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Sobre a Casa da Roça</h1>
            <p style="text-align: center; margin-bottom: 2rem;">A Casa da Roça está estruturando sua loja física e já atua há 1 ano e 7 meses no segmento de produtos naturais e alimentação saudável.</p>

            <div class="sobre-info-container">
                <div class="sobre-info-item">
                    <i class="fa-solid fa-seedling"></i>
                    <h2>Nossa Missão</h2>
                    <p>Levar produtos saudáveis, artesanais e de qualidade para clientes que querem ter um gostinho da roça dentro de casa.</p>
                </div>

                <div class="sobre-info-item">
                    <i class="fa-solid fa-chart-line"></i>
                    <h2>Nossa Visão</h2>
                    <p>Atingir o faturamento de 100 mil ao mês até 2027.</p>
                </div>

                <div class="sobre-info-item">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <h2>Nossos Valores</h2>
                    <ul>
                        <li><i class="fa-solid fa-award"></i> Qualidade e procedência dos produtos</li>
                        <li><i class="fa-solid fa-face-smile"></i> Atendimento e cuidado com o cliente</li>
                        <li><i class="fa-solid fa-leaf"></i> Consciência alimentar</li>
                        <li><i class="fa-solid fa-people-carry-box"></i> Valorização de produtores e fornecedores locais</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>

    <script src="/script.js"></script>
</body>
</html>