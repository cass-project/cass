import {Component} from "angular2/core";
import {PostForm} from "../post/component/index";

@Component({
    template: require('./template.html'),
    directives: [
        PostForm
    ],
})
export class LandingComponent
{
    constructor(){}
}