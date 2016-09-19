import {Attachment} from "./component/Elements/Attachment/index";
import {AttachmentError} from "./component/Elements/AttachmentError/index";
import {AttachmentLinkImage} from "./component/Elements/AttachmentLinkImage/index";
import {AttachmentLinkPage} from "./component/Elements/AttachmentLinkPage/index";
import {AttachmentLinkUnknown} from "./component/Elements/AttachmentLinkUnknown/index";
import {AttachmentLinkWebm} from "./component/Elements/AttachmentLinkWebm/index";
import {AttachmentLinkYouTube} from "./component/Elements/AttachmentLinkYouTube/index";
import {AttachmentRESTService} from "./service/AttachmentRESTService";

export const CASSAttachmentModule = {
    declarations: [
        Attachment,
        AttachmentError,
        AttachmentLinkImage,
        AttachmentLinkPage,
        AttachmentLinkUnknown,
        AttachmentLinkWebm,
        AttachmentLinkYouTube,
    ],
    providers: [
        AttachmentRESTService,
    ]
};