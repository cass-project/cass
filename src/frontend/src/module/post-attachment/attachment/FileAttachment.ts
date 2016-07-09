import {AttachmentInterface} from "./AttachmentInterface";

export interface FileAttachment extends AttachmentInterface
{
    attachment: {
        file: {
            public_path: string;
            storage_path: string;
        }
    }
}