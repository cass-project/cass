import {Component, Input, Output, EventEmitter} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";
import {PostRESTService} from "../../../service/PostRESTService";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";


@Component({
    selector: 'cass-delete-post',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class DeletePost
{
    @Input('post') post: PostEntity;
    @Output('close') close: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('submitDelete') submitDelete: EventEmitter<number> = new EventEmitter<number>();

    private status: LoadingManager = new LoadingManager();

    constructor(
        private service: PostRESTService
    ) {}
    
    submit(){
        let loading = this.status.addLoading();

        this.service.deletePost(this.post.id).subscribe(success => {
            console.log('test');
            this.submitDelete.emit(this.post.id);
            loading.is = false;
            this.closeModal();
        }, error => {
            loading.is = false;
            this.closeModal();
        });
    }

    isLoading(): boolean {
        return this.status.isLoading();
    }

    closeModal(){
        console.log('close');
        this.close.emit(true);
    }
}