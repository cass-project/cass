import {Component} from 'angular2/core';
import {ThemeRESTService} from  '../../../theme/service/ThemeRESTService';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {Modal} from "../../../common/component/Modal/index";


@Component({
    styles: [
        require('./style.shadow.scss')
    ],
    template: require('./template.html'),
})
export class CreateThemeForm
{
    title: string;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        private modal: Modal,
        public router: Router
    ){}
    submit() {
        if(this.themeEditorService.createFirstParent){
            this.themeEditorService.clear();
            this.themeEditorService.createFirstParent = false;
        }
        this.themeRESTService.createTheme(this.title, this.themeEditorService.selectedThemeId).subscribe(
            data => {
                this.themeEditorService.updateInfoOnPage();
                this.router.parent.navigate(['RouterCleaner']);
            },
            err => {console.log(err)});
    }
    close(){
        this.modal.showFormContentBox = false;
        this.router.parent.navigate(['RouterCleaner']);
    }
}