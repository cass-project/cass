import {ProfileComponent} from "./component/Elements/Profile/index";
import {ProfileModals} from "./component/Elements/Profile/modals";
import {ProfileCard} from "./component/Elements/ProfileCard/index";
import {ProfileCachedIdentityMap} from "./service/ProfileCachedIdentityMap";
import {ProfileRESTService} from "./service/ProfileRESTService";
import {ProfileRoute} from "./route/ProfileRoute/index";
import {ProfileDashboardRoute} from "./route/ProfileDashboardRoute/index";
import {ProfileNotFoundRoute} from "./route/ProfileNotFoundRoute/index";
import {ProfileCollectionsRoute} from "./route/ProfileCollectionsRoute/index";
import {ProfileCollectionsListRoute} from "./route/ProfileCollectionsListRoute/index";
import {ProfileCollectionRoute} from "./route/ProfileCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "./route/ProfileCollectionNotFoundRoute/index";
import {ProfileSetup} from "./component/Modals/ProfileSetup/index";
import {ProfileInterestsModal} from "./component/Modals/ProfileInterests/index";
import {ProfileModal} from "./component/Modals/ProfileModal/index";
import {ProfileSwitcher} from "./component/Modals/ProfileSwitcher/index";
import {ProfileSetupScreenGreetings} from "./component/Modals/ProfileSetup/Screen/ProfileSetupScreenGreetings/index";
import {ProfileSetupScreenGender} from "./component/Modals/ProfileSetup/Screen/ProfileSetupScreenGender/index";
import {ProfileSetupScreenImage} from "./component/Modals/ProfileSetup/Screen/ProfileSetupScreenImage/index";
import {ProfileSetupScreenInterests} from "./component/Modals/ProfileSetup/Screen/ProfileSetupScreenInterests/index";
import {ProfileSetupScreenExpertIn} from "./component/Modals/ProfileSetup/Screen/ProfileSetupScreenExpertIn/index";
import {ProfileImage} from "./component/Elements/ProfileImage/index";
import {ProfileModuleAccountTab} from "./component/Modals/ProfileModal/Tab/Account/index";
import {ProfileModalImageTab} from "./component/Modals/ProfileModal/Tab/Image/index";
import {ProfileModalInterestsTab} from "./component/Modals/ProfileModal/Tab/Interests/index";
import {ProfileModalPersonalTab} from "./component/Modals/ProfileModal/Tab/Personal/index";
import {ProfileModalProfilesTab} from "./component/Modals/ProfileModal/Tab/Profiles/index";
import {ProfileCardHeader} from "./component/Elements/ProfileCardHeader/index";
import {ProfileMenuOther} from "./component/Elements/ProfileMenuOther/index";
import {ProfileMenuOwn} from "./component/Elements/ProfileMenuOwn/index";
import {ProfileResolve} from "./resolve/ProfileResolve";

export const CASSProfileModule = {
    declarations: [
        ProfileComponent,
        ProfileCard,
        ProfileCardHeader,
        ProfileSetup,
        [
            ProfileSetupScreenGreetings,
            ProfileSetupScreenGender,
            ProfileSetupScreenImage,
            ProfileSetupScreenInterests,
            ProfileSetupScreenExpertIn,
        ],
        ProfileInterestsModal,
        ProfileModal,
        [
            ProfileModuleAccountTab,
            ProfileModalImageTab,
            ProfileModalInterestsTab,
            ProfileModalPersonalTab,
            ProfileModalProfilesTab,
        ],
        ProfileSwitcher,
        ProfileImage,
        ProfileMenuOther,
        ProfileMenuOwn,
    ],
    routes: [
        ProfileRoute,
        ProfileDashboardRoute,
        ProfileNotFoundRoute,
        ProfileCollectionsRoute,
        ProfileCollectionsListRoute,
        ProfileCollectionRoute,
        ProfileCollectionNotFoundRoute,
    ],
    providers: [
        ProfileModals,
        ProfileCachedIdentityMap,
        ProfileRESTService,
        ProfileResolve,
    ]
};