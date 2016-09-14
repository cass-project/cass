import {Component, Directive} from "@angular/core";
import {ProfileImage} from "../../../../profile/component/Elements/ProfileImage/index";
import {ContactEntity} from "../../../../contact/definitions/entity/Contact";
import {ContactService} from "../../../../contact/service/ContactService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-im-sidebar'})


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