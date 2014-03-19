/**
 * Validates a chilean RUT, returning a true if valid, false otherwise
 *
 * @param c
 * @returns {Boolean}
 */
function rutVerification(originalInput) {
    'use strict';
    var isValid = false, formattedRut = '', rut = '', verifier = '', sum = 0,
        multi = 2, verifierResult = '0', numericVerifier = 0, i = 0, modulus = 0;

    if (typeof originalInput === 'string') {
        formattedRut = originalInput.replace(/[^0-9K]/gi, '');
        if (formattedRut.length === 8) {
            formattedRut = '0' + formattedRut;
        }

        if (formattedRut.length === 9) {
            rut = formattedRut.substring(formattedRut.length - 1, -1);
            verifier = formattedRut.charAt(formattedRut.length - 1);
            if (verifier === 'k') {
                verifier = 'K';
            }

            if (!isNaN(rut)) {
                for (i = rut.length - 1; i >= 0; i -= 1) {
                    sum += rut.charAt(i) * multi;
                    if (multi === 7) {
                        multi = 2;
                    } else {
                        multi += 1;
                    }
                }
                modulus = sum % 11;

                if (modulus === 1) {
                    verifierResult = 'K';
                } else {
                    if (modulus === 0) {
                        verifierResult = '0';
                    } else {
                        numericVerifier = 11 - modulus;
                        verifierResult = numericVerifier.toString();
                    }
                }

                if (verifierResult === verifier) {
                    isValid = true;
                }
            }
        }
    }

    return isValid;
}
