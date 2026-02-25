import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Brazilian input mask helpers
window.maskCpfCnpj = function (value) {
    value = value.replace(/\D/g, '').substring(0, 14);
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    }
    return value;
};

window.maskCnpj = function (value) {
    value = value.replace(/\D/g, '').substring(0, 14);
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
    return value;
};

window.maskPhone = function (value) {
    value = value.replace(/\D/g, '').substring(0, 11);
    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{4})(\d{1,4})$/, '$1-$2');
    } else {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
    }
    return value;
};

window.maskCep = function (value) {
    value = value.replace(/\D/g, '').substring(0, 8);
    value = value.replace(/(\d{5})(\d)/, '$1-$2');
    return value;
};

window.maskCurrency = function (value) {
    value = value.replace(/\D/g, '');
    if (!value) return '0,00';
    const num = parseInt(value) / 100;
    const parts = num.toFixed(2).split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return parts.join(',');
};

Alpine.start();
