import {Http, Response, Headers, RequestOptions} from 'angular2/http';
import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {RequestOptions} from "angular2/http";
import {RequestOptionsArgs} from "angular2/http";


@Injectable()
export class ChannelEditorService
{

    constructor(
        public router: Router
    ) {}

    public isCreateChannelFormVisible:boolean = false;

    public showCreateChannelForm() {
        this.router.navigate(['CreateChannel']);
        this.isCreateChannelFormVisible = true;
    }

    public hideCreateChannelForm() {
        this.router.navigate(['ChannelList']);
        this.isCreateChannelFormVisible = false;
    }
}