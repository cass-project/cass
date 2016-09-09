import {Component} from "@angular/core";

import {ContactEntity} from "../../../../contact/definitions/entity/Contact";
import {ContactService} from "../../../../contact/service/ContactService";
import {ProfileImage} from "../../../../profile/component/Elements/ProfileImage/index";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileIMContacts
{
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
}