# Integração com a API Charge do Pagseguro usando Laravel 7
Em andamento

## Compatibilidade
* PHP >= 7.2
* Laravel >= 7

## Instalação
.env
PAGSEGURO_ENV=sandbox
PAGSEGURO_API_VERSION=4.0
PAGSEGURO_EMAIL_SANDBOX=
PAGSEGURO_TOKEN_SANDBOX=
PAGSEGURO_ENDPOINT_SANDBOX=https://sandbox.api.pagseguro.com/
PAGSEGURO_EMAIL_PRODUCTION=
PAGSEGURO_TOKEN_PRODUCTION=
PAGSEGURO_ENDPOINT_PRODUCTION=https://api.pagseguro.com/
PAGSEGURO_PUBLIC_KEY=

## Funcionalidades
* [Cobrando com Boleto](https://dev.pagseguro.uol.com.br/v4.0/reference/cobranca-criando-uma-cobranca#cobrando-com-boleto-1)
* [Cobrando Cartão criptografado (Checkout Transparente)](https://dev.pagseguro.uol.com.br/v4.0/reference/cobranca-criando-uma-cobranca#cobrando-cartao-criptografado)
* [Recebendo mudanças de status](https://dev.pagseguro.uol.com.br/v4.0/reference/recebendo-mudan%C3%A7as-de-status)

## Packages adicionais
* [lucascudo/laravel-pt-BR-localization](https://github.com/lucascudo/laravel-pt-BR-localization)
* [igorescobar/jQuery-Mask-Plugin](https://github.com/igorescobar/jQuery-Mask-Plugin)
