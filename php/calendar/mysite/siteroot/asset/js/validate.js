function validDate(date) {
    var reg = /^(\d{4}(-\d{2}){2} \d{2}(:\d{2}){2})$/;
    return date.match(reg) != null;
}