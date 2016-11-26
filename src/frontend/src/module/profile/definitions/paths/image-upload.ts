import {Success200} from "../../../common/definitions/common";
import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import { BackdropType } from "../../../backdrop/definitions/Backdrop";

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

export class UploadProfileBackdropImageRequest
{
    file: Blob;
    textColor: {
        code: string,
        hex_code: string;
    }
}

export interface UploadProfileImageProgress
{
    progress: number;
}

export interface UploadProfileBackdropImageResponse200 extends Success200
{
    backdrop: {
        type: BackdropType,
        metadata: {
            public_path: string,
            storage_path: string,
            text_color: {
                code: string,
                hex_code: string;
            }
        }
    }
}

export interface UploadProfileImageResponse200 extends Success200
{
    image: ImageCollection;
}