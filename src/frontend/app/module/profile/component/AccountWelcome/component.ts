import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {Modal} from "../../../common/component/Modal/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService
    ]})

export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService
    ){}

    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;
    avatar: string;

    chooseType: boolean = true;
    chooseFL: boolean = false;
    chooseLFM: boolean = false;
    chooseN: boolean = false;

    NextShow: boolean = false;
    SubmitShow: boolean = false;
    AvatarShow: boolean = false;


}