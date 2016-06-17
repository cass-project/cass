import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";

export interface CommunityImageUploadRequestModel
{
    communityId: number;
    uploadImage: Blob;
    x1:number;
    y1:number;
    x2:number;
    y2:number;
}
