import {Injectable} from "@angular/core";
import {UploadImageStrategy, UploadImageCropModel} from "./strategy";
import {UploadImageModal} from "./index";

@Injectable()
export class UploadImageService
{
    private strategy: UploadImageStrategy;

    public setUploadStrategy(strategy: UploadImageStrategy) {
        this.strategy = strategy;
    }

    public process(file: Blob, modal: UploadImageModal, model?: UploadImageCropModel) {
        if(!this.strategy) {
            throw new Error('No strategy available');
        }

        this.strategy.process(file, model, modal);
    }

    public abort(file: Blob, modal: UploadImageModal) {
        if(!this.strategy) {
            throw new Error('No strategy available');
        }

        this.strategy.abort(file, modal);
    }
}