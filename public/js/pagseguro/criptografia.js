function criptografar() {
    $(".is-invalid").removeClass("is-invalid");

    const PagSeguroPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+ZqgD892U9/HXsa7XqBZUayPquAfh9xx4iwUbTSUAvTlmiXFQNTp0Bvt/5vK2FhMj39qSv1zi2OuBjvW38q1E374nzx6NNBL5JosV0+SDINTlCG0cmigHuBOyWzYmjgca+mtQu4WczCaApNaSuVqgb8u7Bd9GCOL4YJotvV5+81frlSwQXralhwRzGhj/A57CGPgGKiuPT+AOGmykIGEZsSD9RKkyoKIoc0OS8CPIzdBOtTQCIwrLn2FxI83Clcg55W8gkFSOS6rWNbG5qFZWMll6yl02HtunalHmUlRUL66YeGXdMDC2PuRcmZbGO5a/2tbVppW6mfSWG3NPRpgwIDAQAB';

    var card = PagSeguro.encryptCard({
        publicKey: PagSeguroPublicKey,
        holder: $('#card_holder').val(),
        number: $('#card_number').cleanVal(),
        expMonth: $('#card_month').val(),
        expYear: $('#card_year').val(),
        securityCode: $('#card_cvv').val(),
    });

    /* Necessário porque o sdk não retorna erro para cvv vazio */
    if ($('#card_cvv').val() != '') {
        var encrypted = card.encryptedCard;
    } else {
        $('#card_cvv').addClass('is-invalid');
    }
    /* ----------------------------------------------------- */

    card.errors.map(function (error) {
        switch (error.code) {
            case "INVALID_HOLDER":
                $('#card_holder').addClass('is-invalid');
                break;

            case "INVALID_NUMBER":
                $('#card_number').addClass('is-invalid');
                break;

            case "INVALID_EXPIRATION_MONTH":
                $('#card_month').addClass('is-invalid');
                break;

            case "INVALID_EXPIRATION_YEAR":
                $('#card_year').addClass('is-invalid');
                break;

            case "INVALID_SECURITY_CODE":
                $('#card_cvv').addClass('is-invalid');
                break;
        }
    });

    return encrypted;
}