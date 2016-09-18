import {CASSAccountModule} from "./account/module";
import {CASSAttachmentModule} from "./attachment/module";
import {CASSCommunityModal} from "./community/module";
import {CASSAvatarModule} from "./avatar/module";
import {CASSCollectionModule} from "./collection/module";
import {CASSColorsModule} from "./colors/module";
import {CASSCommonModule} from "./common/module";
import {CASSSidebarModule} from "./sidebar/module";
import {CASSFrontlineModule} from "./frontline/module";
import {CASSSessionModule} from "./session/module";
import {CASSAuthModule} from "./auth/module";
import {CASSThemeModule} from "./theme/module";
import {CASSOpenGraphModule} from "./opengraph/module";
import {CASSPostModule} from "./post/module";
import {CASSFeedModule} from "./feed/module";
import {CASSPublicComponent} from "./public/module";

export const CASS_MODULES = [
    CASSAccountModule,
    CASSAuthModule,
    CASSAttachmentModule,
    CASSAvatarModule,
    CASSCommunityModal,
    CASSCollectionModule,
    CASSColorsModule,
    CASSCommonModule,
    CASSSidebarModule,
    CASSFrontlineModule,
    CASSSessionModule,
    CASSThemeModule,
    CASSOpenGraphModule,
    CASSPostModule,
    CASSFeedModule,
    CASSPublicComponent,
];