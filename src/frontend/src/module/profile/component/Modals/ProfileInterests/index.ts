import {Component, EventEmitter, Output} from "@angular/core";

import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {ProfileModalModel} from "../ProfileModal/model";
import {Observable} from "rxjs/Rx";

@Component({
    selector: 'cass-profile-interests-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileInterestsModal
{
    private loading: boolean = false;
    private canSave: boolean = false;

    constructor(
        private profileRESTService: ProfileRESTService,
        private model: ProfileModalModel
    ) {}

    @Output('close') closeEvent:EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('success') successEvent:EventEmitter<boolean> = new EventEmitter<boolean>();

    saveChanges() {
        let profileId = this.model.getProfileOriginal().id;
        let expertInIds = this.model.profile.expert_in_ids;
        let interestingInIds = this.model.profile.interesting_in_ids;

        Observable.forkJoin([
            this.profileRESTService.setExpertIn(profileId, expertInIds),
            this.profileRESTService.setInterestingIn(profileId, interestingInIds)
        ]).subscribe(success => {
            this.successEvent.emit(true);
        }, error => {});
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