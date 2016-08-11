import {Injectable} from "@angular/core";
import {UploadImageCropModel} from "../../../../form/component/UploadImage/strategy";
import {ImageCollection} from "../../../../avatar/definitions/ImageCollection";
import {CommunityFeatureEntity} from "../../../../community-features/definitions/entity/CommunityFeature";
import {EditCommunityRequest} from "../../../definitions/paths/edit";
import {SetPublicOptionsCommunityRequest} from "../../../definitions/paths/set-public-options";
import {CommunityActivateFeatureRequest} from "../../../../community-features/definitions/paths/activate";

@Injectable()
export class CommunitySettingsModalModel
{
    id: number;
    sid: string;
    title: string;
    description: string;
    public_options: {
        public_enabled: boolean;
        moderation_contract: boolean;
    };
    theme_id: number;
    image: ImageCollection;
    new_image: {
        uploadImage: Blob;
        uploadImageCrop: UploadImageCropModel;
    };
    features: CommunityFeatureEntity[]=[];

    editCommunityRequest(): EditCommunityRequest {
        return {
            title: this.title,
            description: this.description,
            theme_id: this.theme_id
        };
    }

    setPublicOptionsCommunityRequest(): SetPublicOptionsCommunityRequest {
        return {
            public_enabled: this.public_options.public_enabled,
            moderation_contract: this.public_options.moderation_contract
        }
    }

    communityActivateFeatureRequest(feature): CommunityActivateFeatureRequest {
        return {
            communityId: this.id,
            feature: feature.code
        }
    }
}