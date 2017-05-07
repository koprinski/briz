// ID checking method
function checkEgn(egn) {
    if (egn.length != 10)
        return false;
    if (/[^0-9]/.test(egn))
        return false;
    var year = Number(egn.slice(0, 2));
    var month = Number(egn.slice(2, 4));
    var day = Number(egn.slice(4, 6));
    
    if (month >= 40) {
        year += 2000;
        month -= 40;
    } else if (month >= 20) {
        year += 1800;
        month -= 20;
    } else {
        year += 1900;
    }
    
    if (!isValidDate(year, month, day))
        return false;
    
    var checkSum = 0;
    var weights = [2,4,8,5,10,9,7,3,6];
    
    for (var ii = 0; ii < weights.length; ++ii) {
        checkSum += weights[ii] * Number(egn.charAt(ii));
    }
    
    checkSum %= 11;
    checkSum %= 10;
    
    if (checkSum !== Number(egn.charAt(9)))
        return false;
        
    return true;
    
}
//Date validation
function isValidDate(y, m, d) {
  var date = new Date(y, m - 1, d);
  return date && (date.getMonth() + 1) == m && date.getDate() == Number(d);
} 

function doCheckEgn() {
    var result = checkEgn(document.getElementById("egn-box").value);

    window.alert(result);
    
}