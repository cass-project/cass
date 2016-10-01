import {AttachmentMetadata} from "../AttachmentEntity";

export interface ImageAttachmentMetadata extends AttachmentMetadata {
    preview: string;
}