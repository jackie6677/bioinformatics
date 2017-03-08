

function initSlimHash (url) {
    var slim_hash = {};
    var request = new XMLHttpRequest();
    request.open('GET', url, false);  // `false` makes the request synchronous
    request.send(null);

    if (request.status === 200) {
        slim_hash = JSON.parse(request.responseText);
    }
    return slim_hash;
}

function returnStarIfSlim(go, slim) {
    if (go in slim) {
        return "*";
    }
    return "";
}