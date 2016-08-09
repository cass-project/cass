import {Injectable} from "@angular/core";

import {UploadImageStrategy} from "./strategy";
import {UploadImageCropModel} from "./strategy";
import {UploadImageModal} from "./index";

@Injectable()
export class UploadImageService
{
    private strategy: UploadImageStrategy;

    public setUploadStrategy(strategy: UploadImageStrategy) {
        this.strategy = strategy;
    }

    public process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
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