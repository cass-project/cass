import {FeedCollectionStream} from "./component/stream/FeedCollectionStream/index";
import {FeedCommunityStream} from "./component/stream/FeedCommunityStream/index";
import {FeedPostStream} from "./component/stream/FeedPostStream/index";
import {FeedProfileStream} from "./component/stream/FeedProfileStream/index";
import {FeedScrollDetector} from "./component/FeedScrollDetector/index";
import {FeedRESTService} from "./service/FeedRESTService";
import {FeedScrollService} from "./component/FeedScrollDetector/service";

export const CASSFeedModule = {
    declarations: [
        FeedScrollDetector,
        FeedCollectionStream,
        FeedCommunityStream,
        FeedPostStream,
        FeedProfileStream,
    ],
    providers: [
        FeedRESTService,
        FeedScrollService,
    ]
};