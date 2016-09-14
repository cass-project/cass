import {Module} from "../common/classes/Module";

import {ProfileIMService} from "./service/ProfileIMService";
import {ProfileIMRoute} from "./route/ProfileIMRoute/index";

export = new Module({
    providers: [
        ProfileIMService,
    ],
});