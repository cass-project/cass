import {Component, Input} from "angular2/core";

import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {CurrentProfileService} from "../../../../profile/service/CurrentProfileService";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostRESTService} from "../../../service/PostRESTService";
import {CreatePostRequest} from "../../../definitions/paths/create";
import {PostTypeEntity} from "../../../definitions/entity/PostType";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock,
    ]
})
export class PostForm
{
    static DEFAULT_POST_TYPE = 'default';

    @Input('post-type') postType: PostTypeEntity;
    @Input('collection') collection: CollectionEntity;

    private status: LoadingStatus[] = [];
    private model: PostFormModel;

    constructor(
        private profile: CurrentProfileService,
        private service: PostRESTService
    ) {}

    ngOnInit() {
        this.model = new PostFormModel(
            this.postType.int,
            this.profile.get().getId(),
            this.collection.id
        );
    }

    isLoading() {
        return this.status.filter((input: LoadingStatus) => {
            return input.loading === true;
        }).length > 0;
    }

    submit() {
        var status = new LoadingStatus();

        this.status.push(status);
        this.service.createPost(this.model.createRequest()).subscribe(
            (response) => {
                status.loading = false;
                this.reset();
            },
            (error) => {
                status.loading = false;
            }
        )
    }

    reset() {
        this.model.reset();
    }
}

class PostFormModel
{
    public content: string = '';

    constructor(
        public postType: number,
        public profileId: number,
        public collectionId: number
    ) {}

    reset() {
        this.content = '';
    }
    
    isValid(): boolean {
        let testHasContent = this.content.length > 0;
        
        return testHasContent;
    }

    createRequest(): CreatePostRequest {
        // ...
        return {
            post_type: this.postType,
            profile_id: this.profileId,
            collection_id: this.collectionId,
            content: this.content,
            attachments: [],
            links: []
        }
    }
}

class LoadingStatus
{
    public loading: boolean = true;
}