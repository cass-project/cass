export interface OpenGraphEntity
{
    basic: {
        title: string;
        description: string;
        url: string;
    },
    og: {
        basic: {
            "og:title": string,
            "og:type": string,
            "og:description": string,
            "og:determiner": string,
            "og:url": string,
            "og:locale": string,
            "og:locale:alternate": string,
            "og:site_name": string,
        },
        images: {
            "og:image:url": string;
            "og:image:secure_url": string;
            "og:image:type": string;
            "og:image:width": string;
            "og:image:height": string;
        }[],
        videos: {
            "og:video:url": string;
            "og:video:secure_url": string;
            "og:video:type": string;
            "og:video:width": string;
            "og:video:height": string;
        }[],
        audios: {
            "og:audio:url": string;
            "og:audio:secure_url": string;
            "og:audio:type": string;
        }[]
    }
}