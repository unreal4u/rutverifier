/**
 * Validates a chilean RUT, returning a true if valid, false otherwise
 *
 * @param c
 * @returns {Boolean}
 */
function rutVerification(c) {
    'use strict';
    var isValid = false, d = c.value, formattedRut = d.replace(/\b[0-9kK]+\b/g, ''),
        rut = '', verifier = '', sum = 0, multi = 2, verifierResult = '0',
        numericVerifier = 0, i = 0, modulus = 0;
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
                c.value = rut.substring(0, 2) + '.' + rut.substring(2, 5) + '.' + rut.substring(5, 8) + '-' + verifierResult;
            }
        }
    }

    return isValid;
}
