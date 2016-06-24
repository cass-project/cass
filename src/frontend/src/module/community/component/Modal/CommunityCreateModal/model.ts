import {Injectable} from "angular2/core";
import {UploadImageCropModel} from "../../../../form/component/UploadImage/strategy";

@Injectable()
export class CommunityCreateModalModel
{
    title: string="";
    sid: string;
    description: string="";
    theme_id: number;
    uploadImage: Blob;
    uploadImageCrop: UploadImageCropModel;
    features: CommunityFeaturesModel[]=[];
}

export class CommunityFeaturesModel
{
    code: string;
    is_activated: boolean = false;
    disabled: boolean = false;
}