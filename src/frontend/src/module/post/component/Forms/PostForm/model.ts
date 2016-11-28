import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";
import {CreatePostRequest} from "../../../definitions/paths/create";

export class PostFormModel
{
    public title: string = '';
    public content: string = '';
    public attachments: AttachmentEntity<any>[] = [];

    private titleWasProvidedByAttachment: boolean = true;

    constructor(
        public postType: number,
        public profileId: number,
        public collectionId: number
    ) {}

    createRequest(): CreatePostRequest {
        return {
            post_type: this.postType,
            profile_id: this.profileId,
            collection_id: this.collectionId,
            content: this.content,
            title: this.title,
            attachments: this.attachments.map((attachment) => {
                return attachment.id;
            }),
        }
    }

    reset() {
        this.content = '';
        this.deleteAttachments();
    }

    isEmpty(): boolean {
        let testHasContent = this.content.length > 0;
        let testHasAttachments = this.attachments.length > 0;

        return ! (testHasContent || testHasAttachments);
    }

    isValid(): boolean {
        return ! this.isEmpty();
    }

    hasTitle(): boolean {
        return (typeof this.title === "string")
            && this.title.length > 0;
    }

    hasAttachments(): boolean
    {
        return this.attachments.length > 0;
    }

    getAllAttachments(): AttachmentEntity<any>[]
    {
        return this.attachments;
    }

    getAttachment(): AttachmentEntity<any>
    {
        return this.attachments[0];
    }

    addAttachment(attachment: AttachmentEntity<any>) {
        this.attachments = [];
        this.attachments.push(attachment);

        if(! this.hasTitle()) {
            this.title = attachment.title;
            this.titleWasProvidedByAttachment = true;
        }
    }

    deleteAttachments() {
        if(this.attachments.length > 0) {
            let attachment = this.attachments[0];

            if(this.titleWasProvidedByAttachment && this.title === attachment.title) {
                this.title = '';
                this.titleWasProvidedByAttachment = false;
            }
        }

        this.attachments = [];
    }
}