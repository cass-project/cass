import {Component} from 'angular2/core';
import {ThemeRESTService} from  '../../../theme/service/ThemeRESTService';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';

@Component({
    styles: [
        require('./style.shadow.scss')
    ],
    template: require('./template.html')
})
export class UpdateThemeForm
{
    title: string;
    parent: string;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        public router: Router
    ){}
    submit() {
        this.themeRESTService.updateTheme(this.themeEditorService.selectedThemeId, this.title, this.parent);
        //this.themeRESTService.getThemesTree().map(res => res.json()).subscribe(data => this.themeEditorService.themesTree = data['entities']);
        //this.themeEditorService.showFormContentBox = false;
        this.router.parent.navigate(['Theme-Editor']);
    }
}