import {Component, ContentChildren, QueryList, Input} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {TabModalTab} from "./component/TabModalTab/index";
import {TabModalHeader} from "./component/TabModalHeader/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-tab-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        TabModalTab,
        ThemeSelect,
    ]
})
export class TabModal
{
    @Input('min-height') minHeight: string = '200';

    @ContentChildren(TabModalTab) tabs: QueryList<TabModalTab>;
    
    private active: TabModalTab;

    ngAfterContentInit() {
        if(this.tabs.length > 0) {
            this.tabs.forEach((tab: TabModalTab) => {
                if(tab.forceActive) {
                    this.active = tab;
                }
            });

            if(! this.active) {
                this.selectTab(this.tabs.first);
            }
        }
    }

    public selectTab(tab: TabModalTab) {
        this.active = tab;

        this.tabs.forEach((tab: TabModalTab) => {
            tab.active = this.active === tab;
        });
    }

    public selected(): TabModalTab {
        if(this.active === null) {
            if(this.tabs.length > 0) {
                return this.tabs[0];
            }else{
                throw new Error('No tabs');
            }
        }else{
            return this.active;
        }
    }

    isActive(tab: TabModalTab) {
        return this.active === tab;
    }

    public getTopTabs() {
        return this.tabs.filter((tab: TabModalTab) => {
            return tab.position === "top";
        });
    }

    public getBottomTabs() {
        return this.tabs.filter((tab: TabModalTab) => {
            return tab.position === "bottom";
        });
    }
}

export const TAB_MODAL_DIRECTIVES = [
    TabModal,
    TabModalTab,
    TabModalHeader,
];