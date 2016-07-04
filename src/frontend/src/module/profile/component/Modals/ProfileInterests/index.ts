import {Component, Input, EventEmitter, Output} from "angular2/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {ProfileRESTService} from "../../../service/ProfileRESTService";

@Component({
    selector: 'cass-profile-interests-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect,
        ProgressLock,
    ]
})
export class ProfileInterestsModal {
    private loading:boolean = false;
    private canSave:boolean = false;

    constructor(private profileRESTService: ProfileRESTService){
    }

    @Input('profile') entity:ProfileEntity;

    expertList = {
        theme_ids: []
    };
    interestList = {
        theme_ids: []
    };

    ngOnInit(){
        this.expertList.theme_ids = this.entity.expert_in_ids.slice(0);
        this.interestList.theme_ids = this.entity.interesting_in_ids.slice(0);
    }

    @Output('close') closeEvent:EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('success') successEvent:EventEmitter<boolean> = new EventEmitter<boolean>();

    saveChanges(){
        if(this.expertListChangeDetect() && this.interestListChangeDetect()) {
            this.profileRESTService.setExpertIn(this.entity.id, this.expertList).subscribe(data =>
                this.profileRESTService.setInterestingIn(this.entity.id, this.interestList).subscribe(data => {this.successEvent.emit(true)}));
        } else if(this.expertListChangeDetect()){
            this.profileRESTService.setExpertIn(this.entity.id, this.expertList).subscribe(data => {this.successEvent.emit(true)});
        } else if(this.interestListChangeDetect()){
            this.profileRESTService.setInterestingIn(this.entity.id, this.interestList).subscribe(data => {this.successEvent.emit(true)});
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
        return (this.expertList.theme_ids.sort().toString() !== this.entity.expert_in_ids.sort().toString());
    }

    interestListChangeDetect() {
        return (this.interestList.theme_ids.sort().toString() !== this.entity.interesting_in_ids.sort().toString());
    }
}