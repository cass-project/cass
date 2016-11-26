import {Component, Input} from "@angular/core";

import {Backdrop, BackdropType} from "../../../definitions/Backdrop";
import {BackdropPresetMetadata} from "../../../definitions/metadata/BackdropPresetMetadata";
import {BackdropUploadMetadata} from "../../../definitions/metadata/BackdropUploadMetadata";

@Component({
    selector: 'cass-backdrop-preview',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class BackdropPreview
{
    @Input('sample-text') sampleText: string = '';
    @Input('sample-color') sampleColor: string = '#ffffff';
    @Input('backdrop') backdrop: Backdrop<any>;

    private is = {
        None: () => { return this.backdrop.type === BackdropType.None },
        Color: () => { return this.backdrop.type === BackdropType.Color },
        Preset: () => { return this.backdrop.type === BackdropType.Preset },
        Uploaded: () => { return this.backdrop.type === BackdropType.Uploaded },
    };

    private getBackdropImage(): string
    {
        return this.backdrop.metadata.public_path;
    }
}