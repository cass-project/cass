import {ContentPlayerService} from "./service/ContentPlayerService/service";
import {ContentPlayer} from "./component/ContentPlayer/index";
import {ContentPlayerPlaylist} from "./component/ContentPlayerPlaylist/index";
import {YoutubeItem} from "./component/ContentPlayerPlaylist/item/YoutubeItem/index";
import {WebmItem} from "./component/ContentPlayerPlaylist/item/WebmItem/index";

export const CASSPlayerModule = {
    declarations: [
        ContentPlayer,
        ContentPlayerPlaylist,
        WebmItem,
        YoutubeItem,
    ],
    providers: [
        ContentPlayerService,
    ],
};