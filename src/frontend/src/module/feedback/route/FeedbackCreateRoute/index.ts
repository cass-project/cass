import {Component} from "angular2/core";
import {RouteParams, Router} from "angular2/router";
import {FeedbackCreateModal} from "../../component/Modal/FeedbackCreateModal/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        FeedbackCreateModal
    ]
})

export class FeedbackCreateRoute
{
    constructor (
        private routeParams: RouteParams
    ){
        //this.routeParams.get("type");
    }

}