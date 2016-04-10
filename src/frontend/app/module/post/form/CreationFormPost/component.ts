import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {PostRestService} from "../../service/PostRestService";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'directives': [
        ROUTER_DIRECTIVES
    ],
    'providers': [
        PostRestService
    ]
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
        private postRESTService: PostRestService,
        public router: Router
    ){}

    detectURL(link, text){
       let detectURLregExp = /^(?:([a-z]+):(?:([a-z]*):)?\/\/)?(?:([^:@]*)(?::([^:@]*))?@)?((?:[a-z0-9_-]+\.)+[a-z]{2,}|localhost|(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])\.){3}(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])))(?::(\d+))?(?:([^:\?\#]+))?(?:\?([^\#]+))?(?:\#([^\s]+))?$/g;
        if(detectURLregExp.test(link)){
            //ToDo: after rest-api finish, rework this block;
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
        this.postRESTService.createPost(this.text).subscribe(data => {
            //this.themeRESTService //update post's info
            this.close();
        });
    }
    reset(){
        this.router.parent.navigate(['RouterCleaner']);
        this.router.parent.navigate(['Creation-Form-Post']);
    }

    close(){
        this.router.parent.navigate(['RouterCleaner']);
    }
}