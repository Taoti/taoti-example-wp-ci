// https://howchoo.com/g/nwywodhkndm/how-to-turn-an-object-into-query-string-parameters-in-javascript


function jp_serialize(params){
    var queryString = Object.keys(params).map(function(key) {
        return key + '=' + params[key];
    }).join('&');

    return queryString;
}
