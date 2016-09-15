import {NgModule, CUSTOM_ELEMENTS_SCHEMA, SecurityContext, Injectable} from '@angular/core';
import {BrowserModule, DomSanitizer} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from "@angular/http";
import {App}   from './app.component';
import {routing, appRoutingProviders} from "./app.routing";
import {MessageBusNotifications} from "../../module/message/component/MessageBusNotifications/index";
import {AuthComponent} from "../../module/auth/component/Auth/index";
import {ProgressLock} from "../../module/form/component/ProgressLock/index";
import {CommunityHeader} from "../../module/community/component/Elements/CommunityHeader/index";
import {SidebarProfileIcon} from "../../module/sidebar/component/SidebarProfileIcon/index";
import {SidebarCommunities} from "../../module/sidebar/component/SidebarCommunities/index";
import {SidebarMessages} from "../../module/sidebar/component/SidebarMessages/index";
import {ProfileImage} from "../../module/profile/component/Elements/ProfileImage/index";
import {ProfileHeader} from "../../module/profile/component/Elements/ProfileHeader/index";
import {FeedProfileStream} from "../../module/feed/component/stream/FeedProfileStream/index";
import {NothingFound} from "../../module/public/component/Elements/NothingFound/index";
import {FeedPostStream} from "../../module/feed/component/stream/FeedPostStream/index";
import {FeedCommunityStream} from "../../module/feed/component/stream/FeedCommunityStream/index";
import {FeedCollectionStream} from "../../module/feed/component/stream/FeedCollectionStream/index";
import {ThemeCriteria} from "../../module/public/component/Criteria/ThemeCriteria/index";
import {QueryStringCriteria} from "../../module/public/component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "../../module/public/component/Criteria/SeekCriteria/index";
import {ContentTypeCriteria} from "../../module/public/component/Criteria/ContentTypeCriteria/index";
import {SourceSelector} from "../../module/public/component/Elements/SourceSelector/index";
import {OptionView} from "../../module/public/component/Options/ViewOption/index";
import {ProfileCardsList} from "../../module/profile/component/Elements/ProfileCardsList/index";
import {PostForm} from "../../module/post/component/Forms/PostForm/index";
import {CollectionsList} from "../../module/collection/component/Elements/CollectionsList/index";
import {ProfileComponent} from "../../module/profile/index";
import {ModalComponent} from "../../module/modal/component/index";
import {ModalBoxComponent} from "../../module/modal/component/box/index";
import {LoadingLinearIndicator} from "../../module/form/component/LoadingLinearIndicator/index";
import {ProfileSetupScreenGreetings} from "../../module/profile/component/Modals/ProfileSetup/Screen/ProfileSetupScreenGreetings/index";
import {ProfileSetupScreenGender} from "../../module/profile/component/Modals/ProfileSetup/Screen/ProfileSetupScreenGender/index";
import {ProfileSetupScreenImage} from "../../module/profile/component/Modals/ProfileSetup/Screen/ProfileSetupScreenImage/index";
import {ProfileSetupScreenInterests} from "../../module/profile/component/Modals/ProfileSetup/Screen/ProfileSetupScreenInterests/index";
import {ProfileSetupScreenExpertIn} from "../../module/profile/component/Modals/ProfileSetup/Screen/ProfileSetupScreenExpertIn/index";
import {ThemeSelect} from "../../module/theme/component/ThemeSelect/index";
import {ProfileModal} from "../../module/profile/component/Modals/ProfileModal/index";
import {ProfileSwitcher} from "../../module/profile/component/Modals/ProfileSwitcher/index";
import {ProfileInterestsModal} from "../../module/profile/component/Modals/ProfileInterests/index";
import {ProfileSetup} from "../../module/profile/component/Modals/ProfileSetup/index";
import {CollectionCreateMaster} from "../../module/collection/component/Modal/CollectionCreateMaster/index";
import {UploadImageModal} from "../../module/form/component/UploadImage/index";
import {AccountTab} from "../../module/profile/component/Modals/ProfileModal/Tab/Account/index";
import {PersonalTab} from "../../module/profile/component/Modals/ProfileModal/Tab/Personal/index";
import {ImageTab} from "../../module/profile/component/Modals/ProfileModal/Tab/Image/index";
import {InterestsTab} from "../../module/profile/component/Modals/ProfileModal/Tab/Interests/index";
import {ProfilesTab} from "../../module/profile/component/Modals/ProfileModal/Tab/Profiles/index";
import {ProfileCard} from "../../module/profile/component/Elements/ProfileCard/index";
import {ProfileSettingsCard} from "../../module/profile/component/Elements/ProfileSettingsCard/index";
import {ProfileCreateCollectionCard} from "../../module/profile/component/Elements/ProfileCreateCollectionCard/index";
import {ProfileInterestsCard} from "../../module/profile/component/Elements/ProfileInterestsCard/index";
import {IMAttachments} from "../../module/im/component/IMAttachments/index";
import {IMChat} from "../../module/im/component/IMChat/index";
import {IMTextarea} from "../../module/im/component/IMTextarea/index";
import {ProfileIMSidebar} from "../../module/profile-im/component/Elements/ProfileIMSidebar/index";
import {ProfileCardHeader} from "../../module/profile/component/Elements/ProfileCardHeader/index";
import {PostAttachment} from "../../module/post-attachment/component/Elements/PostAttachment/index";
import {PostFormLinkInput} from "../../module/post/component/Forms/PostFormLinkInputComponent/index";
import {TabModalTab} from "../../module/form/component/TabModal/component/TabModalTab/index";
import {ImageCropper} from "../../module/form/component/ImageCropper/index";
import {PostAttachmentLinkYouTube} from "../../module/post-attachment/component/Elements/PostAttachmentLinkYouTube/index";
import {PostAttachmentLinkImage} from "../../module/post-attachment/component/Elements/PostAttachmentLinkImage/index";
import {PostAttachmentLinkPage} from "../../module/post-attachment/component/Elements/PostAttachmentLinkPage/index";
import {PostAttachmentLinkWebm} from "../../module/post-attachment/component/Elements/PostAttachmentLinkWebm/index";
import {PostAttachmentLinkUnknown} from "../../module/post-attachment/component/Elements/PostAttachmentLinkUnknown/index";
import {AttachmentError} from "../../module/post-attachment/component/Elements/Error/index";
import {FeedbackCreateModal} from "../../module/feedback/component/Modal/FeedbackCreateModal/index";
import {FeedbackCreateButton} from "../../module/feedback/component/Elements/FeedbackCreateButton/index";
import {CollectionCard} from "../../module/collection/component/Elements/CollectionCard/index";
import {LoadingIndicator} from "../../module/form/component/LoadingIndicator/index";
import {FeedScrollDetector} from "../../module/feed/component/FeedScrollDetector/index";
import {CommunityCard} from "../../module/community/component/Elements/CommunityCard/index";
import {PostCard} from "../../module/post/component/Forms/PostCard/index";
import {CommunityImage} from "../../module/community/component/Elements/CommunityImage/index";
import {CommunityCreateCollectionCard} from "../../module/community/component/Elements/CommunityCreateCollectionCard/index";
import {CommunitySettingsCard} from "../../module/community/component/Elements/CommunitySettingsCard/index";
import {CommunityCreateModalForm} from "../../module/community/component/Modal/CommunityCreateModal/Form/index";
import {ScreenGeneral} from "../../module/community/component/Modal/CommunityCreateModal/Screen/ScreenGeneral/index";
import {ScreenFeatures} from "../../module/community/component/Modal/CommunityCreateModal/Screen/ScreenFeatures/index";
import {ScreenProcessing} from "../../module/community/component/Modal/CommunityJoinModal/Screen/ScreenProcessing/index";
import {ScreenSID} from "../../module/community/component/Modal/CommunityJoinModal/Screen/ScreenSID/index";
import {GeneralTab} from "../../module/community/component/Modal/CommunitySettingsModal/Tab/TabGeneral/index";
import {FeaturesTab} from "../../module/community/component/Modal/CommunitySettingsModal/Tab/TabFeatures/index";
import {CommunityImageTab} from "../../module/community/component/Modal/CommunitySettingsModal/Tab/TabImage/index";
import {CommunityRouteModal} from "../../module/community/component/Modal/CommunityRouteModal/index";
import {CommunityCreateModal} from "../../module/community/component/Modal/CommunityCreateModal/index";
import {CommunityJoinModal} from "../../module/community/component/Modal/CommunityJoinModal/index";
import {CommunitySettingsModal} from "../../module/community/component/Modal/CommunitySettingsModal/index";
import {CommunityComponent} from "../../module/community/index";
import {CommunityCardsList} from "../../module/community/component/Elements/CommunityCardsList/index";
import {CreateCollectionCard} from "../../module/collection/component/Elements/CreateCollectionCard/index";
import {TAB_MODAL_DIRECTIVES} from "../../module/form/component/TabModal/index";
import {ColorPicker} from "../../module/form/component/ColorPicker/index";
import {CollectionImage} from "../../module/collection/component/Elements/CollectionImage/index";
import {DeleteCollectionModal} from "../../module/collection/component/Modal/DeleteCollectionModal/index";
import {CollectionSelect} from "../../module/collection/component/Elements/CollectionSelect/index";
import {SignInComponent} from "../../module/auth/component/SignIn/index";
import {SignUpComponent} from "../../module/auth/component/SignUp/index";
import {AuthDev} from "../../module/auth-dev/component/index";
import {OAuth2Component} from "../../module/auth/component/OAuth2/index";
import {AccountDeleteWarning} from "../../module/account/component/AccountDeleteWarning/index";
import {AccountComponent} from "../../module/account/index";
import {ProfileRoute} from "../../module/profile/route/ProfileRoute/index";
import {CommunityRoute} from "../../module/community/route/CommunityRoute/index";
import {PublicComponent} from "../../module/public/index";
import {FrontlineService} from "../../module/frontline/service";
import {AuthToken} from "../../module/auth/service/AuthToken";
import {Nothing} from "../../module/common/component/Nothing/index";
import {SidebarComponent} from "../../module/sidebar/index";
import {SidebarSignInButton} from "../../module/sidebar/component/SidebarSignInButton/index";
import {AuthService} from "../../module/auth/service/AuthService";
import {AuthRESTService} from "../../module/auth/service/AuthRESTService";
import {MessageBusService} from "../../module/message/service/MessageBusService/index";
import {Session} from "../../module/session/Session";
import {CommunityModalService} from "../../module/community/service/CommunityModalService";
import {ProfileCommunityBookmarksService} from "../../module/profile-communities/service/ProfileCommunityBookmarksService";
import {CommunityCreateModalNotifier} from "../../module/community/component/Modal/CommunityCreateModal/notify";
import {IMRESTService} from "../../module/im/service/IMRESTService";
import {AuthComponentService} from "../../module/auth/component/Auth/service";
import {ProfileModals} from "../../module/profile/modals";
import {ThemeService} from "../../module/theme/service/ThemeService";
import {ProfileCachedIdentityMap} from "../../module/profile/service/ProfileCachedIdentityMap";
import {ProfileRESTService} from "../../module/profile/service/ProfileRESTService";
import {ProfileSwitcherService} from "../../module/profile/component/Modals/ProfileSwitcher/service";
import {ProfileNotFoundRoute} from "../../module/profile/route/ProfileNotFoundRoute/index";
import {ProfileDashboardRoute} from "../../module/profile/route/ProfileDashboardRoute/index";
import {ProfileCollectionsRoute} from "../../module/profile/route/ProfileCollectionsRoute/index";
import {ProfileCollectionsListRoute} from "../../module/profile/route/ProfileCollectionsListRoute/index";
import {ProfileCollectionNotFoundRoute} from "../../module/profile/route/ProfileCollectionNotFoundRoute/index";
import {ProfileCollectionRoute} from "../../module/profile/route/ProfileCollectionRoute/index";
import {FeedRESTService} from "../../module/feed/service/FeedRESTService";
import {PostTypeService} from "../../module/post/service/PostTypeService";
import {PostRESTService} from "../../module/post/service/PostRESTService";
import {PostAttachmentRESTService} from "../../module/post-attachment/service/PostAttachmentRESTService";
import {CommunityCollectionRoute} from "../../module/community/route/CommunityCollectionRoute/index";
import {CommunityCollectionNotFoundRoute} from "../../module/community/route/CommunityCollectionNotFoundRoute/index";
import {CommunityCollectionsRoute} from "../../module/community/route/CommunityCollectionsRoute/index";
import {CommunityCollectionsListRoute} from "../../module/community/route/CommunityCollectionsListRoute/index";
import {CommunityDashboardRoute} from "../../module/community/route/CommunityDashboardRoute/index";
import {CommunityNotFoundRoute} from "../../module/community/route/CommunityNotFoundRoute/index";
import {ContentRoute} from "../../module/public/route/ContentRoute/index";
import {CollectionsRoute} from "../../module/public/route/CollectionsRoute/index";
import {CommunitiesRoute} from "../../module/public/route/CommunitiesRoute/index";
import {ExpertsRoute} from "../../module/public/route/ExpertsRoute/index";
import {ProfilesRoute} from "../../module/public/route/ProfilesRoute/index";

@Injectable()
export class NoSanitizationService {
    sanitize(ctx: SecurityContext, value: any): string {
        return value;
    }
}

@NgModule({
    declarations: [
        App,
        MessageBusNotifications,
        AuthComponent,
        ProgressLock,
        CommunityHeader,
        SidebarSignInButton,
        SidebarProfileIcon,
        SidebarCommunities,
        SidebarMessages,
        ProfileImage,
        ProfileHeader,
        FeedProfileStream,
        NothingFound,
        FeedPostStream,
        FeedCommunityStream,
        FeedCollectionStream,
        ThemeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        ContentTypeCriteria,
        SourceSelector,
        OptionView,
        ProfileCardsList,
        PostForm,
        CollectionsList,
        ProfileComponent,
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator,
        ProfileSetupScreenGreetings,
        ProfileSetupScreenGender,
        ProfileSetupScreenImage,
        ProfileSetupScreenInterests,
        ProfileSetupScreenExpertIn,
        ThemeSelect,
        ProfileModal,
        ProfileSwitcher,
        ProfileInterestsModal,
        ProfileSetup,
        CollectionCreateMaster,
        UploadImageModal,
        AccountTab,
        PersonalTab,
        ImageTab,
        InterestsTab,
        ProfilesTab,
        ProfileCard,
        ProfileInterestsCard,
        ProfileCreateCollectionCard,
        ProfileSettingsCard,
        IMAttachments,
        IMChat,
        IMTextarea,
        ProfileIMSidebar,
        PostAttachment,
        ProfileCardHeader,
        PostFormLinkInput,
        TabModalTab,
        ImageCropper,
        PostAttachmentLinkYouTube,
        PostAttachmentLinkImage,
        PostAttachmentLinkPage,
        PostAttachmentLinkWebm,
        PostAttachmentLinkUnknown,
        AttachmentError,
        FeedbackCreateModal,
        FeedbackCreateButton,
        CollectionCard,
        LoadingIndicator,
        FeedScrollDetector,
        CommunityCard,
        PostCard,
        ProfileCard,
        CommunityImage,
        CommunityCreateCollectionCard,
        CommunitySettingsCard,
        CommunityCreateModalForm,
        ScreenGeneral,
        ScreenFeatures,
        ScreenProcessing,
        ScreenSID,
        GeneralTab,
        CommunityImageTab,
        FeaturesTab,
        CommunityRouteModal,
        CommunityCreateModal,
        CommunityJoinModal,
        CommunitySettingsModal,
        CommunityComponent,
        CommunityCardsList,
        CreateCollectionCard,
        TAB_MODAL_DIRECTIVES,
        ColorPicker,
        CollectionImage,
        DeleteCollectionModal,
        CollectionSelect,
        SignInComponent,
        SignUpComponent,
        SidebarComponent,
        AuthDev,
        OAuth2Component,
        AccountDeleteWarning,
        AccountComponent,
        ProfileRoute,
        CommunityRoute,
        PublicComponent,
        Nothing,
        ProfileNotFoundRoute,
        ProfileDashboardRoute,
        ProfileCollectionRoute,
        ProfileCollectionsRoute,
        ProfileCollectionsListRoute,
        ProfileCollectionNotFoundRoute,
        CommunityCollectionNotFoundRoute,
        CommunityCollectionRoute,
        CommunityCollectionsRoute,
        CommunityCollectionsListRoute,
        CommunityDashboardRoute,
        CommunityNotFoundRoute,
        ContentRoute,
        CollectionsRoute,
        CommunitiesRoute,
        ExpertsRoute,
        ProfilesRoute

    ],
    schemas: [CUSTOM_ELEMENTS_SCHEMA],
    imports: [
        BrowserModule,
        routing,
        FormsModule, 
        ReactiveFormsModule,
        HttpModule
    ],
    providers: [
        AuthService,
        AuthRESTService,
        MessageBusService,
        Session,
        CommunityModalService,
        ProfileCommunityBookmarksService,
        CommunityCreateModalNotifier,
        IMRESTService,
        ProfileModals,
        ThemeService,
        ProfileCachedIdentityMap,
        ProfileRESTService,
        ProfileSwitcherService,
        AuthComponentService,
        FeedRESTService,
        PostTypeService,
        PostRESTService,
        PostAttachmentRESTService,
        appRoutingProviders,
        {provide: DomSanitizer, useClass: NoSanitizationService},
        {provide: FrontlineService, useFactory: function() {
            return window['frontline'];
        }},
        {provide: AuthToken, useFactory: () => {
            let frontline = window['frontline'];
            let token = new AuthToken();
            let hasAuth = frontline.session.auth
                && (typeof frontline.session.auth.api_key == "string")
                && (frontline.session.auth.api_key.length > 0);

            if (hasAuth) {
                let auth = frontline.session.auth;
                token.setToken(frontline.session.auth.api_key);
            }

            return token;}
        }
    ],
    bootstrap: [App]
})

export class AppModule {}

