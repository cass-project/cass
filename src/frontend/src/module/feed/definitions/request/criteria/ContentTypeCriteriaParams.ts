export enum ContentType
{
    None = <any>"none",
    All = <any>"all",
    Text = <any>"text",
    Video = <any>"video",
    Audio = <any>"audio",
    Image = <any>"image",
    Link = <any>"link"
}

export interface ContentTypeCriteriaParams
{
    type: ContentType;
}