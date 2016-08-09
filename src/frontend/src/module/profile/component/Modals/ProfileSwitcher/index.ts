import {Component, Output, EventEmitter} from "@angular/core";
import {Router} from '@angular/router-deprecated';

import {ProfileImage} from "../../Elements/ProfileImage/index";
import {ComponentStages} from "../../../../common/classes/ComponentStages";
import {ProfileSwitcherService} from "./service";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";

enum ProfileSwitcherStage
{
    Choice = <any>"Choice",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-switcher',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        ProgressLock
    ]
})

export class ProfileSwitcher
{
    
    @Output('close') closeEvent = new EventEmitter<boolean>();
    stage: ComponentStages<ProfileSwitcherStage> = new ComponentStages<ProfileSwitcherStage>(ProfileSwitcherStage.Choice);

    constructor(private service: ProfileSwitcherService,
                private router: Router,
                private authService: AuthService           
    ) {}

    closeProfileSwitcher() {
       this.closeEvent.emit(true); 
    }

    signOut(){
        this.authService.signOut().subscribe(() => {
            this.closeProfileSwitcher();
            this.router.navigate(['Public']);
        });
    }
}