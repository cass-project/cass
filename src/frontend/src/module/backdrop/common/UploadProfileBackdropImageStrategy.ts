import {Observable} from "rxjs/Rx";
import { EventEmitter } from "@angular/core";
import {UploadImageStrategy, UploadImageCropModel} from "../../common/component/UploadImage/strategy";
import {UploadImageModal} from "../../common/component/UploadImage/index";
import {
	UploadProfileImageProgress,
	UploadProfileImageResponse200,
	UploadProfileBackdropImageResponse200
} from "../../profile/definitions/paths/image-upload";
import { ProfileEntity } from "../../profile/definitions/entity/Profile";
import { ProfileRESTService } from "../../profile/service/ProfileRESTService";
import { ChangeBackdropModel } from "../component/Form/ChangeBackdropForm/model";


export class UploadProfileBackdropImageStrategy implements UploadImageStrategy
{
	public request: any;
	
	constructor(
		private model: ChangeBackdropModel,
	    private event: EventEmitter<any>
	) {}
	
	getCropperOptions() {
		return {
			aspectRatio: 1 /* 1/1 */,
			viewMode: 2 /* VM3 */,
			background: false,
			center: true,
			highlight: false,
			guides: false,
			movable: true,
			minCropBoxWidth: 150,
			minCropBoxHeight: 150,
			rotatable: false,
			scalable: false,
			toggleDragModeOnDblclick: false,
			zoomable: true,
			minContainerWidth: 500,
			minContainerHeight: 500
		};
	}
	
	abort(file: Blob, modal: UploadImageModal) {
		modal.progress.abort();
	}
	
	process(file: Blob, model: any, modal: UploadImageModal) {
		this.request = {
			file: file,
			textColor: this.model.textColor
		};
		this.event.emit(this.request);
		modal.close();
	}
}