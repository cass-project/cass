import {Component} from "angular2/core";
import {PostFormComponent} from "../../../post/form/PostForm/component/index";
import {RouteParams} from "angular2/router";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostFormComponent
    ]
})
export class ViewCollection
{
    private collectionId: number;

    constructor(private params: RouteParams) {
        this.collectionId = parseInt(params.get('collectionId'), 10);
    }
}