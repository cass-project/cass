import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from "@angular/router";

import {ProfileImage} from "../../../../profile/component/Elements/ProfileImage/index";
import {ContactEntity} from "../../../../contact/definitions/entity/Contact";
import {ContactService} from "../../../../contact/service/ContactService";

@Component({
    selector: 'cass-profile-im-sidebar',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        ROUTER_DIRECTIVES,
        ProfileImage
    ]
})

export class ProfileIMSidebar
{
    private isVisible:boolean;
    private isLoading = true;
    private contacts:ContactEntity[];

    constructor(private contactService:ContactService) {
        contactService.listContacts().subscribe(
            
            data => {
                this.contacts = data.entities;
                this.isLoading = false;
            }
        );
    }
    
    toggleState() {
        this.isVisible = !this.isVisible;
    }
}