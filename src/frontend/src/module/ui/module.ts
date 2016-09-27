import {SidebarComponent} from "./sidebar/component/Sidebar/index";
import {RightSidebar} from "./sidebar/component/RightSidebar/index";
import {UIService} from "./service/ui";
import {CASSHeader} from "./header/component/CASSHeader/index";
import {CASSHeaderSwitcher} from "./header/component/CASSHeader/component/CASSHeaderSwitcher/index";
import {CASSHeaderExtendedSwitcher} from "./header/component/CASSHeader/component/CASSHeaderExtendedSwitcher/index";
import {UISearchComponent} from "./search/index";
import {UINavigationObservable} from "./service/navigation";
import {UISearchObservable} from "./search/observable";

export const CASSUIModule = {
    declarations: [
        SidebarComponent,
        RightSidebar,
        CASSHeader,
        [
            CASSHeaderSwitcher,
            CASSHeaderExtendedSwitcher,
        ],
        UISearchComponent,
    ],
    providers: [
        UIService,
        UINavigationObservable,
        UISearchObservable,
    ],
};