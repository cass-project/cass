import {Component} from "angular2/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProgressBarDemo
{
    progress_d1: number = 0;
    progress_d2: number = 0;
    
    constructor() {
        setInterval(() => {
            if(this.progress_d1 === 100) {
                this.progress_d1 = 0;
            }else{
                ++this.progress_d1;
            }
        }, 50);

        setInterval(() => {
            if(this.progress_d2 === 100) {
                this.progress_d2 = 0;
            }else{
                this.progress_d2 += 10;
            }
        }, 200);
    }
}