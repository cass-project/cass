import {PostRESTService} from "./service/PostRESTService";
import {PostTypeService} from "./service/PostTypeService";
import {PostForm} from "./component/Forms/PostForm/index";
import {PostFormLinkInput} from "./component/Forms/PostFormLinkInput/index";
import {PostPlayerService} from "./component/Modals/PostPlayer/service";
import {PostPlayer} from "./component/Modals/PostPlayer/index";
import {PostComponent} from "./component/Elements/Post/index";
import {POST_CARD_DIRECTIVES} from "./component/Elements/PostCard/index";
import {TextParser} from "../common/component/TextParser/index";
import {POST_LIST_DIRECTIVES} from "./component/Elements/PostList/index";
import {PostPlayerCard} from "./component/Modals/PostPlayerCard/index";

export const CASSPostModule = {
    declarations: [
        PostComponent,
        POST_CARD_DIRECTIVES,
        POST_LIST_DIRECTIVES,
        PostForm,
        PostFormLinkInput,
        PostPlayer,
        PostPlayerCard,
    ],
    providers: [
        PostRESTService,
        PostTypeService,
        PostPlayerService,
        TextParser
    ],
};