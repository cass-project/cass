import {AttachmentMetadata} from "../AttachmentEntity";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface UnknownAttachmentMetadata extends AttachmentMetadata {
    og: OpenGraphEntity;
}