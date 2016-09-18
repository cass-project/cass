import {NgModule} from '@angular/core';

import {CollectionRESTService} from "./service/CollectionRESTService";
import {CollectionCard} from "./component/Elements/CollectionCard/index";
import {CollectionImage} from "./component/Elements/CollectionImage/index";
import {CollectionSelect} from "./component/Elements/CollectionSelect/index";
import {CollectionsList} from "./component/Elements/CollectionsList/index";
import {CreateCollectionCard} from "./component/Elements/CreateCollectionCard/index";
import {CollectionCreateMaster} from "./component/Modal/CollectionCreateMaster/index";
import {CollectionSettings} from "./component/Modal/CollectionSettings/index";
import {DeleteCollectionModal} from "./component/Modal/DeleteCollectionModal/index";

@NgModule({
    declarations: [
        CollectionCard,
        CollectionImage,
        CollectionSelect,
        CollectionsList,
        CreateCollectionCard,
        CollectionCreateMaster,
        CollectionSettings,
        DeleteCollectionModal,
    ],
    providers: [
        CollectionRESTService,
    ]
})
export class CASSCollectionModule {}