import {AttachmentMetadata} from "../PostAttachment";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface PageAttachmentMetadata extends AttachmentMetadata {
    og: OpenGraphEntity;
}