function rutVerification(c) {
    "use strict";
    var r = false, d = c.value, t = d.replace(/\b[0-9kK]+\b/g, ''), a = '', b = '', s = 0, m = 2, x = '0', e = 0, i = 0, y = 0;
    if (t.length === 8) {
        t = '0' + t;
    }

    if (t.length === 9) {
        a = t.substring(t.length - 1, -1);
        b = t.charAt(t.length - 1);
        if (b === 'k') {
            b = 'K';
        }

        if (!isNaN(a)) {
            for (i = a.length - 1; i >= 0; i -= 1) {
                s = s + a.charAt(i) * m;
                if (m === 7) {
                    m = 2;
                } else {
                    m += 1;
                }
            }
            y = s % 11;

            if (y === 1) {
                x = 'K';
            } else {
                if (y === 0) {
                    x = '0';
                } else {
                    e = 11 - y;
                    x = e.toString();
                }
            }

            if (x === b) {
                r = true;
                c.value = a.substring(0, 2) + '.' + a.substring(2, 5) + '.'
                        + a.substring(5, 8) + '-' + b;
            }
        }
    }

    return r;
}
