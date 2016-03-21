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
    imgLink: string;
    textLink:string;
    showLinkInput: boolean = false;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        public router: Router
    ){}

    detectURL(link, text){
       var regExp = /^(?:([a-z]+):(?:([a-z]*):)?\/\/)?(?:([^:@]*)(?::([^:@]*))?@)?((?:[a-z0-9_-]+\.)+[a-z]{2,}|localhost|(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])\.){3}(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])))(?::(\d+))?(?:([^:\?\#]+))?(?:\?([^\#]+))?(?:\#([^\s]+))?$/i
    return regExp.test(link) ||  regExp.test(text);
    }

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