import {ContentPlayerService} from "./service/ContentPlayerService/service";
import {ContentPlayer} from "./component/ContentPlayer/index";
import {ContentPlayerPlaylist} from "./component/ContentPlayerPlaylist/index";
import {YoutubeItem} from "./component/ContentPlayerPlaylist/item/YoutubeItem/index";
import {WebmItem} from "./component/ContentPlayerPlaylist/item/WebmItem/index";
import {ContentPlayerArea} from "./component/ContentPlayerArea/index";
import {ContentPlayerAreaWebmVideo} from "./component/ContentPlayerArea/type/WebmVideo/index";
import {ContentPlayerAreaYoutubeVideo} from "./component/ContentPlayerArea/type/YoutubeVideo/index";
import {ContentPlayerNotifier} from "./service/ContentPlayerService/notify";

export const CASSPlayerModule = {
    declarations: [
        ContentPlayer,
        ContentPlayerPlaylist,
        WebmItem,
        YoutubeItem,
        ContentPlayerArea,
        ContentPlayerAreaWebmVideo,
        ContentPlayerAreaYoutubeVideo,
    ],
    providers: [
        ContentPlayerService,
        ContentPlayerNotifier,
    ],
};