import {Backdrop, BackdropType} from "../definitions/Backdrop";
import {BackdropColorMetadata} from "../definitions/metadata/BackdropColorMetadata";
import {BackdropPresetMetadata} from "../definitions/metadata/BackdropPresetMetadata";
import {BackdropUploadMetadata} from "../definitions/metadata/BackdropUploadMetadata";

export function getBackdropTextColor(backdrop: Backdrop<any>)
{
    switch(backdrop.type) {
        default:
            throw new Error(`Unknown backdrop type ${backdrop.type}`);
        case BackdropType.None:
            return '#ffffff';
        case BackdropType.Color:
            return (<BackdropColorMetadata>backdrop.metadata).palette.foreground.hexCode;
        case BackdropType.Preset:
            return (<BackdropPresetMetadata>backdrop.metadata).text_color;
        case BackdropType.Uploaded:
            return (<BackdropUploadMetadata>backdrop.metadata).text_color;
    }
}