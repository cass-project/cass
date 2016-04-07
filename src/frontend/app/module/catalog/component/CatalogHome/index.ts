import {Component} from "angular2/core";
import {WorkInProgress} from "../../../common/component/WorkInProgress/index";

@Component({
    template: require('./template.html'),
    directives: [
        WorkInProgress
    ]
})
export class CatalogHomeComponent {}