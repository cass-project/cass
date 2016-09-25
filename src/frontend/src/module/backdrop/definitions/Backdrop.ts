export interface Backdrop<T>
{
    type: BackdropType;
    metadata: T;
}

export enum BackdropType
{
    None = <any>"none",
    Color = <any>"color",
    Preset = <any>"preset",
    Uploaded = <any>"uploaded"
}