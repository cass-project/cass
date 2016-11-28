export function frontlineRequest(): XMLHttpRequest{
    let xhr: XMLHttpRequest = new XMLHttpRequest();
    let apiKey = window.localStorage['api_key'];

    xhr.open('GET', '/backend/api/frontline/*/', true);
    xhr.setRequestHeader('Authorization', apiKey);
    xhr.send();

    return xhr
}

export function appRequest(): XMLHttpRequest{
    let xhr: XMLHttpRequest = new XMLHttpRequest();

    xhr.open('GET', '/dist/bundles/main.js', true);
    xhr.send();

    return xhr
}