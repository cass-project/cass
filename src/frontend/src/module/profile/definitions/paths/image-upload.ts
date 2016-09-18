import {Success200} from "../../../common/definitions/common";
import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface UploadProfileImageRequest
{
    file: Blob;
    crop: {
        x1: number;
        y1: number;
        x2: number;
        y2: number;
    }
}

export interface UploadProfileImageProgress
{
    progress: number;
}

export interface UploadProfileImageResponse200 extends Success200
{
    image: ImageCollection;
}