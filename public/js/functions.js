/**
 * General JS functions
 */

/**
 * jQuery hasAttr checking to see if there is an attribute on an element
 * @param name
 * @returns {boolean}
 */
$.fn.hasAttr = function (name) {
    var attr = this.attr(name);
    return (typeof attr !== typeof undefined && attr !== false);
};

/**
 * if if element has the attribute, the attribute's value will be returned, otherwise the  default_value  will be returned
 * @param attr
 * @param default_value
 * @returns {*}
 */
$.fn.useAttrElse = function (attr, default_value) {
    if (this.hasAttr(attr)) {
        return this.attr(attr);
    }
    return default_value;
};

/**
 * convert persian digits to english digits
 * @returns {String}
 */
String.prototype.toEnglishDigit = function () {
    var find = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    var replace = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

/**
 * convert english digits to persian digits
 * @returns {string}
 */
String.prototype.toPersianDigit = function () {
    var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return this.replace(/[0-9]/g, function (w) {
        return id[+w]
    });
}
