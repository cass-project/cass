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
    changeParentDir: boolean = false;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        public router: Router
    ){}
    submit() {
        if (this.themeEditorService.theme.parent_id && !this.parent) {
            this.parent = this.themeEditorService.theme.parent_id;
        }
        this.themeRESTService.updateTheme(this.themeEditorService.selectedThemeId, this.title, this.parent).subscribe(
            data => {
                this.themeEditorService.updateInfoOnPage();
                this.router.parent.navigate(['RouterCleaner']);
            },
            err => {
                console.log(err);
            }
        );
    }
    close(){
        this.themeEditorService.showFormContentBox = false;
        this.router.parent.navigate(['RouterCleaner']);
    }
}