export interface Theme
{
    id: number;
    parent_id: number;
    position: number;
    title: string;
    show:boolean;
}

export interface ThemeTree
{
    id: number;
    parent_id: number;
    position: number;
    title: string;
    children: ThemeTree[];
}