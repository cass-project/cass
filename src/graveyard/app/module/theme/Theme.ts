export class Theme
{
    id: number;
    parent_id: number;
    position: number;
    title: string;
    show:boolean;
}

export class ThemeTree
{
    id: number;
    parent_id: number;
    position: number;
    title: string;
    children: ThemeTree[];
}