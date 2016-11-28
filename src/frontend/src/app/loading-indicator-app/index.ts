import {Loader} from './progress-bar';
import {frontlineRequest, appRequest} from './requests';

let markup: string = require('./loader.html');
let style: string = require('./style.shadow.scss');

document.addEventListener('DOMContentLoaded', () => {
    let elementStyle: HTMLElement = document.createElement('style');

    elementStyle.innerHTML = style;
    elementStyle.setAttribute('type', 'text/css');
    document.getElementsByTagName('head')[0].appendChild(elementStyle);

    document.getElementsByClassName('yoozer-screen-loading')[0].innerHTML = markup;

    runLoader();
});

function runLoader(){
    let kFrontline: number = 14;
    let kApp: number = 80;
    let completeApp: number = 0;
    let completeFrontline: number = 0;

    let loader: Loader = new Loader();

    let appXHR: XMLHttpRequest = appRequest();
    let frontlineXHR: XMLHttpRequest = frontlineRequest();

    appXHR.addEventListener('load', appComplete);
    appXHR.addEventListener('progress', appProgress);

    frontlineXHR.addEventListener('load', frontlineComplete);
    frontlineXHR.addEventListener('progress', frontlineProgress);

    function appProgress(event: ProgressEvent) {
        let currentComplete = event.loaded / event.total;

        loader.push((currentComplete - completeApp) * kApp);
        completeApp = currentComplete;
    }

    function frontlineProgress(event: ProgressEvent) {
        let currentComplete = event.loaded / event.total;

        loader.push((currentComplete - completeFrontline) * kFrontline);
        completeFrontline = currentComplete;
    }

    function appComplete() {
        if(frontlineXHR.readyState === 4 && frontlineXHR.status === 200){
            appendApp()
        }
    }

    function frontlineComplete() {
        window['response_frontline'] = JSON.parse(frontlineXHR.responseText);
        if(appXHR.readyState === 4 && appXHR.status === 200){
            appendApp()
        }
    }

    function appendApp(){
        setTimeout(() => {
            let appElement: HTMLElement = document.createElement('script');

            appElement.setAttribute('type', 'text/javascript');
            appElement.innerHTML = appXHR.responseText;
            document.getElementsByTagName('head')[0].appendChild(appElement);

            loader.done();
        }, 100)
    }
}