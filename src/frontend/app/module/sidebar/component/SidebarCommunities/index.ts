import {Component} from "angular2/core";

@Component({
    selector: 'cass-sidebar-communities',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarCommunities
{
    private isSwitchedCommunityBookmarks: boolean = true;

    isSwitched() {
        return this.isSwitchedCommunityBookmarks;
    }

    switchCommunityBookmarks() {
        this.isSwitchedCommunityBookmarks = !this.isSwitchedCommunityBookmarks;
    }
}