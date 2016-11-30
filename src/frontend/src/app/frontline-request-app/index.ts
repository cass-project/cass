let xhr: XMLHttpRequest = new XMLHttpRequest();
let apiKey = window.localStorage['api_key'];

xhr.open('GET', '/backend/api/frontline/*/', false);
xhr.setRequestHeader('Authorization', apiKey);
xhr.send();

xhr.addEventListener('load', () => {
    window['response_frontline'] = JSON.parse(xhr.responseText);
});