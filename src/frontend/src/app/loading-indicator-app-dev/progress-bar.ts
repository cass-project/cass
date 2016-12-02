export class Loader
{
    private progressBar: any;
    private loader: any;
    private currentProgress: number = 0;

    constructor() {
        this.progressBar = document.getElementsByClassName('bar-complete')[0];
        this.loader = document.getElementsByClassName('yoozer-screen-loading')[0];
    }

    push(value: number) {
        this.currentProgress += value;
        this.setWidth(this.currentProgress);
    }

    done() {
        this.setWidth(100);
        this.loader.remove();
        this.loader = null;
        this.progressBar = null;
    }

    private setWidth(width: number) {
        this.progressBar.style.width = `${width}%`;
    }
}