import {Component, Input, Output, EventEmitter} from "@angular/core";
import {ChangeBackdropModel} from "../../model";
import {Backdrop} from "../../../../../definitions/Backdrop";
import { UploadImageService } from "../../../../../../common/component/UploadImage/service";
import { ModalControl } from "../../../../../../common/classes/ModalControl";
import { UploadProfileImageStrategy } from "../../../../../../profile/common/UploadProfileImageStrategy";
import { UploadProfileBackdropImageStrategy } from "../../../../../common/UploadProfileBackdropImageStrategy";
import { ProfileRESTService } from "../../../../../../profile/service/ProfileRESTService";

@Component({
    selector: 'cass-change-backdrop-cmp-image-settings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ],
    providers: [
        UploadImageService,
    ]
})
export class ImageSettings
{
    private backdrop: Backdrop<any>;
    
    @Output('submit') submit: EventEmitter<any> = new EventEmitter<any>();
    @Output('updateTextColor') updateTextColor: EventEmitter<any> = new EventEmitter<any>();
    
    upload: ModalControl = new ModalControl();

    constructor(
        private model: ChangeBackdropModel,
        private uploadImageService: UploadImageService
    ) {
        this.backdrop = model.backdrop;
        console.log(model);
        uploadImageService.setUploadStrategy(new UploadProfileBackdropImageStrategy(model, this.submit));
    }
    
    uploadBackdropImage(){
        this.upload.open();
    }

    updateTextColorEvent(event){
        this.model.setTextColor(event);
        this.updateTextColor.emit(event);
    }

    updateBackdropImage(event){
        this.backdrop.metadata.public_path = window.URL.createObjectURL(event);
        this.upload.close();
    }

    getBackdrop() {
        return this.model.backdrop;
    }
}