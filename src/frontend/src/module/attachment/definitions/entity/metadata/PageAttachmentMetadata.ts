import {AttachmentMetadata} from "../AttachmentEntity";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface PageAttachmentMetadata extends AttachmentMetadata {
    og: OpenGraphEntity;
}