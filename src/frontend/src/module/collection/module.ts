import {CollectionRESTService} from "./service/CollectionRESTService";
import {CollectionCard} from "./component/Elements/CollectionCard/index";
import {CollectionImage} from "./component/Elements/CollectionImage/index";
import {CollectionSelect} from "./component/Elements/CollectionSelect/index";
import {CreateCollectionCard} from "./component/Elements/CreateCollectionCard/index";
import {CollectionCreateMaster} from "./component/Modal/CollectionCreateMaster/index";
import {CollectionSettings} from "./component/Modal/CollectionSettings/index";
import {DeleteCollectionModal} from "./component/Modal/DeleteCollectionModal/index";
import {CollectionHeader} from "./component/Elements/CollectionHeader/index";

export const CASSCollectionModule = {
    declarations: [
        CollectionCard,
        CollectionImage,
        CollectionSelect,
        CreateCollectionCard,
        CollectionCreateMaster,
        CollectionSettings,
        DeleteCollectionModal,
        CollectionHeader,
    ],
    providers: [
        CollectionRESTService,
    ]
};