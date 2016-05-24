import {UploadImageModal} from "./index";

export interface UploadImageStrategy
{
    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal);
}

export interface UploadImageCropModel
{
    x: number;
    y: number;
    width: number;
    height: number;
}