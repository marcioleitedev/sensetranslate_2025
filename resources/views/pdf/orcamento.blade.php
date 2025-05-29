<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 80px;
        }

        .content {
            margin-top: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" class="logo">
        <h2>Orçamento para Serviços de Cidadania Italiana - Família STOPPA</h2>
    </header>

    <div class="content">
        <p class="section-title">Nota Importante sobre Certidões:</p>
        <p>Todas as certidões solicitadas neste orçamento devem ser de inteiro teor.</p>
        <p><strong>O que é uma Certidão de Inteiro Teor:</strong> Uma Certidão de Inteiro Teor é um documento oficial
            que contém todas as informações registradas no assento original do registro civil. Diferentemente de uma
            certidão comum (ou resumida), que apresenta apenas os dados básicos, a certidão de inteiro teor inclui:</p>
        <ol>
            <li>Todas as anotações e observações feitas à margem do registro original.</li>
            <li>Informações completas sobre os pais, avós, testemunhas, etc.</li>
            <li>Quaisquer retificações, averbações ou alterações feitas no registro ao longo do tempo.</li>
            <li>Detalhes específicos do evento (nascimento, casamento ou óbito) que podem ser relevantes para o processo
                de cidadania.</li>
        </ol>
        <p><strong>Por que são necessárias:</strong></p>
        <ol>
            <li>Fornecem informações detalhadas que são essenciais para comprovar a linha de descendência.</li>
            <li>Permitem verificar a existência de anotações importantes, como reconhecimento de paternidade, adoções,
                ou alterações de nome.</li>
        </ol>

        <p class="section-title">PARTE I: DOCUMENTAÇÃO, TRADUÇÕES E ENVIO</p>

        <div>
            {!! $content !!}
        </div>

        <div>
            <p><strong>Bruno Santos Projetos</strong></p>
            <ul>
                <li>Tel.: +55 11 9 5059-0525</li>
                <li>e-mail: bruno@sensetranslate.com</li>
                <li>https://www.facebook.com/Sensetranslate/</li>
                <li>https://www.linkedin.com/company/sense-translate </li>
                <li>https://www.linkedin.com/in/bruno-santos-01062b1a5/</li>
                <li>https://www.sensetranslate.com</li>
            </ul>


        </div>
    </div>
</body>

</html>
