import {PostRESTService} from "./service/PostRESTService";
import {PostTypeService} from "./service/PostTypeService";
import {PostForm} from "./component/Forms/PostForm/index";
import {PostFormLinkInput} from "./component/Forms/PostFormLinkInput/index";
import {PostPlayerService} from "./component/Modals/PostPlayer/service";
import {PostPlayer} from "./component/Modals/PostPlayer/index";
import {PostComponent} from "./component/Elements/Post/index";
import {POST_CARD_DIRECTIVES} from "./component/Elements/PostCard/index";

export const CASSPostModule = {
    declarations: [
        PostComponent,
        POST_CARD_DIRECTIVES,
        PostForm,
        PostFormLinkInput,
        PostPlayer,
    ],
    providers: [
        PostRESTService,
        PostTypeService,
        PostPlayerService,
    ],
};