import {Injectable} from "angular2/core";
import {UploadImageCropModel} from "../../../../util/component/UploadImage/strategy";
import {CommunityEnityImage} from "../../../enity/Community";

@Injectable()
export class CommunitySettingsModalModel
{
    sid: string;
    title: string;
    description: string;
    public_options: CommunityPublicOptionsModel;
    theme_id: number;
    image: CommunityEnityImage;
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