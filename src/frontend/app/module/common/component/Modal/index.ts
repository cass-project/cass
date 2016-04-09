import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';


@Injectable()
export class Modal
{

    showFormContentBox: boolean = false;

    constructor(public router: Router) {
    }

    //public updateInfoOnPage(){
    //    this.themeRESTService.getThemesTree().map(res => res.json()).subscribe(data => this.themesTree = data['entities']);
    //    this.themeRESTService.getThemes().map(res => res.json()).subscribe(data => this.themes = data['entities']);
    //    this.showFormContentBox = false;
    //}


}