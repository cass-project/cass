import {AttachmentMetadata} from "../PostAttachment";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface UnknownAttachmentMetadata extends AttachmentMetadata {
    og: OpenGraphEntity;
}