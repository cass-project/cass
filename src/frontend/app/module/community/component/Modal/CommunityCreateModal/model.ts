import {Injectable} from "angular2/core";
import {UploadImageCropModel} from "../../../../util/component/UploadImage/strategy";

@Injectable()
export class CommunityCreateModalModel
{
    title: string = '';
    description: string = '';
    theme_id: number;
    uploadImage: Blob;
    uploadImageCrop: UploadImageCropModel;
}