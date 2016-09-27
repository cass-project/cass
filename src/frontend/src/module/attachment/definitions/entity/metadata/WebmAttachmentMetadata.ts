import {AttachmentMetadata} from "../AttachmentEntity";

export interface WebmAttachmentMetadata extends AttachmentMetadata
{
    type: string;
    preview: {
        public: string;
        storage: string;
    }
}