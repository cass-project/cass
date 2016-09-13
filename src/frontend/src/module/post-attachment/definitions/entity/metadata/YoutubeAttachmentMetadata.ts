import {AttachmentMetadata} from "../PostAttachment";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface YoutubeAttachmentMetadata extends AttachmentMetadata {
    youtubeId: string;
    og: OpenGraphEntity;
}