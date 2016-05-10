// Extend the default Number object with a formatMoney() method:
// usage: someVar.formatMoney(symbol, decimalPlaces, thousandsSeparator, decimalSeparator)
// defaults: ('£', 2, ',', '.')
Number.prototype.formatMoney = function(symbol, places, thousand, decimal) {
    symbol   = symbol !== undefined ? symbol : '£';
    places   = !isNaN(places = Math.abs(places)) ? places : 2;
    thousand = thousand || ',';
    decimal  = decimal || '.';

    var number = this,
        negative = number < 0 ? '-' : '',
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + '',
        j = (j = i.length) > 3 ? j % 3 : 0,
        return_str = '';

    return_str += symbol;
    return_str += negative;
    return_str += (j ? i.substr(0, j) + thousand : '');
    return_str += i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousand);
    return_str += (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : '');

    return return_str.replace(/\.00/g, '');
};
