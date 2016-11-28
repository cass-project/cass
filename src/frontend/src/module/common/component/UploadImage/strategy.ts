import {UploadImageModal} from "./index";

export interface UploadImageStrategy
{
    getCropperOptions(): any;
    abort(file: Blob, modal: UploadImageModal);
    process(file: Blob, model: any, modal: UploadImageModal);
}

export interface UploadImageCropModel
{
    x: number;
    y: number;
    width: number;
    height: number;
}