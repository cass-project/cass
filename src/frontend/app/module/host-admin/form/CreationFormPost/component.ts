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

 export class CreationFormPost{
    text: string;
    link:string;
    showLinkInput: boolean = false;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        public router: Router
    ){}

    submit() {
       // this.themeRESTService //create post api request
        // this.themeRESTService //update post info
        this.themeEditorService.showFormContentBox = false;
        this.router.parent.navigate(['Theme-Cleaner']);
    }
    reset(){
        this.router.parent.navigate(['Theme-Cleaner']);
        this.router.parent.navigate(['Creation-Form-Post']);
        this.themeEditorService.showFormContentBox = true;
    }

    close(){
        this.themeEditorService.showFormContentBox = false;
        this.router.parent.navigate(['Theme-Cleaner']);
    }
}