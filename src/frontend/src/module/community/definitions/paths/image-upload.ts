import {Success200} from "../../../common/definitions/common";

import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface UploadCommunityImageRequest
{
    file: Blob;
    crop: {
        x1: number;
        y1: number;
        x2: number;
        y2: number;
    }
}

export interface UploadCommunityImageProgress
{
    progress: number;
}

export interface UploadCommunityImageResponse200 extends Success200
{
    image: ImageCollection;
}