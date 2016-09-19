import {PostRESTService} from "./service/PostRESTService";
import {PostTypeService} from "./service/PostTypeService";
import {PostCard} from "./component/Forms/PostCard/index";
import {PostForm} from "./component/Forms/PostForm/index";
import {PostFormLinkInput} from "./component/Forms/PostFormLinkInput/index";

export const CASSPostModule = {
    declarations: [
        PostCard,
        PostForm,
        PostFormLinkInput,
    ],
    providers: [
        PostRESTService,
        PostTypeService,
    ],
};