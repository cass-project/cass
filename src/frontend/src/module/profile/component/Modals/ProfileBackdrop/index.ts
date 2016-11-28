import {Component, Input, Output, EventEmitter, OnInit} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {Backdrop} from "../../../../backdrop/definitions/Backdrop";
import {ChangeBackdropModel} from "../../../../backdrop/component/Form/ChangeBackdropForm/model";
import { ProfileRESTService } from "../../../service/ProfileRESTService";
import {Session} from "../../../../session/Session";
import { LoadingManager } from "../../../../common/classes/LoadingStatus";
import { UploadProfileBackdropImageRequest } from "../../../definitions/paths/image-upload";
import { ProfileHeader } from "../../Elements/ProfileHeader/index";

@Component({
    selector: 'cass-profile-backdrop-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ChangeBackdropModel
    ]
})
export class ProfileBackdrop implements OnInit
{
    @Input('profile') profile: ProfileEntity;
    @Output('close') closeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('complete') completeEvent: EventEmitter<Backdrop<any>> = new EventEmitter<Backdrop<any>>();

    private request: UploadProfileBackdropImageRequest = new UploadProfileBackdropImageRequest();

    private status: LoadingManager = new LoadingManager();

    constructor(private model: ChangeBackdropModel,
                private profileRESTService: ProfileRESTService,
                private session: Session

    ) {}
    
    completeChangeImageBackdrop(event){
        this.request = event;
    }
    
    changeTextColorBackdrop(event){
        this.request.textColor = event;
    }

    isLoading(): boolean {
        return this.status.isLoading();
    }

    ngOnInit() {
        this.model.exportBackdrop(this.profile.backdrop);
        this.model.exportSampleText(this.profile.greetings.greetings);
        this.model.exportProfile(this.profile);
    }
    
    save(){
        let loading = this.status.addLoading();
        this.profileRESTService.imageBackdropUpload(this.profile.id, this.request).subscribe(response => {
            this.session.getCurrentProfile().entity.profile.backdrop = response.backdrop;
            loading.is = false;
            this.close();
        }, error => {
            loading.is = false;
        });
    }

    close() {
        this.closeEvent.emit(true);
    }
}