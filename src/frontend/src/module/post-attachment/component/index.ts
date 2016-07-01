import {Component, Input, Output, EventEmitter, Injectable} from "angular2/core";
import {PostEntity} from "../definitions/entity/Post";
import {CreatePostRequest} from "../definitions/paths/create";
import {CurrentAccountService} from "../../auth/service/CurrentAccountService";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

@Injectable()
export class PostForm
{
    constructor(private currentAccountService: CurrentAccountService)
    {
        this.postEntity.author_profile_id = this.currentAccountService.getCurrentProfile().getId();
    }

    attachFile: boolean = false;

    @Input('collectionId') collectionId;

    @Output('postEvent') postEvent = new EventEmitter<PostEntity>();

    postEntity: PostEntity;

    submit()
    {
        this.postEntity.date_created_on = new Date().toLocaleDateString();

    }

    openAttachModal()
    {
        this.attachFile = true;
    }
}