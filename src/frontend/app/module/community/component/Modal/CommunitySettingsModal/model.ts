import {Injectable} from "angular2/core";
import {UploadImageCropModel} from "../../../../util/component/UploadImage/strategy";

@Injectable()
export class CommunitySettingsModalModel
{
    title: string;
    description: string;
    public_options: CommunityPublicOptionsModel;
    theme_id: number;
    uploadImage: Blob;
    uploadImageCrop: UploadImageCropModel;
    features: CommunityFeaturesModel[];
}

export class CommunityFeaturesModel
{
    code: string;
    is_activated: boolean = false;
    disabled: boolean = false;
}

export class CommunityPublicOptionsModel
{
    code: string;
    is_activated: boolean = false;
    disabled: boolean = false;
}