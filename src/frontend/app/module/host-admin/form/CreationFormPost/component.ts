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
    link: string;
    linkImg: string;
    linkLabel: string;
    linkText: string;
    showLinkInput: boolean = false;
    itsLink: boolean = false;

    constructor(
        private themeRESTService: ThemeRESTService,
        private themeEditorService: ThemeEditorService,
        public router: Router
    ){}

    detectURL(link, text){
       let detectURLregExp = /^(?:([a-z]+):(?:([a-z]*):)?\/\/)?(?:([^:@]*)(?::([^:@]*))?@)?((?:[a-z0-9_-]+\.)+[a-z]{2,}|localhost|(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])\.){3}(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])))(?::(\d+))?(?:([^:\?\#]+))?(?:\?([^\#]+))?(?:\#([^\s]+))?$/g;
        if(detectURLregExp.test(link)){
            //Test block
            this.linkImg = link;
            this.linkLabel = "Thumbnail label";
            this.linkText = "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.";
            return true;
        }
        if(detectURLregExp.test(text)){
            this.linkImg = text.match(detectURLregExp);
            return true;
        }
    }

    submit() {
        //this.themeRESTService //create post api request
        //this.themeRESTService //update post info
        //this.themeEditorService.showFormContentBox = false;
        //this.router.parent.navigate(['Theme-Cleaner']);
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