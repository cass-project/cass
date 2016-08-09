import {Injectable} from "@angular/core";
import {UploadImageCropModel} from "../../../../form/component/UploadImage/strategy";
import {ImageCollection} from "../../../../avatar/definitions/ImageCollection";

@Injectable()
export class CommunitySettingsModalModel
{
    id: number;
    sid: string;
    title: string;
    description: string;
    public_options: CommunityPublicOptionsModel;
    theme_id: number;
    image: ImageCollection;
    new_image: {
        uploadImage: Blob;
        uploadImageCrop: UploadImageCropModel;
    };
    features: CommunityFeaturesModel[]=[];
}

export class CommunityFeaturesModel
{
    code: string;
    is_activated: boolean = false;
    disabled: boolean = false;
}

export class CommunityPublicOptionsModel
{
    public_enabled: boolean;
    moderation_contract: boolean;
}