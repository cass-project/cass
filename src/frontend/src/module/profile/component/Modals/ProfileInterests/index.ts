import {Component, Input, EventEmitter, Output} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {ProfileModalModel} from "../ProfileModal/model";

@Component({
    selector: 'cass-profile-interests-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileInterestsModal {
    private loading:boolean = false;
    private canSave:boolean = false;

    constructor(private profileRESTService: ProfileRESTService, private model: ProfileModalModel){
    }

    @Output('close') closeEvent:EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('success') successEvent:EventEmitter<boolean> = new EventEmitter<boolean>();

    saveChanges(){
        if(this.expertListChangeDetect() && this.interestListChangeDetect()) {
            this.profileRESTService.setExpertIn(this.model.getProfileOriginal().id, this.model.profile.expert_in_ids).subscribe(data =>
                this.profileRESTService.setInterestingIn(this.model.getProfileOriginal().id, this.model.profile.interesting_in_ids).subscribe(data => {this.successEvent.emit(true)}));
        } else if(this.expertListChangeDetect()){
            this.profileRESTService.setExpertIn(this.model.getProfileOriginal().id, this.model.profile.expert_in_ids).subscribe(data => {this.successEvent.emit(true)});
        } else if(this.interestListChangeDetect()){
            this.profileRESTService.setInterestingIn(this.model.getProfileOriginal().id, this.model.profile.interesting_in_ids).subscribe(data => {this.successEvent.emit(true)});
        }

    }

    successModal(){
        this.successEvent.emit(true);
    }

    closeModal() {
        this.closeEvent.emit(true)
    }
    
    canSaveStatement(){
        return (this.expertListChangeDetect() || this.interestListChangeDetect());
    }

    expertListChangeDetect() {
        return (this.model.profile.expert_in_ids.sort().toString() !== this.model.getProfileOriginal().expert_in_ids.sort().toString());
    }

    interestListChangeDetect() {
        return (this.model.profile.interesting_in_ids.sort().toString() !== this.model.getProfileOriginal().interesting_in_ids.sort().toString());
    }
}