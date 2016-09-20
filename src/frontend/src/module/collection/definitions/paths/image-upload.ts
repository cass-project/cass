import {Success200} from "../../../common/definitions/common";
import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface UploadCollectionImageRequest
{
    file: Blob;
    crop: {
        x1: number;
        y1: number;
        x2: number;
        y2: number;
    }
}

export interface UploadCollectionImageProgress
{
    progress: number;
}

export interface UploadCollectionImageResponse200 extends Success200
{
    image: ImageCollection;
}