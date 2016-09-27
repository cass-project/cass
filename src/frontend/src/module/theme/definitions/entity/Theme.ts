export interface Theme
{
    id: number;
    title: string;
    description: string;
    parent_id: number;
    position: number;
    preview: string;
    children?: Theme[];
}

export const THEME_PREVIEW_PUBLIC_PREFIX = '/storage/entity/themes/preview';