import {AttachmentMetadata} from "../AttachmentEntity";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface YoutubeAttachmentMetadata extends AttachmentMetadata
{
    youtubeId: string;
    og: OpenGraphEntity;
}