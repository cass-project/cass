import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {AddCollectionModal, AddCollectionModalService} from "../../../collection/component/AddCollectionModal/index";
import {CollectionService} from "../../../collection/service/CollectionService";

@Component({
    selector: 'profile-menu',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CollectionService,
        AddCollectionModalService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        AddCollectionModal
    ]
})
export class ProfileMenu
{
    constructor(private service: CollectionService, private addCollectionModal: AddCollectionModalService) {
        console.log(service.collections);
    }
    
    isCollectionManagerAvailable() {
        return true; //.
    }
}